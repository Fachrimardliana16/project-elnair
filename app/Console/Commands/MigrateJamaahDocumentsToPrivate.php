<?php

namespace App\Console\Commands;

use App\Models\Jamaah;
use App\Models\Payment;
use App\Support\JamaahFileStorage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class MigrateJamaahDocumentsToPrivate extends Command
{
    protected $signature = 'jamaah:documents-private {--dry-run : Show planned changes without copying files}';

    protected $description = 'Copy legacy public jamaah documents and payment proofs to private storage';

    public function handle(): int
    {
        $dryRun = (bool) $this->option('dry-run');
        $migrated = 0;
        $missing = 0;

        Jamaah::query()->orderBy('id')->chunkById(100, function ($jamaahs) use ($dryRun, &$migrated, &$missing) {
            foreach ($jamaahs as $jamaah) {
                $updates = [];

                foreach (JamaahFileStorage::DOCUMENT_FIELDS as $field) {
                    $path = $jamaah->{$field};
                    if (! $path) {
                        continue;
                    }

                    $result = $this->migratePath($path, "jamaah {$jamaah->id} {$field}", $dryRun);
                    $migrated += $result['migrated'];
                    $missing += $result['missing'];

                    if ($result['path']) {
                        $updates[$field] = $result['path'];
                    }
                }

                if (! $dryRun && $updates !== []) {
                    $jamaah->forceFill($updates)->save();
                }
            }
        });

        Payment::query()->orderBy('id')->chunkById(100, function ($payments) use ($dryRun, &$migrated, &$missing) {
            foreach ($payments as $payment) {
                if (! $payment->payment_proof) {
                    continue;
                }

                $result = $this->migratePath($payment->payment_proof, "payment {$payment->id} payment_proof", $dryRun);
                $migrated += $result['migrated'];
                $missing += $result['missing'];

                if (! $dryRun && $result['path']) {
                    $payment->forceFill(['payment_proof' => $result['path']])->save();
                }
            }
        });

        $this->info(($dryRun ? 'Dry run complete.' : 'Migration complete.')." Migrated: {$migrated}. Missing: {$missing}.");

        return self::SUCCESS;
    }

    /**
     * @return array{path:?string,migrated:int,missing:int}
     */
    private function migratePath(string $path, string $label, bool $dryRun): array
    {
        $privatePath = JamaahFileStorage::normalizePrivatePath($path);
        if (Storage::disk(JamaahFileStorage::DISK)->exists($privatePath)) {
            return ['path' => null, 'migrated' => 0, 'missing' => 0];
        }

        $legacyPath = JamaahFileStorage::normalizeLegacyPublicPath($path);
        if (! Storage::disk('public')->exists($legacyPath)) {
            $this->warn("Missing legacy file for {$label}: {$legacyPath}");

            return ['path' => null, 'migrated' => 0, 'missing' => 1];
        }

        $this->line(($dryRun ? '[dry-run] Would copy ' : 'Copying ')."{$legacyPath} -> {$privatePath} ({$label})");

        if (! $dryRun) {
            Storage::disk(JamaahFileStorage::DISK)->put($privatePath, Storage::disk('public')->get($legacyPath));
        }

        return ['path' => $privatePath, 'migrated' => 1, 'missing' => 0];
    }
}
