<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DepartureSchedule;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DepartureScheduleController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $schedules = DepartureSchedule::with('package')
            ->when($search, function ($query) use ($search) {
                $query->whereHas('package', function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%");
                })->orWhere('departure_date', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.schedules.index', compact('schedules', 'search'));
    }

    public function create()
    {
        $packages = Package::where('is_active', true)->get();

        return view('admin.schedules.create', compact('packages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id',
            'departure_date' => 'required|date',
            'available_seats' => 'required|integer|min:0',
            'status' => 'required|string',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        DepartureSchedule::create($data);

        // Clear sitemap or cached homepage departures if any
        Cache::forget('homepage_packages');

        return redirect()->route('admin.schedules.index')->with('success', 'Jadwal keberangkatan berhasil ditambahkan.');
    }

    public function edit(DepartureSchedule $schedule)
    {
        $packages = Package::where('is_active', true)->get();

        return view('admin.schedules.edit', compact('schedule', 'packages'));
    }

    public function update(Request $request, DepartureSchedule $schedule)
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id',
            'departure_date' => 'required|date',
            'available_seats' => 'required|integer|min:0',
            'status' => 'required|string',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        $schedule->update($data);

        Cache::forget('homepage_packages');

        return redirect()->route('admin.schedules.index')->with('success', 'Jadwal keberangkatan berhasil diperbarui.');
    }

    public function destroy(DepartureSchedule $schedule)
    {
        $schedule->delete();
        Cache::forget('homepage_packages');

        return redirect()->route('admin.schedules.index')->with('success', 'Jadwal keberangkatan berhasil dihapus.');
    }
}
