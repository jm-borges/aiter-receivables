<?php

namespace Database\Seeders;

use App\Models\Core\Pivots\UserHasBusinessPartner;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BusinessPartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        $partners = [
            [
                'id' => '0199e43f-41cc-7072-875d-b4e58bd15dd4',
                'name' => 'EC Teste',
                'type' => 'client',
                'document_number' => '94000001000180',
            ],
            [
                'id' => '0199e442-a78f-70dc-8847-19a3d226460d',
                'name' => 'Fornecedor Teste',
                'type' => 'supplier',
                'document_number' => 'abababa',
            ],
            [
                'id' => '0199e443-bc66-71f7-9c09-dce76bf1205c',
                'name' => 'REDECARD INSTITUICAO DE PAGAMENTO S.A.',
                'fantasy_name' => 'REDECARD',
                'type' => 'acquirer',
                'document_number' => '01425787000104',
            ],
            [
                'id' => '0199e445-48de-705b-8ebc-d1cb233fd386',
                'name' => 'BANCO SAFRA S A',
                'type' => 'acquirer',
                'document_number' => '58160789000128',
            ],
            [
                'id' => '0199e445-c982-728d-8347-0f860c78ec7a',
                'name' => 'EC Teste 2',
                'type' => 'client',
                'document_number' => '00000878000127',
            ],
            [
                'id' => '0199e446-23bc-71b4-8ab9-2854109bb145',
                'name' => 'Fornecedor Teste 2',
                'type' => 'supplier',
                'document_number' => 'tbtbtbt',
            ],
        ];

        DB::table('business_partners')->insert(
            array_map(fn($p) => array_merge([
                'fantasy_name' => $p['fantasy_name'] ?? null,
                'description' => $p['description'] ?? null,
                'state_subscription' => null,
                'city_subscription' => null,
                'email' => null,
                'phone' => null,
                'postal_code' => null,
                'address' => null,
                'address_number' => null,
                'address_complement' => null,
                'address_neighborhood' => null,
                'address_city' => null,
                'address_city_code' => null,
                'address_state' => null,
                'address_state_code' => null,
                'base_document_number' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ], $p), $partners)
        );

        UserHasBusinessPartner::create([
            'business_partner_id' => '0199e442-a78f-70dc-8847-19a3d226460d',
            'user_id' => '019b329f-265e-70c1-9705-de91ae9db0f6',
        ]);
    }
}
