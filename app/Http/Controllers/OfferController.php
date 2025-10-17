<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OfferController extends Controller
{
    private function validatetermTime($termTime)
    {
        if ($termTime < 1 or $termTime > 12) {
            return ['valid' => false];
        }
    }

    private function validatestartDate($startDate)
    {
        if (!(Carbon::parse($startDate)->format('Y-m-d') > '2025-07-25' and Carbon::parse($startDate)->format('Y-m-d') < '2025-09-24')) {
            return ['valid' => 'false', 'message' => 'Invalid date'];
        }
    }

    private function validatemobileNumber($mobileNumber)
    {
        $mobileNumber = trim($mobileNumber);
        if (!(preg_match('/07\d{8}$/', $mobileNumber))) {
            return ['valid' => 'false', 'message' => 'Invalid mobile number'];
        }
    }

    private function validateexpirationDatePti($expirationDatePti)
    {
        if (empty($expirationDatePti) || Carbon::parse($expirationDatePti)->format('Y-m-d') <= '2025-07-24') {
            return ['valid' => 'false', 'message' => 'Invalid date'];
        }
    }

    private function validateCnp($cnp)
    {
        if (empty($cnp) || strlen($cnp) != 13 || !ctype_digit($cnp)) {
            return ['valid' => false, 'birthdate' => null];
        }

        try {
            $s = (int)substr($cnp, 0, 1);
            $aa = (int)substr($cnp, 1, 2);
            $ll = (int)substr($cnp, 3, 2);
            $zz = (int)substr($cnp, 5, 2);

            $year = ($s == 1 || $s == 2) ? 1900 + $aa : (($s == 5 || $s == 6) ? 2000 + $aa : null);
            if (!$year || !checkdate($ll, $zz, $year)) {
                return ['valid' => false, 'birthdate' => null];
            }

            $birthdate = Carbon::create($year, $ll, $zz);
            $age = Carbon::now()->diffInYears($birthdate);

            if ($age < 18) {
                return ['valid' => false, 'birthdate' => $birthdate->toDateString()];
            }

            return ['valid' => true, 'birthdate' => $birthdate->toDateString()];
        } catch (\Exception $e) {
            Log::error('CNP validation error: ' . $e->getMessage());
            return ['valid' => false, 'birthdate' => null];
        }
    }

    public function store(Request $request)
    {
        set_time_limit(120);

        $token = $request->header('Token');
        if (!$token) {
            return response()->json(['success' => false, 'message' => 'Token lipsă'], 401);
        }

        $originalPayload = $request->all();

        $insurers = [
            'asirom', 'axeria', 'generali', 'groupama',
            'hellas_autonom', 'hellas_nextins', 'omniasig', 'grawe',
            'eazy_insure', 'dallbogg'
        ];

        $rawResponses = [];
        $normalizedOffers = [];

        foreach ($insurers as $insurer) {
            $payload = $originalPayload;
            $payload['provider']['organization']['businessName'] = $insurer;

            try {
                $apiResponse = Http::withOptions(['verify' => false])
                    ->timeout(30) // limită rezonabilă
                    ->withHeaders([
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'Token' => $token,
                    ])
                    ->post('https://rca-qa.api.lifeishard.ro/offer', $payload);

                $statusCode = $apiResponse->status();
                $responseData = $apiResponse->json() ?? [];

                $rawResponses[$insurer] = [
                    'success' => $apiResponse->successful(),
                    'status' => $statusCode,
                    'premiumAmount' => $responseData['data']['offers'][0]['premiumAmount'] ?? null,
                    'data' => $responseData,
                    'error_message' => $responseData['message'] ?? null,
                    'validation_errors' => $responseData['data'] ?? null,
                    'correlation_id' => $responseData['correlation_id'] ?? null,
                ];


                if ($apiResponse->successful()) {
                    $offer = $responseData['data']['offers'][0] ?? null;

                    $normalizedOffers[] = [
                        'insurer' => $insurer,
                        'status' => 'success',
                        'premium' => $offer['premiumAmount'] ?? null,
                        'offerId' => $offer['offerId'] ?? null,
                        'pid' => $offer['pid'] ?? null,
                        'bonusMalus' => $offer['bonusMalusClass'] ?? null,
                        'startDate' => $offer['startDate'] ?? null,
                    ];
                } else {
                    $normalizedOffers[] = [
                        'insurer' => $insurer,
                        'status' => 'error',
                        'message' => $responseData['message'] ?? 'Eroare necunoscută',
                        'validationErrors' => $responseData['data'] ?? null,
                        'correlation_id' => $responseData['correlation_id'] ?? null,
                    ];
                }
            } catch (\Exception $e) {
                \Log::error("Eroare la {$insurer}: " . $e->getMessage());

                $rawResponses[$insurer] = [
                    'success' => false,
                    'status' => 500,
                    'error_message' => $e->getMessage(),
                ];

                $normalizedOffers[] = [
                    'insurer' => $insurer,
                    'status' => 'error',
                    'message' => $e->getMessage(),
                ];
            }
        }


        $oferte = Offer::create([
            'insurance_data' => [
                'raw' => $rawResponses,
                'normalized' => $normalizedOffers,
            ]
        ]);

        return response()->json([
            'message' => 'Ofertele au fost procesate.',
            'offer_id' => $oferte->id ?? null,
            'offers' => $normalizedOffers,
        ], 201);
    }


    public function index()
    {
        $offers = Offer::all(['id', 'insurance_data']);
        return response()->json($offers);
    }

    public function show($id)
    {
        try {
            $offer = Offer::findOrFail($id);
            return response()->json($offer->insurance_data);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Oferta nu a fost găsită.'], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Eroare la încărcarea ofertei.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
