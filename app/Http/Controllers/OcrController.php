<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OcrController extends Controller
{
    public function processTalon(Request $request)
    {
        try {
            $response = Http::timeout(30)->attach(
                'image',
                file_get_contents($request->file('image')->path()),
                $request->file('image')->getClientOriginalName()
            )->post('http://127.0.0.1:5001/ocr');

            return $response->json();

        } catch (\Exception $e) {
            return response()->json([
                "error" => "Eroare la procesare: " . $e->getMessage()
            ], 500);
        }
    }
}
