<?php

namespace App\Http\Controllers;

use App\Services\BeemSMSService;
use Illuminate\Http\Request;

class SMSController extends Controller
{
    protected $beemSMSService;

    public function __construct(BeemSMSService $beemSMSService)
    {
        $this->beemSMSService = $beemSMSService;
    }

    public function sendBulkSMS(Request $request)
    {
        $request->validate([
            'recipients' => 'required|array',
            'message' => 'required|string',
        ]);

        $recipients = $request->input('recipients');
        $message = $request->input('message');

        try {
            $response = $this->beemSMSService->sendBulkSMS($recipients, $message);

            return response()->json([
                'success' => true,
                'message' => 'Bulk SMS sent successfully',
                'response' => $response,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send bulk SMS',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
