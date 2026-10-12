<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DepartureSchedule;
use App\Models\Jamaah;
use App\Models\Package;
use App\Support\JamaahFileStorage;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

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

            $search = trim((string) $request->input('search', ''));
            $searchNeedsDecryptedFilter = false;
            if ($search !== '') {
                $digits = preg_replace('/[^0-9]/', '', $search);
                if ($digits !== '' && strlen($digits) >= 8) {
                    $normalizedPhone = Jamaah::normalizePhone($search);
                    $query->where(function ($q) use ($digits, $normalizedPhone) {
                        $q->where('nik_hash', Jamaah::hashField($digits))
                            ->orWhere('whatsapp_hash', Jamaah::hashField($normalizedPhone));
                    });
                } else {
                    $searchNeedsDecryptedFilter = true;
                }
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

            if ($searchNeedsDecryptedFilter) {
                $matches = $query->latest()->limit(500)->get()->filter(function (Jamaah $jamaah) use ($search) {
                    $needle = mb_strtolower($search);

                    return str_contains(mb_strtolower((string) $jamaah->name), $needle)
                        || str_contains(mb_strtolower((string) $jamaah->whatsapp), $needle)
                        || str_contains(mb_strtolower((string) $jamaah->nik), $needle);
                })->values();

                $page = max(1, (int) $request->input('page', 1));
                $perPage = 10;
                $jamaahs = new LengthAwarePaginator(
                    $matches->forPage($page, $perPage),
                    $matches->count(),
                    $perPage,
                    $page,
                    ['path' => route('admin.jamaahs.index'), 'query' => $request->query()]
                );
            } else {
                $jamaahs = $query->latest()->paginate(10)->withQueryString();
            }
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
        $files = ['ktp_file', 'passport_file', 'kk_file', 'vaccine_file', 'photo_file', 'payment_proof_file'];
        foreach ($files as $file) {
            JamaahFileStorage::delete($jamaah->{$file});
        }
        $jamaah->delete();

        return redirect()->route('admin.jamaahs.index')->with('success', 'Data jamaah berhasil dihapus.');
    }
}
