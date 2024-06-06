<?php

namespace App\Services;

use Google_Client;
use Google_Service_Sheets;
use Google_Service_Exception;
use Illuminate\Support\Facades\Log;

class GoogleSheetsService
{
    protected $client;
    protected $service;
    protected $spreadsheetId;
    protected $range;

    public function __construct()
    {
        $this->client = new Google_Client();
        $this->client->setApplicationName('Laravel Google Sheets API');
        $this->client->setAuthConfig([
            'client_id' => env('GOOGLE_CLIENT_ID'),
            'client_secret' => env('GOOGLE_CLIENT_SECRET'),
            'redirect_uris' => [env('GOOGLE_REDIRECT_URI')],
        ]);
        $this->client->setDeveloperKey(env('GOOGLE_API_KEY'));
        $this->client->addScope(Google_Service_Sheets::SPREADSHEETS);
        $this->client->setAccessType('offline');
        $this->client->setPrompt('select_account consent');

        $this->spreadsheetId = env('GOOGLE_SHEET_ID');
        $this->range = env('GOOGLE_SHEET_RANGE');

        // Additional logging
        Log::info('Google Sheet ID:', ['GOOGLE_SHEET_ID' => $this->spreadsheetId]);
        Log::info('Google Sheet Range:', ['GOOGLE_SHEET_RANGE' => $this->range]);

        // Check actual values
        if (!$this->spreadsheetId) {
            Log::error('Google Sheet ID is not set in the environment variables');
            throw new \Exception('Google Sheet ID is not set in the environment variables');
        }
        if (!$this->range) {
            Log::error('Google Sheet range is not set in the environment variables');
            throw new \Exception('Google Sheet range is not set in the environment variables');
        }

        $this->service = new Google_Service_Sheets($this->client);
    }

    public function getSheetData()
    {
        try {
            $response = $this->service->spreadsheets_values->get($this->spreadsheetId, $this->range);
            return $response->getValues();
        } catch (Google_Service_Exception $e) {
            $error = json_decode($e->getMessage(), true);
            throw new \Exception($error['error']['message']);
        }
    }
}
