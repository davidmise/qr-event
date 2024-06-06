<?php

namespace App\Http\Controllers;

use App\Models\GuestList;
use App\Services\GoogleSheetsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class GoogleSheetsController extends Controller
{
    protected $googleSheetsService;

    public function __construct(GoogleSheetsService $googleSheetsService)
    {
        $this->googleSheetsService = $googleSheetsService;
    }

    public function index(Request $request)
    {
        try {
            // Fetch data from Google Sheets without caching
            $data = $this->googleSheetsService->getSheetData(false);

            // Log the retrieved data for debugging
            Log::info('Retrieved Google Sheets data:', $data);

            // Extract the header row and ensure it has the expected structure
            $header = array_shift($data); // Remove the header row
            $expectedColumns = ['name', 'phone_number', 'email'];

            // Ensure header row has the expected columns
            if ($header !== $expectedColumns) {
                Log::error('Unexpected header row:', ['header' => $header]);
                return response()->json(['error' => 'Unexpected header row'], 400);
            }

            // Ensure each data row has the same number of elements as the header row
            $transformedData = array_map(function($row) use ($header) {
                $row = array_pad($row, count($header), null);
                return array_combine($header, $row);
            }, $data);

            // Log the transformed data for debugging
            Log::info('Transformed Google Sheets data:', $transformedData);

            // Validate and store the data in the database
            $storedData = [];
            foreach ($transformedData as $row) {
                $validator = Validator::make($row, [
                    'name' => 'required|string',
                    'email' => 'nullable|email|unique:guest_lists,email',
                    'phone_number' => 'nullable|string|unique:guest_lists,phone_number', // Considering phone number as a string
                ]);

                if ($validator->fails()) {
                    // Log validation errors
                    Log::warning('Validation failed for row:', [
                        'row' => $row,
                        'errors' => $validator->errors()
                    ]);
                    continue; // Skip invalid entries
                }

                $guest = GuestList::create([
                    'name' => $row['name'],
                    'email' => $row['email'] ?? null,
                    'phone_number' => $row['phone_number'] ?? null,
                ]);

                $storedData[] = $guest;
            }

            return response()->json(['message' => 'Data retrieved and stored successfully', 'stored_data' => $storedData]);
        } catch (\Exception $e) {
            // Log exception
            Log::error('Error in GoogleSheetsController:', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
