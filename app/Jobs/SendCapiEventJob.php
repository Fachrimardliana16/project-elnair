<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendCapiEventJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $url;

    protected $data;

    protected $headers;

    /**
     * Create a new job instance.
     */
    public function __construct(string $url, array $data, array $headers = [])
    {
        $this->url = $url;
        $this->data = $data;
        $this->headers = $headers;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($this->data));

            $headers = $this->headers;
            $hasContentType = false;
            foreach ($headers as $header) {
                if (stripos($header, 'Content-Type:') !== false) {
                    $hasContentType = true;
                    break;
                }
            }
            if (! $hasContentType) {
                $headers[] = 'Content-Type: application/json';
            }

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Safe 10s timeout inside the queue worker

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode >= 400) {
                Log::warning("CAPI background request returned status code {$httpCode}. Response: {$response}");
            }
        } catch (\Exception $e) {
            Log::error('CAPI background request failed: '.$e->getMessage());
        }
    }
}
