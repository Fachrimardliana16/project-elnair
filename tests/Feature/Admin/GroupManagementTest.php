<?php

namespace Tests\Feature\Admin;

use App\Models\DepartureSchedule;
use App\Models\Group;
use App\Models\Jamaah;
use App\Models\Package;
use App\Models\Room;
use App\Models\RoomMember;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class GroupManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    private Package $package;

    private DepartureSchedule $schedule;

    private Group $group;

    protected function setUp(): void
    {
        parent::setUp();
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $role = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $this->admin = User::factory()->create();
        $this->admin->assignRole($role);

        $this->package = Package::create([
            'title' => 'Paket Umrah Gold',
            'slug' => 'paket-umrah-gold',
            'price_label' => 'Rp',
            'price_value' => 35000000,
            'description' => 'Paket Umrah Premium',
            'is_active' => true,
        ]);

        $this->schedule = DepartureSchedule::create([
            'package_id' => $this->package->id,
            'departure_date' => '2026-10-10',
            'quota' => 45,
            'is_active' => true,
        ]);

        $this->group = Group::create([
            'name' => 'Kloter Gold A',
            'departure_schedule_id' => $this->schedule->id,
            'capacity' => 10,
        ]);
    }

    public function test_admin_can_bulk_assign_jamaahs_to_group(): void
    {
        $j1 = Jamaah::create([
            'package_id' => $this->package->id,
            'departure_schedule_id' => $this->schedule->id,
            'name' => 'Budi Santoso',
            'whatsapp' => '081234567891',
            'nik' => '3273012345678911',
            'status' => 'Pending',
        ]);

        $j2 = Jamaah::create([
            'package_id' => $this->package->id,
            'departure_schedule_id' => $this->schedule->id,
            'name' => 'Ahmad Junaidi',
            'whatsapp' => '081234567892',
            'nik' => '3273012345678912',
            'status' => 'Pending',
        ]);

        $response = $this->actingAs($this->admin)
            ->post(route('admin.groups.add-jamaah', $this->group->id), [
                'jamaah_ids' => [$j1->id, $j2->id],
            ]);

        $response->assertRedirect(route('admin.groups.show', $this->group->id));
        $this->assertDatabaseHas('jamaahs', [
            'id' => $j1->id,
            'group_id' => $this->group->id,
        ]);
        $this->assertDatabaseHas('jamaahs', [
            'id' => $j2->id,
            'group_id' => $this->group->id,
        ]);
    }

    public function test_admin_can_auto_allocate_rooms(): void
    {
        $j1 = Jamaah::create([
            'package_id' => $this->package->id,
            'departure_schedule_id' => $this->schedule->id,
            'name' => 'Siti Aminah',
            'whatsapp' => '081234567893',
            'nik' => '3273012345678913',
            'gender' => 'Perempuan',
            'room_type' => 'Double',
            'group_id' => $this->group->id,
            'status' => 'Pending',
        ]);

        $j2 = Jamaah::create([
            'package_id' => $this->package->id,
            'departure_schedule_id' => $this->schedule->id,
            'name' => 'Riana Astuti',
            'whatsapp' => '081234567894',
            'nik' => '3273012345678914',
            'gender' => 'Perempuan',
            'room_type' => 'Double',
            'group_id' => $this->group->id,
            'status' => 'Pending',
        ]);

        $response = $this->actingAs($this->admin)
            ->post(route('admin.groups.auto-rooms', $this->group->id), [
                'hotel_name' => 'Pullman Makkah',
            ]);

        $response->assertRedirect(route('admin.groups.show', $this->group->id))
            ->assertSessionHas('success');

        $this->assertEquals(1, Room::where('group_id', $this->group->id)->count());
        $room = Room::first();
        $this->assertEquals('Pullman Makkah', $room->hotel_name);

        $this->assertDatabaseHas('room_members', [
            'room_id' => $room->id,
            'jamaah_id' => $j1->id,
        ]);
        $this->assertDatabaseHas('room_members', [
            'room_id' => $room->id,
            'jamaah_id' => $j2->id,
        ]);
    }

    public function test_admin_can_manually_move_room_member(): void
    {
        $j1 = Jamaah::create([
            'package_id' => $this->package->id,
            'departure_schedule_id' => $this->schedule->id,
            'name' => 'Budi Santoso',
            'whatsapp' => '081234567895',
            'nik' => '3273012345678915',
            'group_id' => $this->group->id,
            'room_type' => 'Double',
            'status' => 'Pending',
        ]);

        $room1 = Room::create([
            'group_id' => $this->group->id,
            'hotel_name' => 'Hotel Makkah',
            'room_number' => '101',
        ]);

        $room2 = Room::create([
            'group_id' => $this->group->id,
            'hotel_name' => 'Hotel Makkah',
            'room_number' => '102',
        ]);

        RoomMember::create([
            'room_id' => $room1->id,
            'jamaah_id' => $j1->id,
        ]);

        $response = $this->actingAs($this->admin)
            ->post(route('admin.groups.move-room', $this->group->id), [
                'jamaah_id' => $j1->id,
                'room_id' => $room2->id,
            ]);

        $response->assertRedirect(route('admin.groups.show', $this->group->id))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('room_members', [
            'room_id' => $room1->id,
            'jamaah_id' => $j1->id,
        ]);

        $this->assertDatabaseHas('room_members', [
            'room_id' => $room2->id,
            'jamaah_id' => $j1->id,
        ]);
    }
}
