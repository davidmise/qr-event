<?php
// app/Services/VonageService.php

namespace App\Services;

use Vonage\Client;
use Vonage\Client\Credentials\Basic;

class VonageService
{
    protected $client;

    public function __construct()
    {
        $basic  = new Basic(config('services.vonage.api_key'), config('services.vonage.api_secret'));
        $this->client = new Client($basic);
    }

    public function sendSms($to, $message)
    {
        $response = $this->client->message()->send([
            'to' => $to,
            'from' => 'VonageAPI',
            'text' => $message
        ]);

        return $response;
    }
}
