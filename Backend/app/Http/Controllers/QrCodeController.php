<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\SvgWriter;

class QrCodeController extends Controller
{
    public function generateQrCode(Request $request)
    {
        // Retrieve data for QR code generation (e.g., event details)
        $data = $request->input('data');

        // Generate QR code
        $qrCode = new QrCode($data);

        // Configure writer to generate SVG
        $writer = new SvgWriter();

        // Generate SVG QR code
        $svgImage = $writer->write($qrCode);

        return response()->json(['qr_code' => $svgImage->getString()]);
    }
}
