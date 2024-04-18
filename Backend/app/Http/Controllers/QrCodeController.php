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
            'email' => 'required|email|unique:guests', // Ensure unique email
            'phone_number' => 'required|string',
        ]);
        // Retrieve guest data
        $guestData = $request->only('name', 'email', 'phone_number');
        // Generate QR code data (can include guest info)
        $qrCodeData = json_encode($guestData); // Example: encode guest data

        // Retrieve data for QR code generation (e.g., event details)
        // $data = $request->input('data');

        // Generate QR code
        $qrCode = new QrCode($qrCodeData);

        // // Configure writer to generate SVG
        $writer = new SvgWriter();

        // Generate SVG QR code
        $svgImage = $writer->write($qrCode);

        // Create Guest model instance and save
        $guest = Guest::create([
            'name' => $guestData['name'],
            'email' => $guestData['email'],
            'phone_number' => $guestData['phone_number'],
            'qr_code' => $svgImage->getString(), // Store SVG string
        ]);

        return response()->json([
            'status' => true,
            'guest' => $guest, // Return created guest information
            'qr_code' => $svgImage->getString()
        ]);
    }
}
