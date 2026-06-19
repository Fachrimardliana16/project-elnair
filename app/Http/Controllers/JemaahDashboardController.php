<?php

namespace App\Http\Controllers;

use App\Models\Jamaah;
use App\Models\Payment;
use App\Models\RoomMember;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JemaahDashboardController extends Controller
{
    /**
     * Show the Jemaah dashboard homepage.
     *
     * @return View
     */
    public function index(Request $request)
    {
        $jemaah = $request->get('jemaah');

        // Real-time countdown to departure date
        $countdown = null;
        if ($jemaah->departureSchedule && $jemaah->departureSchedule->departure_date) {
            $departureDate = Carbon::parse($jemaah->departureSchedule->departure_date);
            $now = Carbon::today();
            $countdown = $now->diffInDays($departureDate, false);
        }

        // Room and Roommate assignments
        $roomMember = RoomMember::with('room')->where('jamaah_id', $jemaah->id)->first();
        $room = null;
        $roommates = collect();

        if ($roomMember) {
            $room = $roomMember->room;
            if ($room) {
                $roommates = Jamaah::whereIn('id', function ($query) use ($room) {
                    $query->select('jamaah_id')
                        ->from('room_members')
                        ->where('room_id', $room->id);
                })->where('id', '!=', $jemaah->id)->get();
            }
        }

        return view('landing.jemaah.dashboard', compact('jemaah', 'countdown', 'room', 'roommates'));
    }

    /**
     * Show the Jemaah profile details.
     *
     * @return View
     */
    public function profile(Request $request)
    {
        $jemaah = $request->get('jemaah');

        return view('landing.jemaah.profile', compact('jemaah'));
    }

    /**
     * Show financial summary and payment list.
     *
     * @return View
     */
    public function payments(Request $request)
    {
        $jemaah = $request->get('jemaah');

        $rawPrice = $jemaah->package ? $jemaah->package->price_value : '0';
        $priceNumber = (float) preg_replace('/[^0-9]/', '', $rawPrice);
        if (str_contains(strtolower($rawPrice), 'jt') || str_contains(strtolower($rawPrice), 'juta')) {
            $priceNumber *= 1000000;
        }
        $price = $priceNumber;

        $totalPaid = (float) $jemaah->payments()->where('status', 'Approved')->sum('amount');
        $outstanding = max(0.0, $price - $totalPaid);

        $payments = $jemaah->payments()->orderBy('payment_date', 'desc')->get();

        return view('landing.jemaah.payments', compact('jemaah', 'price', 'totalPaid', 'outstanding', 'payments'));
    }

    /**
     * Process new payment proof upload.
     *
     * @return RedirectResponse
     */
    public function uploadPayment(Request $request)
    {
        $jemaah = $request->get('jemaah');

        // Guard: payment is locked if status is Pending
        if ($jemaah->status === 'Pending') {
            return redirect()->route('jemaah.payments')
                ->with('error', 'Pendaftaran Anda masih berstatus Pending. Pilihan pembayaran hanya tersedia jika pendaftaran sudah disetujui (di-ACC) oleh admin.');
        }

        $request->validate([
            'type' => 'required|in:DP,Cicilan 1,Cicilan 2,Pelunasan',
            'amount' => 'required|numeric|min:1',
            'payment_date' => 'required|date',
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png|max:5120',
        ], [
            'type.required' => 'Jenis pembayaran wajib dipilih.',
            'amount.required' => 'Nominal transfer wajib diisi.',
            'payment_date.required' => 'Tanggal transfer wajib diisi.',
            'payment_proof.required' => 'File bukti transfer wajib diunggah.',
            'payment_proof.image' => 'File bukti transfer harus berupa gambar (JPG/PNG).',
            'payment_proof.max' => 'Ukuran file bukti transfer maksimal 5MB.',
        ]);

        $proofPath = null;
        if ($request->hasFile('payment_proof')) {
            $proofPath = $request->file('payment_proof')->store('payment_proofs', 'public');
        }

        Payment::create([
            'jamaah_id' => $jemaah->id,
            'type' => $request->type,
            'amount' => $request->amount,
            'payment_date' => $request->payment_date,
            'payment_proof' => $proofPath,
            'status' => 'Pending',
        ]);

        return redirect()->route('jemaah.payments')
            ->with('success', 'Bukti pembayaran berhasil diunggah. Tim admin kami akan melakukan verifikasi secepatnya.');
    }

    /**
     * Show document lists and update form.
     *
     * @return View
     */
    public function documents(Request $request)
    {
        $jemaah = $request->get('jemaah');

        return view('landing.jemaah.documents', compact('jemaah'));
    }

    /**
     * Process document upload/replacement.
     *
     * @return RedirectResponse
     */
    public function uploadDocument(Request $request)
    {
        $jemaah = $request->get('jemaah');

        $request->validate([
            'document_type' => 'required|in:ktp_file,passport_file,kk_file,vaccine_file,photo_file',
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ], [
            'document_type.required' => 'Jenis dokumen wajib ditentukan.',
            'file.required' => 'Silakan pilih file dokumen terlebih dahulu.',
            'file.mimes' => 'Format file harus berupa JPG, PNG, atau PDF.',
            'file.max' => 'Ukuran file dokumen maksimal 5MB.',
        ]);

        $type = $request->document_type;

        if ($request->hasFile('file')) {
            // Store file
            $filePath = $request->file('file')->store('jamaah_docs', 'public');

            // Update Jamaah instance
            $jemaah->update([
                $type => $filePath,
            ]);
        }

        return redirect()->route('jemaah.documents')
            ->with('success', 'Dokumen Anda berhasil diunggah dan diperbarui.');
    }
}
