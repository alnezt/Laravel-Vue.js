<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OfferSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('oferte')->insert([
            [
                'insurance_data' => json_encode([
                    'generali' => [
                        'success' => true,
                        'status' => 200,
                        'premiumAmount' => 500.25,
                        'data' => [
                            'oferte' => [
                                [
                                    'premiumAmount' => 500.25,
                                    'startDate' => Carbon::now()->toDateString(),
                                    'endDate' => Carbon::now()->addYear()->toDateString()
                                ]
                            ]
                        ]
                    ],
                    'groupama' => [
                        'success' => false,
                        'status' => 400,
                        'error_message' => 'Vehicul invalid'
                    ]
                ]),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
