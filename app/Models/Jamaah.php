<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Jamaah extends Model
{
    /**
     * PII fields stored with AES-256-CBC encryption (Laravel encrypted cast).
     * These are automatically encrypted on save and decrypted on read in PHP.
     * Database column stores ciphertext — never queryable via WHERE.
     */
    protected $casts = [
        'name' => 'encrypted',
        'passport_name' => 'encrypted',
        'nik' => 'encrypted',
        'passport_number' => 'encrypted',
        'birth_place' => 'encrypted',
        'whatsapp' => 'encrypted',
        'email' => 'encrypted',
    ];

    protected $fillable = [
        'package_id',
        'departure_schedule_id',
        'group_id',
        'name',
        'passport_name',
        'gender',
        'birth_place',
        'birth_date',
        'nik',
        'nik_hash',
        'passport_number',
        'passport_expiry',
        'city',
        'whatsapp',
        'whatsapp_hash',
        'email',
        'ktp_file',
        'passport_file',
        'kk_file',
        'vaccine_file',
        'photo_file',
        'room_type',
        'payment_proof_file',
        'status',
        'visa_status',
    ];

    /**
     * Automatically populate nik_hash and whatsapp_hash whenever
     * those fields are set, to keep lookup hashes in sync.
     */
    protected static function booted(): void
    {
        static::saving(function (Jamaah $jamaah) {
            if ($jamaah->isDirty('nik') && $jamaah->nik !== null) {
                $jamaah->nik_hash = self::hashField($jamaah->nik);
            }

            if ($jamaah->isDirty('whatsapp') && $jamaah->whatsapp !== null) {
                $jamaah->whatsapp_hash = self::hashField(self::normalizePhone($jamaah->whatsapp));
            }
        });
    }

    /**
     * Generate a deterministic HMAC-SHA256 hash of a PII value for secure lookup.
     */
    public static function hashField(string $value): string
    {
        return hash_hmac('sha256', $value, config('app.key'));
    }

    /**
     * Normalize a phone number to the 62... international format for consistent hashing.
     */
    public static function normalizePhone(string $phone): string
    {
        $digits = preg_replace('/[^0-9]/', '', $phone);

        if (str_starts_with($digits, '0')) {
            $digits = '62'.substr($digits, 1);
        }

        return $digits;
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function departureSchedule()
    {
        return $this->belongsTo(DepartureSchedule::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function roomMembers()
    {
        return $this->hasMany(RoomMember::class);
    }
}
