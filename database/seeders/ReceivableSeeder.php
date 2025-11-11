<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ReceivableSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $receivables = [
            // Recebíveis do contrato EC Teste / Fornecedor Teste
            [
                'id' => (string) Str::uuid(),
                'client_id' => '0199e43f-41cc-7072-875d-b4e58bd15dd4', // EC Teste
                'acquirer_id' => '0199e443-bc66-71f7-9c09-dce76bf1205c', // REDECARD
                'dtPrevtLiquid' => '2025-10-21',
                'vlrLivreUsuFinalRecbdr' => 8200.55,
                'vlrTot' => 8200.55,
                'amount_locked_by_others' => 0.00,
                'available_value' => 8200.55,
            ],
            [
                'id' => (string) Str::uuid(),
                'client_id' => '0199e43f-41cc-7072-875d-b4e58bd15dd4',
                'acquirer_id' => '0199e443-bc66-71f7-9c09-dce76bf1205c',
                'dtPrevtLiquid' => '2025-10-24',
                'vlrLivreUsuFinalRecbdr' => 4980.30,
                'vlrTot' => 4980.30,
                'amount_locked_by_others' => 580.30,
                'available_value' => 4400.00,
            ],

            // Recebíveis do contrato EC Teste 2 / Fornecedor Teste 2
            [
                'id' => (string) Str::uuid(),
                'client_id' => '0199e445-c982-728d-8347-0f860c78ec7a', // EC Teste 2
                'acquirer_id' => '0199e445-48de-705b-8ebc-d1cb233fd386', // Banco Safra
                'dtPrevtLiquid' => '2025-10-25',
                'vlrLivreUsuFinalRecbdr' => 11250.00,
                'vlrTot' => 11250.00,
                'amount_locked_by_others' => 1250.00,
                'available_value' => 10000.00,
            ],
            [
                'id' => (string) Str::uuid(),
                'client_id' => '0199e445-c982-728d-8347-0f860c78ec7a',
                'acquirer_id' => '0199e445-48de-705b-8ebc-d1cb233fd386',
                'dtPrevtLiquid' => '2025-10-29',
                'vlrLivreUsuFinalRecbdr' => 6350.70,
                'vlrTot' => 6350.70,
                'amount_locked_by_others' => 0.00,
                'available_value' => 6350.70,
            ],
        ];

        DB::table('receivables')->insert(
            array_map(fn($r) => array_merge([
                'opt_in_id' => null,
                'payment_arrangement_id' => null,
                'tpObj' => null,
                'cnpjER' => null,
                'cnpjCreddrSub' => null,
                'codInstitdrArrajPgto' => null,
                'cnpjOuCnpjBaseOuCpfUsuFinalRecbdr' => null,
                'indrDomcl' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ], $r), $receivables)
        );
    }
}
