<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DepartureSchedule;
use App\Models\Group;
use App\Models\Guide;
use App\Models\Jamaah;
use App\Models\Room;
use App\Models\RoomMember;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::with('departureSchedule')->withCount('jamaahs')->latest()->paginate(10);

        return view('admin.group.index', compact('groups'));
    }

    public function create()
    {
        $schedules = DepartureSchedule::with('package')->where('is_active', true)->get();
        $guides = Guide::where('is_active', true)->get();

        return view('admin.group.create', compact('schedules', 'guides'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'departure_schedule_id' => 'required|exists:departure_schedules,id',
            'capacity' => 'required|integer|min:1',
        ]);

        Group::create($request->all());

        return redirect()->route('admin.groups.index')->with('success', 'Grup keberangkatan berhasil dibuat.');
    }

    public function show(Group $group)
    {
        $group->load(['departureSchedule.package', 'jamaahs', 'rooms.roomMembers.jamaah']);

        // Get all jamaahs in this departure schedule who don't have a group yet, or already belong to this group
        // AND whose status is verified/complete (DP, Lunas, DP Masuk, Pelunasan, or Dokumen Lengkap)
        $availableJamaahs = Jamaah::where('departure_schedule_id', $group->departure_schedule_id)
            ->whereIn('status', ['DP', 'Lunas', 'DP Masuk', 'Pelunasan', 'Dokumen Lengkap'])
            ->where(function ($query) use ($group) {
                $query->whereNull('group_id')
                    ->orWhere('group_id', $group->id);
            })->get();

        // Count pending pilgrims on this schedule who are locked out (Pending or Prospek)
        $pendingJamaahsCount = Jamaah::where('departure_schedule_id', $group->departure_schedule_id)
            ->whereIn('status', ['Pending', 'Prospek'])
            ->count();

        return view('admin.group.show', compact('group', 'availableJamaahs', 'pendingJamaahsCount'));
    }

    public function edit(Group $group)
    {
        $schedules = DepartureSchedule::with('package')->where('is_active', true)->get();
        $guides = Guide::where('is_active', true)->get();

        return view('admin.group.edit', compact('group', 'schedules', 'guides'));
    }

    public function update(Request $request, Group $group)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'departure_schedule_id' => 'required|exists:departure_schedules,id',
            'capacity' => 'required|integer|min:1',
        ]);

        $group->update($request->all());

        return redirect()->route('admin.groups.index')->with('success', 'Grup keberangkatan berhasil diubah.');
    }

    public function destroy(Group $group)
    {
        // Unset group_id for all jamaahs in this group
        Jamaah::where('group_id', $group->id)->update(['group_id' => null]);
        $group->delete();

        return redirect()->route('admin.groups.index')->with('success', 'Grup keberangkatan berhasil dihapus.');
    }

    // Add Jamaah to Group (Bulk Enabled)
    public function addJamaah(Request $request, Group $group)
    {
        $request->validate([
            'jamaah_ids' => 'required|array',
            'jamaah_ids.*' => 'exists:jamaahs,id',
        ]);

        $jamaahIds = $request->input('jamaah_ids');
        $currentCount = $group->jamaahs()->count();
        $capacityLeft = $group->capacity - $currentCount;

        if (count($jamaahIds) > $capacityLeft) {
            return redirect()->back()->with('error', 'Kapasitas grup tidak mencukupi untuk memasukkan '.count($jamaahIds)." jemaah (Sisa kapasitas: {$capacityLeft}).");
        }

        Jamaah::whereIn('id', $jamaahIds)->update(['group_id' => $group->id]);

        return redirect()->route('admin.groups.show', $group->id)->with('success', count($jamaahIds).' Jemaah berhasil dimasukkan ke rombongan.');
    }

    // Remove Jamaah from Group
    public function removeJamaah(Group $group, Jamaah $jamaah)
    {
        // Remove from room members first
        RoomMember::where('jamaah_id', $jamaah->id)->delete();

        $jamaah->update(['group_id' => null]);

        return redirect()->route('admin.groups.show', $group->id)->with('success', 'Jamaah berhasil dikeluarkan dari grup.');
    }

    // Update Flight Details
    public function updateFlight(Request $request, Group $group)
    {
        $request->validate([
            'flight_code' => 'required|string',
            'flight_departure_time' => 'required|date',
            'flight_transit' => 'nullable|string',
            'flight_terminal' => 'nullable|string',
            'booking_code' => 'nullable|string',
        ]);

        $group->update($request->only([
            'flight_code', 'flight_departure_time', 'flight_transit', 'flight_terminal', 'booking_code',
        ]));

        return redirect()->route('admin.groups.show', $group->id)->with('success', 'Informasi penerbangan berhasil diperbarui.');
    }

    // Add Room (Rooming List Makkah/Madinah)
    public function addRoom(Request $request, Group $group)
    {
        $request->validate([
            'hotel_name' => 'required|string', // e.g. Makkah Hotel, Madinah Hotel
            'room_number' => 'required|string',
        ]);

        Room::create([
            'group_id' => $group->id,
            'hotel_name' => $request->hotel_name,
            'room_number' => $request->room_number,
        ]);

        return redirect()->route('admin.groups.show', $group->id)->with('success', 'Kamar hotel berhasil ditambahkan.');
    }

    // Assign Room Member
    public function assignRoomMember(Request $request, Group $group)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'jamaah_id' => 'required|exists:jamaahs,id',
        ]);

        $room = Room::findOrFail($request->room_id);

        // Count current members
        $currentCount = $room->roomMembers()->count();

        // Find jamaah room_type to validate capacity
        $jamaah = Jamaah::findOrFail($request->jamaah_id);
        $maxCapacity = 4; // Default to Quad
        if ($jamaah->room_type === 'Double') {
            $maxCapacity = 2;
        } elseif ($jamaah->room_type === 'Triple') {
            $maxCapacity = 3;
        }

        if ($currentCount >= $maxCapacity) {
            return redirect()->back()->with('error', "Kamar sudah penuh untuk tipe rooming {$jamaah->room_type} (Maks {$maxCapacity} orang).");
        }

        // Check if already in another room in the SAME hotel
        $existing = RoomMember::where('jamaah_id', $jamaah->id)
            ->whereHas('room', function ($q) use ($room) {
                $q->where('hotel_name', $room->hotel_name);
            })->exists();

        if ($existing) {
            return redirect()->back()->with('error', 'Jamaah sudah ditempatkan di kamar lain di hotel ini.');
        }

        RoomMember::create([
            'room_id' => $room->id,
            'jamaah_id' => $jamaah->id,
        ]);

        return redirect()->route('admin.groups.show', $group->id)->with('success', 'Jamaah berhasil ditempatkan di kamar.');
    }

    // Remove Room Member
    public function removeRoomMember(Group $group, RoomMember $member)
    {
        $member->delete();

        return redirect()->route('admin.groups.show', $group->id)->with('success', 'Jamaah berhasil dikeluarkan dari kamar.');
    }

    // Destroy Room
    public function destroyRoom(Group $group, Room $room)
    {
        $room->delete();

        return redirect()->route('admin.groups.show', $group->id)->with('success', 'Kamar hotel berhasil dihapus.');
    }

    // Export Group Manifest PDF
    public function exportManifest(Group $group)
    {
        $group->load(['departureSchedule.package', 'jamaahs']);

        $pdf = Pdf::loadView('admin.group.manifest-pdf', compact('group'));

        return $pdf->download("manifest-group-{$group->id}.pdf");
    }

    // Auto-allocate Rooms (Makkah or Madinah) based on Hotel, Gender, and Room Type
    public function autoRooms(Request $request, Group $group)
    {
        $request->validate([
            'hotel_name' => 'required|string|max:255',
        ]);

        $hotelName = $request->input('hotel_name');

        // 1. Check if the group actually has any jamaahs first
        $totalGroupJamaahs = $group->jamaahs()->count();
        if ($totalGroupJamaahs === 0) {
            return redirect()->back()->with('error', 'Gagal alokasi otomatis: Belum ada jemaah yang dimasukkan ke dalam rombongan ini. Silakan centang & masukkan jemaah ke rombongan terlebih dahulu di bagian atas.');
        }

        // 2. Get all jamaah in the group who are NOT assigned to any room in this specific hotel
        $unassignedJamaahs = $group->jamaahs()
            ->whereDoesntHave('roomMembers.room', function ($q) use ($hotelName) {
                $q->where('hotel_name', $hotelName);
            })->get();

        if ($unassignedJamaahs->isEmpty()) {
            return redirect()->back()->with('error', "Gagal alokasi otomatis: Seluruh jemaah ({$totalGroupJamaahs} orang) di rombongan ini sudah mendapatkan alokasi kamar di hotel '{$hotelName}'.");
        }

        // 2. Group them by gender and room type preference
        // In database: $jamaah->gender (e.g. 'Laki-laki', 'Perempuan'), $jamaah->room_type (e.g. 'Double', 'Triple', 'Quad')
        $grouped = $unassignedJamaahs->groupBy(function ($j) {
            $gender = $j->gender ?? 'Laki-laki';
            $roomType = $j->room_type ?? 'Quad';

            return "{$gender}_{$roomType}";
        });

        $createdRoomsCount = 0;
        $assignedCount = 0;

        foreach ($grouped as $key => $jamaahsInSubgroup) {
            [$gender, $roomType] = explode('_', $key);

            // Determine capacity based on room type
            $capacity = 4; // Default to Quad
            if ($roomType === 'Double') {
                $capacity = 2;
            } elseif ($roomType === 'Triple') {
                $capacity = 3;
            }

            // Chunk the pilgrims into groups of capacity
            $chunks = $jamaahsInSubgroup->chunk($capacity);

            foreach ($chunks as $chunk) {
                // Create a new Room automatically
                $latestRoomIndex = Room::where('group_id', $group->id)->where('hotel_name', $hotelName)->count() + 1;

                $room = Room::create([
                    'group_id' => $group->id,
                    'hotel_name' => $hotelName,
                    'room_number' => 'Auto Room '.$latestRoomIndex.' ('.($gender === 'Laki-laki' ? 'Pria' : 'Wanita').')',
                ]);

                $createdRoomsCount++;

                foreach ($chunk as $jamaah) {
                    RoomMember::create([
                        'room_id' => $room->id,
                        'jamaah_id' => $jamaah->id,
                    ]);
                    $assignedCount++;
                }
            }
        }

        return redirect()->route('admin.groups.show', $group->id)
            ->with('success', "Sukses alokasi kamar otomatis di hotel '{$hotelName}': Berhasil membuat {$createdRoomsCount} kamar baru dan menempatkan {$assignedCount} jemaah.");
    }

    // Move Room Member (Manual swap/move)
    public function moveRoomMember(Request $request, Group $group)
    {
        $request->validate([
            'jamaah_id' => 'required|exists:jamaahs,id',
            'room_id' => 'required|exists:rooms,id',
        ]);

        $jamaahId = $request->input('jamaah_id');
        $newRoomId = $request->input('room_id');

        $jamaah = Jamaah::findOrFail($jamaahId);
        $newRoom = Room::findOrFail($newRoomId);

        // 1. Validate capacity of the destination room
        $currentCount = $newRoom->roomMembers()->count();
        $maxCapacity = 4; // Default Quad
        if ($jamaah->room_type === 'Double') {
            $maxCapacity = 2;
        } elseif ($jamaah->room_type === 'Triple') {
            $maxCapacity = 3;
        }

        if ($currentCount >= $maxCapacity) {
            return redirect()->back()->with('error', "Kamar tujuan {$newRoom->room_number} sudah penuh untuk tipe rooming {$jamaah->room_type} (Maks {$maxCapacity} orang).");
        }

        // 2. Remove the pilgrim from any other room in the SAME hotel in this group
        RoomMember::where('jamaah_id', $jamaahId)
            ->whereHas('room', function ($q) use ($newRoom) {
                $q->where('hotel_name', $newRoom->hotel_name);
            })->delete();

        // 3. Create room member in the new room
        RoomMember::create([
            'room_id' => $newRoom->id,
            'jamaah_id' => $jamaahId,
        ]);

        return redirect()->route('admin.groups.show', $group->id)
            ->with('success', "Jemaah '{$jamaah->name}' berhasil dipindahkan ke Kamar {$newRoom->room_number} ({$newRoom->hotel_name}).");
    }
}
