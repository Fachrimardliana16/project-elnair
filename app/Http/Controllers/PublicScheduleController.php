<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DepartureSchedule;
use App\Models\SiteSetting;

class PublicScheduleController extends Controller
{
    public function index()
    {
        $schedules = DepartureSchedule::with('package')
            ->where('is_active', true)
            ->where('departure_date', '>=', now()->startOfDay())
            ->orderBy('departure_date', 'asc')
            ->paginate(6);
            
        $settings = SiteSetting::pluck('value', 'key')->toArray();
        
        $page_title = 'Jadwal Resmi Keberangkatan';
        $meta_description = 'Jadwal resmi keberangkatan umroh dan haji terbaru. Temukan jadwal yang sesuai dengan rencana ibadah Anda.';

        return view('landing.schedules.index', compact('schedules', 'settings', 'page_title', 'meta_description'));
    }

    public function show($id)
    {
        $schedule = DepartureSchedule::with('package')
            ->where('id', $id)
            ->where('is_active', true)
            ->firstOrFail();
            
        $settings = SiteSetting::pluck('value', 'key')->toArray();

        $page_title = 'Jadwal ' . ($schedule->package ? $schedule->package->title : 'Paket') . ' - ' . $schedule->departure_date->translatedFormat('d F Y');
        $meta_description = 'Detail jadwal keberangkatan untuk paket ' . ($schedule->package ? $schedule->package->title : 'Paket') . ' pada ' . $schedule->departure_date->translatedFormat('d F Y');

        return view('landing.schedules.show', compact('schedule', 'settings', 'page_title', 'meta_description'));
    }
}
