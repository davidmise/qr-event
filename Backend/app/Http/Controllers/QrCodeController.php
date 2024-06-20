<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\SvgWriter;
use App\Models\Guest;

class QrCodeController extends Controller
{
    public function generateQrCode(Request $request)
    {
        // Validate guest data (optional)
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'string', // Ensure unique email
            'phone_number' => 'required|numeric|integer',
            'event_info_id' => 'required', // Ensure
        ]);

        // Retrieve guest data
        $guestData = $request->only('id','name', 'email', 'phone_number', 'event_info_id');
         // Create the guest in the database
         $guest = Guest::create([
            'name' => $guestData['name'],
            'email' => $guestData['email'],
            'phone_number' => $guestData['phone_number'],
            'event_info_id' => $guestData['event_info_id'],
            'status' => 'pending', // Initial status
        ]);
        // Generate QR code data (can include guest info)
        $qrCodeData = json_encode([
            'event_id' => $guest->event_info_id, // You can customize the data here
            'guest_id' => $guest->id, // You can customize the data here
            'status' => 'pending', // Initial status when QR code is generated
        ]);
             // Example: encode guest data

        // Retrieve data for QR code generation (e.g., event details)
        // $data = $request->input('data');

        // Generate QR code
        $qrCode = new QrCode($qrCodeData);

        // // Configure writer to generate SVG
        $writer = new SvgWriter();

        // Generate SVG QR code
        $svgImage = $writer->write($qrCode);

      // Update guest QR code with the generated SVG string
      $guest->qr_code = $svgImage->getString();
      $guest->save();


        return response()->json([
            'status' => true,
            'guest' => $guest, // Return created guest information
            'qr_code' => $svgImage->getString()
        ]);
    }
}
