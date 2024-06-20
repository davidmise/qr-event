<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\SvgWriter;
use App\Models\Guest;
use Validator;

class QrCodeController extends Controller
{
    public function generateQrCode(Request $request)
    {
        // Validate guest data
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'string',
            'phone_number' => 'required|numeric|integer',
            'event_info_id' => 'required|integer|exists:event_infos,id',
        ]);

        // Retrieve guest data
        $guestData = $request->only('name', 'email', 'phone_number', 'event_info_id');
        
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
            'event_info_id' => $guest->event_info_id,
            'guest_id' => $guest->id,
            'status' => 'pending', // Initial status when QR code is generated
        ]);

        // Generate QR code
        $qrCode = new QrCode($qrCodeData);
        $writer = new SvgWriter();
        $svgImage = $writer->write($qrCode);

        // Update guest QR code with the generated SVG string
        $guest->qr_code = $svgImage->getString();
        $guest->save();

        return response()->json([
            'status' => true,
            'guest' => $guest,
            'qr_code' => $svgImage->getString()
        ]);
    }
}
