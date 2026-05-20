<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LogController extends Controller
{
    /** Max bytes to read from the end of the log file (2 MB) */
    const MAX_READ_BYTES = 2 * 1024 * 1024;

    /** Log entries shown per page */
    const PER_PAGE = 50;

    public function index(Request $request)
    {
        $logPath   = storage_path('logs/laravel.log');
        $fileSize  = 0;
        $truncated = false;
        $entries   = [];

        if (File::exists($logPath)) {
            $fileSize = File::size($logPath);
            $handle   = fopen($logPath, 'r');

            if ($fileSize > self::MAX_READ_BYTES) {
                fseek($handle, -self::MAX_READ_BYTES, SEEK_END);
                $truncated = true;
            }

            $raw = fread($handle, self::MAX_READ_BYTES);
            fclose($handle);

            // Parse individual log entries (each starts with a [YYYY-MM-DD HH:MM:SS] line)
            $pattern = '/\[\d{4}-\d{2}-\d{2}[T ]\d{2}:\d{2}:\d{2}[^\]]*\]/';
            $parts   = preg_split('/(?=\[\d{4}-\d{2}-\d{2})/', $raw, -1, PREG_SPLIT_NO_EMPTY);

            foreach (array_reverse($parts) as $part) {
                $part = trim($part);
                if ($part === '') {
                    continue;
                }

                $level = 'info';
                if (preg_match('/\]\s+\w+\.(ERROR|CRITICAL|ALERT|EMERGENCY):/i', $part, $m)) {
                    $level = strtolower($m[1]);
                } elseif (preg_match('/\]\s+\w+\.(WARNING|NOTICE):/i', $part, $m)) {
                    $level = strtolower($m[1]);
                } elseif (preg_match('/\]\s+\w+\.(DEBUG):/i', $part, $m)) {
                    $level = 'debug';
                }

                $entries[] = [
                    'level'   => $level,
                    'content' => htmlspecialchars($part, ENT_QUOTES, 'UTF-8'),
                ];
            }
        }

        $total   = count($entries);
        $page    = max(1, (int) $request->input('page', 1));
        $offset  = ($page - 1) * self::PER_PAGE;
        $paged   = array_slice($entries, $offset, self::PER_PAGE);

        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $paged,
            $total,
            self::PER_PAGE,
            $page,
            ['path' => route('admin.logs'), 'query' => $request->query()]
        );

        return view('admin.logs', compact('paginator', 'fileSize', 'truncated', 'total'));
    }

    public function clear()
    {
        $logPath = storage_path('logs/laravel.log');
        if (File::exists($logPath)) {
            File::put($logPath, '');
        }
        return back()->with('success', 'Log file berhasil dikosongkan.');
    }
}
