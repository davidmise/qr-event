<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BeemSMSService
{
    protected $apiKey;
    protected $secretKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('beem.api_key');
        $this->secretKey = config('beem.secret_key');
        $this->baseUrl = 'https://apisms.beem.africa/v1';
    }

    public function sendBulkSMS(array $recipients, string $message)
    {
        $postData = [
            'source_addr' => 'INFO',
            'encoding' => 0,
            'schedule_time' => '',
            'message' => $message,
            'recipients' => array_map(function($recipient, $index) {
                return [
                    'recipient_id' => $index + 1,
                    'dest_addr' => $recipient
                ];
            }, $recipients, array_keys($recipients))
        ];

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Basic ' . base64_encode("{$this->apiKey}:{$this->secretKey}"),
                'Content-Type' => 'application/json',
            ])->post("{$this->baseUrl}/send", $postData);

            Log::info('Beem SMS Response Status', ['status' => $response->status()]);
            Log::info('Beem SMS Response Body', ['response' => $response->json()]);

            if ($response->successful()) {
                Log::info('Bulk SMS sent successfully', ['response' => $response->json()]);
                return $response->json();
            } else {
                Log::error('Failed to send bulk SMS', ['response' => $response->json()]);
                throw new \Exception('Failed to send bulk SMS: ' . $response->body());
            }
        } catch (\Exception $e) {
            Log::error('Error sending bulk SMS', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
