<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jamaah;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index()
    {
        $jamaahs = Jamaah::with(['departureSchedule.package'])->latest()->paginate(10);

        // Add passport expiry warning calculation for each jamaah
        foreach ($jamaahs as $jamaah) {
            $jamaah->passport_warning = false;
            $jamaah->days_until_expiry = null;

            if ($jamaah->passport_expiry) {
                $expiry = Carbon::parse($jamaah->passport_expiry);
                $referenceDate = Carbon::now();

                // If there's a departure date, use that as the reference, otherwise use today
                if ($jamaah->departureSchedule && $jamaah->departureSchedule->departure_date) {
                    $referenceDate = Carbon::parse($jamaah->departureSchedule->departure_date);
                }

                $diffInMonths = $referenceDate->diffInMonths($expiry, false);
                $jamaah->days_until_expiry = $referenceDate->diffInDays($expiry, false);

                // If passport expires less than 6 months from reference date, or is already expired (negative diff)
                if ($diffInMonths < 6) {
                    $jamaah->passport_warning = true;
                }
            }
        }

        return view('admin.document.index', compact('jamaahs'));
    }

    public function show(Jamaah $jamaah)
    {
        return view('admin.document.show', compact('jamaah'));
    }

    public function upload(Request $request, Jamaah $jamaah)
    {
        $request->validate([
            'ktp_file' => 'nullable|file|mimes:jpeg,png,pdf|max:2048',
            'passport_file' => 'nullable|file|mimes:jpeg,png,pdf|max:2048',
            'kk_file' => 'nullable|file|mimes:jpeg,png,pdf|max:2048',
            'vaccine_file' => 'nullable|file|mimes:jpeg,png,pdf|max:2048',
            'photo_file' => 'nullable|file|mimes:jpeg,png|max:2048',
        ]);

        $files = ['ktp_file', 'passport_file', 'kk_file', 'vaccine_file', 'photo_file'];
        $updatedData = [];

        foreach ($files as $file) {
            if ($request->hasFile($file)) {
                $path = $request->file($file)->store('documents', 'public');
                $updatedData[$file] = $path;
            }
        }

        if (! empty($updatedData)) {
            $jamaah->update($updatedData);

            // Check if all essential documents are uploaded to update the status to "Dokumen Lengkap"
            $jamaah->refresh();
            if ($jamaah->ktp_file && $jamaah->passport_file && $jamaah->kk_file && $jamaah->vaccine_file && $jamaah->photo_file) {
                $jamaah->update(['status' => 'Dokumen Lengkap']);
            }
        }

        return redirect()->back()->with('success', 'Berkas dokumen berhasil diunggah.');
    }

    public function updateVisa(Request $request, Jamaah $jamaah)
    {
        $request->validate([
            'visa_status' => 'required|string',
        ]);

        $jamaah->update(['visa_status' => $request->visa_status]);

        // If visa is issued, check if we can upgrade status
        if ($request->visa_status === 'Issued') {
            $jamaah->update(['status' => 'Visa Process']);
        }

        return redirect()->back()->with('success', 'Status Visa jemaah berhasil diperbarui.');
    }
}
