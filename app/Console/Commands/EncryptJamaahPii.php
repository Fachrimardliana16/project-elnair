<?php

namespace App\Console\Commands;

use App\Models\Jamaah;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

#[Signature('app:encrypt-jamaah-pii {--dry-run : Preview what will be migrated without writing}')]
#[Description('Migrate existing plaintext PII data in the jamaahs table to encrypted format')]
class EncryptJamaahPii extends Command
{
    /** PII fields to be encrypted (must match $casts in Jamaah model). */
    private array $piiFields = ['name', 'passport_name', 'nik', 'passport_number', 'birth_place', 'whatsapp', 'email'];

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $isDryRun = $this->option('dry-run');

        if ($isDryRun) {
            $this->warn('🔍 DRY-RUN MODE — No data will be written.');
        } else {
            $this->info('🔐 Starting PII encryption migration for jamaahs table...');
        }

        // Bypass the model's encrypted cast by reading raw plaintext directly from DB
        $rows = DB::table('jamaahs')->get();
        $bar = $this->output->createProgressBar(count($rows));
        $bar->start();

        $migrated = 0;

        foreach ($rows as $row) {
            $updates = [];

            foreach ($this->piiFields as $field) {
                $rawValue = $row->{$field};

                if (empty($rawValue)) {
                    continue;
                }

                // Detect if already encrypted (Laravel encrypted strings start with "eyJ")
                if (str_starts_with($rawValue, 'eyJ')) {
                    continue;
                }

                if ($isDryRun) {
                    $this->line("\n  [ID {$row->id}] {$field}: {$rawValue} → [WILL BE ENCRYPTED]");
                } else {
                    $updates[$field] = Crypt::encryptString($rawValue);
                }
            }

            // Always (re)compute hash columns from plaintext, regardless of encryption state
            if (! $isDryRun) {
                $rawNik = $updates['nik'] ?? ($row->nik ?? null);
                $rawWa = $updates['whatsapp'] ?? ($row->whatsapp ?? null);

                // If field was just encrypted, the raw value is still available from the DB row
                $plainNik = isset($updates['nik']) ? $rawValue : $row->nik;
                $plainWa = isset($updates['whatsapp']) ? $rawValue : $row->whatsapp;

                // Re-read from plaintext stored in $row (before encryption run this iteration)
                $nikPlain = $row->nik;
                $waPlain = $row->whatsapp;

                if (! str_starts_with((string) $nikPlain, 'eyJ')) {
                    $updates['nik_hash'] = hash_hmac('sha256', $nikPlain, config('app.key'));
                }

                if (! str_starts_with((string) $waPlain, 'eyJ')) {
                    $digits = preg_replace('/[^0-9]/', '', $waPlain);
                    if (str_starts_with($digits, '0')) {
                        $digits = '62'.substr($digits, 1);
                    }
                    $updates['whatsapp_hash'] = hash_hmac('sha256', $digits, config('app.key'));
                }
            }

            if (! empty($updates) && ! $isDryRun) {
                DB::table('jamaahs')->where('id', $row->id)->update($updates);
                $migrated++;
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        if ($isDryRun) {
            $this->info('✅ Dry run complete. Run without --dry-run to apply encryption.');
        } else {
            $this->info("✅ Done. {$migrated} Jemaah record(s) had their PII fields encrypted successfully.");
        }

        return Command::SUCCESS;
    }
}
