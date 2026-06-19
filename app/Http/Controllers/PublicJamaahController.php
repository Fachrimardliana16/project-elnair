<?php

namespace App\Http\Controllers;

use App\Models\DepartureSchedule;
use App\Models\Jamaah;
use App\Models\Package;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class PublicJamaahController extends Controller
{
    public function create()
    {
        $settings = SiteSetting::pluck('value', 'key')->toArray();
        if (($settings['show_pendaftaran_feature'] ?? '1') !== '1') {
            return redirect()->route('home');
        }

        $packages = Package::where('is_active', true)->get();
        $schedules = DepartureSchedule::where('is_active', true)
            ->where('available_seats', '>', 0)
            ->whereDate('departure_date', '>=', now())
            ->orderBy('departure_date', 'asc')
            ->get();

        return view('landing.pendaftaran.index', compact('packages', 'schedules'));
    }

    public function store(Request $request)
    {
        $settings = SiteSetting::pluck('value', 'key')->toArray();
        if (($settings['show_pendaftaran_feature'] ?? '1') !== '1') {
            return redirect()->route('home');
        }

        $request->validate([
            'package_id' => 'required|exists:packages,id',
            'departure_schedule_id' => 'nullable|exists:departure_schedules,id',
            'name' => 'required|string|max:255',
            'passport_name' => 'nullable|string|max:255',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'birth_place' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'nik' => 'required|string|max:20',
            'passport_number' => 'nullable|string|max:50',
            'passport_expiry' => 'nullable|date',
            'city' => 'required|string|max:255',
            'whatsapp' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'ktp_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'passport_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'kk_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'payment_proof_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $data = $request->except(['ktp_file', 'passport_file', 'kk_file', 'payment_proof_file']);
        $data['status'] = 'Pending';

        $files = ['ktp_file', 'passport_file', 'kk_file', 'payment_proof_file'];
        foreach ($files as $file) {
            if ($request->hasFile($file)) {
                $data[$file] = $request->file($file)->store('jamaah_docs', 'public');
            }
        }

        $jamaah = Jamaah::create($data);

        // Decrement available seats if schedule is selected
        if (! empty($data['departure_schedule_id'])) {
            $schedule = DepartureSchedule::find($data['departure_schedule_id']);
            if ($schedule && $schedule->available_seats > 0) {
                $schedule->decrement('available_seats');
            }
        }

        // Auto-login the newly registered Jemaah
        session(['jemaah_id' => $jamaah->id]);

        return redirect()->route('jemaah.dashboard')->with('success', 'Pendaftaran berhasil disubmit! Selamat datang di portal jemaah Anda.');
    }
}
