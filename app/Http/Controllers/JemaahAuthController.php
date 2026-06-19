<?php

namespace App\Http\Controllers;

use App\Models\Jamaah;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JemaahAuthController extends Controller
{
    /**
     * Show the Jemaah login page.
     *
     * @return View|RedirectResponse
     */
    public function showLogin()
    {
        if (session()->has('jemaah_id') && Jamaah::find(session('jemaah_id'))) {
            return redirect()->route('jemaah.dashboard');
        }

        return view('landing.jemaah.login');
    }

    /**
     * Process the Jemaah login request.
     *
     * @return RedirectResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'whatsapp' => 'required|string',
            'nik' => 'required|string',
        ], [
            'whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
            'nik.required' => 'NIK wajib diisi.',
        ]);

        // Use deterministic HMAC hashes for lookups — PII is encrypted at rest
        $nikHash = Jamaah::hashField($request->nik);
        $normalizedPhone = Jamaah::normalizePhone($request->whatsapp);
        $waHash = Jamaah::hashField($normalizedPhone);

        // Primary: exact hash match (fastest, uses indexed columns)
        $jemaah = Jamaah::where('nik_hash', $nikHash)
            ->where('whatsapp_hash', $waHash)
            ->first();

        if (! $jemaah) {
            return redirect()->back()
                ->withInput($request->only('whatsapp', 'nik'))
                ->with('error', 'Nomor WhatsApp atau NIK tidak terdaftar. Pastikan data yang Anda masukkan sesuai saat mendaftar.');
        }

        // Store jemaah_id in session
        session(['jemaah_id' => $jemaah->id]);

        return redirect()->route('jemaah.dashboard')
            ->with('success', 'Selamat datang kembali, '.$jemaah->name.'! Silakan pantau status keberangkatan Anda.');
    }

    /**
     * Process Jemaah logout.
     *
     * @return RedirectResponse
     */
    public function logout()
    {
        session()->forget('jemaah_id');

        return redirect()->route('jemaah.login')
            ->with('success', 'Anda telah berhasil keluar dari portal jemaah.');
    }
}
