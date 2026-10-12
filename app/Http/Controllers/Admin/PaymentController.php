<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jamaah;
use App\Models\Payment;
use App\Support\JamaahFileStorage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('jamaah.package')->latest()->paginate(10);

        $jamaahs = Jamaah::with(['package', 'departureSchedule'])
            ->withSum(['payments as approved_payments_sum' => fn ($query) => $query->where('status', 'Approved')], 'amount')
            ->whereNotNull('package_id')
            ->latest()
            ->paginate(25, ['*'], 'outstanding_page');

        $outstandingList = $jamaahs->getCollection()
            ->map(function (Jamaah $j) {
                $packagePrice = $j->package ? $j->package->price_numeric : 0;
                $totalPaid = (float) ($j->approved_payments_sum ?? 0);
                $balance = max(0.0, $packagePrice - $totalPaid);

                return [
                    'jamaah' => $j,
                    'package_price' => $packagePrice,
                    'total_paid' => $totalPaid,
                    'balance' => $balance,
                    'due_date' => $j->created_at->copy()->addDays(30),
                ];
            })
            ->filter(fn ($item) => $item['balance'] > 0);

        return view('admin.payment.index', compact('payments', 'outstandingList'));
    }

    public function create(Request $request)
    {
        $selectedJamaah = null;
        if ($request->has('jamaah_id')) {
            $selectedJamaah = Jamaah::with('package')->findOrFail($request->jamaah_id);
        }

        $jamaahs = Jamaah::where('status', '!=', 'Selesai')->get();

        return view('admin.payment.create', compact('jamaahs', 'selectedJamaah'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jamaah_id' => 'required|exists:jamaahs,id',
            'type' => 'required|in:DP,Cicilan 1,Cicilan 2,Pelunasan',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'payment_proof' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['jamaah_id', 'type', 'amount', 'payment_date']);
        $data['status'] = 'Approved'; // Directly approve manual/admin payments

        if ($request->hasFile('payment_proof')) {
            $path = JamaahFileStorage::store($request->file('payment_proof'), 'payment_proofs');
            $data['payment_proof'] = $path;
        }

        $payment = Payment::create($data);

        // Recalculate Jamaah Status
        $this->updateJamaahStatus($payment->jamaah_id);

        return redirect()->route('admin.payments.index')->with('success', 'Pembayaran berhasil dicatat.');
    }

    public function updateStatus(Request $request, Payment $payment)
    {
        $request->validate([
            'status' => 'required|in:Pending,Approved,Rejected',
        ]);

        $payment->update(['status' => $request->status]);

        // Recalculate Jamaah Status
        $this->updateJamaahStatus($payment->jamaah_id);

        return redirect()->back()->with('success', "Status pembayaran berhasil diubah menjadi {$request->status}.");
    }

    public function destroy(Payment $payment)
    {
        $jamaahId = $payment->jamaah_id;
        JamaahFileStorage::delete($payment->payment_proof);
        $payment->delete();

        $this->updateJamaahStatus($jamaahId);

        return redirect()->back()->with('success', 'Pembayaran berhasil dihapus.');
    }

    // Helper to update jamaah status based on payment total
    private function updateJamaahStatus($jamaahId)
    {
        $jamaah = Jamaah::with(['package', 'payments'])->findOrFail($jamaahId);
        if (! $jamaah->package) {
            return;
        }

        $packagePrice = $jamaah->package->price_numeric;
        $totalPaid = (float) $jamaah->payments->where('status', 'Approved')->sum('amount');

        if ($totalPaid >= $packagePrice) {
            $jamaah->update(['status' => 'Pelunasan']);
        } elseif ($totalPaid > 0) {
            $jamaah->update(['status' => 'DP Masuk']);
        } else {
            $jamaah->update(['status' => 'Prospek']);
        }
    }

    // Export Invoice PDF
    public function exportInvoice(Payment $payment)
    {
        $payment->load('jamaah.package');

        $pdf = Pdf::loadView('admin.payment.invoice-pdf', compact('payment'));

        return $pdf->download("invoice-pembayaran-{$payment->id}.pdf");
    }
}
