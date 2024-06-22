<?php
namespace App\Http\Controllers;
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Vonage\Client\Credentials\Basic;
use Vonage\Client as VonageClient;
use Illuminate\Support\Facades\Validator;

class SmsController extends Controller
{
    public function sendSms(Request $request)
    {
        // Validate the request inputs
        $validator = Validator::make($request->all(), [
            'phone_numbers' => 'required|array',
            'phone_numbers.*' => 'required|string',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $phoneNumbers = $request->input('phone_numbers');
        $message = $request->input('message');

        $basic  = new Basic(env('VONAGE_API_KEY'), env('VONAGE_API_SECRET'));
        $client = new VonageClient($basic);

        try {
            foreach ($phoneNumbers as $number) {
                $response = $client->sms()->send(
                    new \Vonage\SMS\Message\SMS($number, 'YourAppName', $message)
                );

                $messageStatus = $response->current();
                if ($messageStatus->getStatus() != 0) {
                    return response()->json([
                        'status' => false,
                        'message' => "The message failed with status: " . $messageStatus->getStatus() . "\n",
                    ], 500);
                }
            }

            return response()->json([
                'status' => true,
                'message' => 'SMS sent successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
