<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

/**
 * WhatsAppRotator
 *
 * Distributes incoming leads evenly across multiple WhatsApp CS numbers.
 * Strategy: round-robin using a shared Cache counter so every server node
 * in a load-balanced cluster advances the same pointer (requires Redis or
 * database cache — NOT file cache).
 *
 * Usage:
 *   $waLink = WhatsAppRotator::getLink($numbers, $message, $cacheKeyPrefix);
 */
class WhatsAppRotator
{
    /**
     * Pick the next WhatsApp number in round-robin order and return a full wa.me link.
     *
     * @param  array   $numbers         Raw phone numbers (may contain +, -, spaces)
     * @param  string  $message         URL-encoded message to pre-fill in WA
     * @param  string  $cacheKeyPrefix  Unique key per landing page to keep rotations separate
     * @return string|null              wa.me deep-link URL or null if no numbers available
     */
    public static function getLink(array $numbers, string $message = '', string $cacheKeyPrefix = 'wa_rotator'): ?string
    {
        // Sanitize: strip all non-numeric characters
        $cleaned = array_values(array_filter(
            array_map(fn ($n) => preg_replace('/[^0-9]/', '', $n), $numbers)
        ));

        if (empty($cleaned)) {
            return null;
        }

        $count     = count($cleaned);
        $cacheKey  = "wa_rotator_{$cacheKeyPrefix}_index";

        // Atomically increment & wrap around using Cache
        $index = Cache::remember($cacheKey, 86400, fn () => 0);
        $selectedNumber = $cleaned[$index % $count];

        // Advance pointer for the next request
        Cache::put($cacheKey, ($index + 1) % $count, 86400);

        return 'https://api.whatsapp.com/send?phone=' . $selectedNumber
            . ($message ? ('&text=' . $message) : '');
    }

    /**
     * Parse a comma-separated WA number string into a clean array.
     */
    public static function parseNumbers(string $rawInput): array
    {
        return array_values(array_filter(
            array_map('trim', explode(',', $rawInput))
        ));
    }
}
