<?php

namespace Tests\Feature\Public;

use App\Models\Jamaah;
use App\Models\Package;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class JemaahPortalTest extends TestCase
{
    use RefreshDatabase;

    private Package $package;

    protected function setUp(): void
    {
        parent::setUp();

        $this->package = Package::create([
            'title' => 'Paket Umrah Gold',
            'slug' => 'paket-umrah-gold',
            'price_label' => 'Rp',
            'price_value' => 35000000,
            'description' => 'Paket Umrah Premium',
            'is_active' => true,
        ]);
    }

    public function test_guests_can_view_login_page(): void
    {
        $response = $this->get(route('jemaah.login'));

        $response->assertStatus(200)
            ->assertSee('Portal Jemaah')
            ->assertSee('Nomor WhatsApp')
            ->assertSee('NIK KTP');
    }

    public function test_guests_cannot_login_with_invalid_credentials(): void
    {
        $response = $this->post(route('jemaah.login.post'), [
            'whatsapp' => '08123456789',
            'nik' => '1234567890123456',
        ]);

        $response->assertRedirect()
            ->assertSessionHas('error');
        $this->assertNull(session('jemaah_id'));
    }

    public function test_guests_can_login_with_exact_credentials(): void
    {
        $jemaah = Jamaah::create([
            'package_id' => $this->package->id,
            'name' => 'Ahmad Junaidi',
            'whatsapp' => '081234567890',
            'nik' => '3273012345678901',
            'status' => 'Pending',
        ]);

        $response = $this->post(route('jemaah.login.post'), [
            'whatsapp' => '081234567890',
            'nik' => '3273012345678901',
        ]);

        $response->assertRedirect(route('jemaah.dashboard'));
        $this->assertEquals($jemaah->id, session('jemaah_id'));
    }

    public function test_guests_can_login_with_flexible_whatsapp_formatting(): void
    {
        $jemaah = Jamaah::create([
            'package_id' => $this->package->id,
            'name' => 'Siti Aminah',
            'whatsapp' => '+62 812-3456-7890',
            'nik' => '3273012345678902',
            'status' => 'Pending',
        ]);

        // Login with 08... format
        $response = $this->post(route('jemaah.login.post'), [
            'whatsapp' => '081234567890',
            'nik' => '3273012345678902',
        ]);

        $response->assertRedirect(route('jemaah.dashboard'));
        $this->assertEquals($jemaah->id, session('jemaah_id'));
    }

    public function test_guests_are_blocked_from_portal_pages(): void
    {
        $this->get(route('jemaah.dashboard'))->assertRedirect(route('jemaah.login'));
        $this->get(route('jemaah.profile'))->assertRedirect(route('jemaah.login'));
        $this->get(route('jemaah.payments'))->assertRedirect(route('jemaah.login'));
        $this->get(route('jemaah.documents'))->assertRedirect(route('jemaah.login'));
    }

    public function test_authenticated_jemaah_can_access_dashboard_and_profile(): void
    {
        $jemaah = Jamaah::create([
            'package_id' => $this->package->id,
            'name' => 'Budi Santoso',
            'whatsapp' => '081234567893',
            'nik' => '3273012345678903',
            'status' => 'Pending',
        ]);

        $response = $this->withSession(['jemaah_id' => $jemaah->id])
            ->get(route('jemaah.dashboard'));

        $response->assertStatus(200)
            ->assertSee('Budi Santoso')
            ->assertSee('Paket Umrah Gold');

        $responseProfile = $this->withSession(['jemaah_id' => $jemaah->id])
            ->get(route('jemaah.profile'));

        $responseProfile->assertStatus(200)
            ->assertSee('Budi Santoso')
            ->assertSee('3273012345678903');
    }

    public function test_pending_jemaah_payment_form_is_locked(): void
    {
        $jemaah = Jamaah::create([
            'package_id' => $this->package->id,
            'name' => 'Eko Prasetyo',
            'whatsapp' => '081234567894',
            'nik' => '3273012345678904',
            'status' => 'Pending', // Status is Pending!
        ]);

        $response = $this->withSession(['jemaah_id' => $jemaah->id])
            ->get(route('jemaah.payments'));

        $response->assertStatus(200)
            ->assertSee('Pendaftaran Anda Sedang Ditinjau')
            ->assertDontSee('Konfirmasi Pembayaran Baru')
            ->assertDontSee('Nominal Transfer');
    }

    public function test_pending_jemaah_cannot_post_payment_proof(): void
    {
        Storage::fake('public');

        $jemaah = Jamaah::create([
            'package_id' => $this->package->id,
            'name' => 'Dedi Wijaya',
            'whatsapp' => '081234567895',
            'nik' => '3273012345678905',
            'status' => 'Pending', // Status is Pending!
        ]);

        $file = UploadedFile::fake()->image('proof.jpg');

        $response = $this->withSession(['jemaah_id' => $jemaah->id])
            ->post(route('jemaah.payments.upload'), [
                'type' => 'DP',
                'amount' => 5000000,
                'payment_date' => '2026-05-29',
                'payment_proof' => $file,
            ]);

        $response->assertRedirect(route('jemaah.payments'))
            ->assertSessionHas('error');

        $this->assertEquals(0, Payment::count());
    }

    public function test_approved_jemaah_payment_form_is_unlocked(): void
    {
        $jemaah = Jamaah::create([
            'package_id' => $this->package->id,
            'name' => 'Hendra Setiawan',
            'whatsapp' => '081234567896',
            'nik' => '3273012345678906',
            'status' => 'DP', // Status is Approved (DP / Lunas)!
        ]);

        $response = $this->withSession(['jemaah_id' => $jemaah->id])
            ->get(route('jemaah.payments'));

        $response->assertStatus(200)
            ->assertSee('Konfirmasi Pembayaran Baru')
            ->assertSee('Nominal Transfer')
            ->assertDontSee('Pendaftaran Anda Sedang Ditinjau');
    }

    public function test_approved_jemaah_can_post_payment_proof(): void
    {
        Storage::fake('public');

        $jemaah = Jamaah::create([
            'package_id' => $this->package->id,
            'name' => 'Rian Subagja',
            'whatsapp' => '081234567897',
            'nik' => '3273012345678907',
            'status' => 'DP', // Approved!
        ]);

        $file = UploadedFile::fake()->image('proof.jpg');

        $response = $this->withSession(['jemaah_id' => $jemaah->id])
            ->post(route('jemaah.payments.upload'), [
                'type' => 'DP',
                'amount' => 10000000,
                'payment_date' => '2026-05-29',
                'payment_proof' => $file,
            ]);

        $response->assertRedirect(route('jemaah.payments'))
            ->assertSessionHas('success');

        $this->assertEquals(1, Payment::count());
        $payment = Payment::first();
        $this->assertEquals($jemaah->id, $payment->jamaah_id);
        $this->assertEquals('DP', $payment->type);
        $this->assertEquals(10000000, $payment->amount);
        $this->assertEquals('Pending', $payment->status);
        $this->assertNotNull($payment->payment_proof);

        Storage::disk('public')->assertExists($payment->payment_proof);
    }

    public function test_jemaah_can_upload_and_update_documents(): void
    {
        Storage::fake('public');

        $jemaah = Jamaah::create([
            'package_id' => $this->package->id,
            'name' => 'Fajar Alfian',
            'whatsapp' => '081234567898',
            'nik' => '3273012345678908',
            'status' => 'Pending',
        ]);

        $file = UploadedFile::fake()->create('ktp.pdf', 1024, 'application/pdf');

        $response = $this->withSession(['jemaah_id' => $jemaah->id])
            ->post(route('jemaah.documents.upload'), [
                'document_type' => 'ktp_file',
                'file' => $file,
            ]);

        $response->assertRedirect(route('jemaah.documents'))
            ->assertSessionHas('success');

        $jemaah->refresh();
        $this->assertNotNull($jemaah->ktp_file);
        Storage::disk('public')->assertExists($jemaah->ktp_file);
    }

    public function test_authenticated_jemaah_can_logout(): void
    {
        $jemaah = Jamaah::create([
            'package_id' => $this->package->id,
            'name' => 'Rian Ardianto',
            'whatsapp' => '081234567899',
            'nik' => '3273012345678909',
            'status' => 'Pending',
        ]);

        $response = $this->withSession(['jemaah_id' => $jemaah->id])
            ->post(route('jemaah.logout'));

        $response->assertRedirect(route('jemaah.login'));
        $this->assertNull(session('jemaah_id'));
    }

    public function test_registration_automatically_logs_in_and_redirects_to_dashboard(): void
    {
        $response = $this->post(route('pendaftaran.store'), [
            'package_id' => $this->package->id,
            'name' => 'Rian Agung',
            'gender' => 'Laki-laki',
            'birth_place' => 'Jakarta',
            'birth_date' => '1995-10-10',
            'nik' => '3273012345678912',
            'city' => 'Jakarta',
            'whatsapp' => '081234567812',
            'email' => 'rian@example.com',
        ]);

        $response->assertRedirect(route('jemaah.dashboard'));
        $this->assertTrue(session()->has('jemaah_id'));

        // NIK is encrypted at rest — look up via nik_hash instead
        $nikHash = Jamaah::hashField('3273012345678912');
        $jemaah = Jamaah::where('nik_hash', $nikHash)->first();
        $this->assertNotNull($jemaah);
        $this->assertEquals($jemaah->id, session('jemaah_id'));
    }
}
