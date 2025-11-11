<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        $contracts = [
            [
                'id' => '0199e46b-e7a4-72ff-a5c2-0b9b7b058c1b',
                'client_id' => '0199e43f-41cc-7072-875d-b4e58bd15dd4',
                'supplier_id' => '0199e442-a78f-70dc-8847-19a3d226460d',
                'value' => 15,
                'start_date' => '2025-10-13',
                'end_date' => '2025-10-20',
            ],
            [
                'id' => '0199e472-24b4-7039-b0d2-92e228326db2',
                'client_id' => '0199e445-c982-728d-8347-0f860c78ec7a',
                'supplier_id' => '0199e446-23bc-71b4-8ab9-2854109bb145',
                'value' => 35,
                'start_date' => '2025-10-14',
                'end_date' => '2025-10-23',
            ],
        ];

        DB::table('contracts')->insert(
            array_map(fn($c) => array_merge([
                'status' => null,
                'uses_registrar_management' => null,
                'current_achieved_value' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ], $c), $contracts)
        );
    }
}
