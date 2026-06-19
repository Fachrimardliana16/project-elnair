<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DepartureSchedule;
use App\Models\Jamaah;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JamaahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $packages = Package::orderBy('title')->get();
        $schedules = DepartureSchedule::with('package')->orderBy('departure_date', 'desc')->get();

        $hasFilters = $request->filled('search') ||
                     $request->filled('package_id') ||
                     $request->filled('departure_schedule_id') ||
                     $request->filled('status') ||
                     $request->has('show_all');

        $jamaahs = null;

        if ($hasFilters) {
            $query = Jamaah::with(['package', 'departureSchedule']);

            if ($request->filled('search')) {
                $search = $request->input('search');
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('whatsapp', 'like', "%{$search}%")
                        ->orWhere('nik', 'like', "%{$search}%");
                });
            }

            if ($request->filled('package_id')) {
                $query->where('package_id', $request->input('package_id'));
            }

            if ($request->filled('departure_schedule_id')) {
                $query->where('departure_schedule_id', $request->input('departure_schedule_id'));
            }

            if ($request->filled('status')) {
                $query->where('status', $request->input('status'));
            }

            $jamaahs = $query->latest()->paginate(10)->withQueryString();
        }

        return view('admin.jamaah.index', compact('jamaahs', 'packages', 'schedules', 'hasFilters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Not used, users register via public form. But can be added later if needed.
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Jamaah $jamaah)
    {
        $jamaah->load(['package', 'payments', 'departureSchedule']);

        $packages = Package::all();
        $schedules = DepartureSchedule::with('package')->where('is_active', true)->get();

        return view('admin.jamaah.show', compact('jamaah', 'packages', 'schedules'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jamaah $jamaah)
    {
        return view('admin.jamaah.edit', compact('jamaah'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jamaah $jamaah)
    {
        $request->validate([
            'status' => 'required|string',
            'package_id' => 'nullable|exists:packages,id',
            'departure_schedule_id' => 'nullable|exists:departure_schedules,id',
            'room_type' => 'nullable|string',
        ]);

        $jamaah->update([
            'status' => $request->status,
            'package_id' => $request->package_id,
            'departure_schedule_id' => $request->departure_schedule_id,
            'room_type' => $request->room_type,
        ]);

        return redirect()->back()->with('success', 'Data jemaah berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jamaah $jamaah)
    {
        $files = ['ktp_file', 'passport_file', 'kk_file', 'payment_proof_file'];
        foreach ($files as $file) {
            if ($jamaah->$file) {
                Storage::disk('public')->delete($jamaah->$file);
            }
        }
        $jamaah->delete();

        return redirect()->route('admin.jamaahs.index')->with('success', 'Data jamaah berhasil dihapus.');
    }
}
