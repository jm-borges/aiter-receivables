<?php

namespace Database\Seeders;

use App\Enums\BusinessPartnerType;
use App\Models\Core\BusinessPartner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BusinessPartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ADQUIRENTES

        /*  BusinessPartner::create([
            'name',
            'fantasy_name',
            'description',
            'type' => BusinessPartnerType::ACQUIRER,
            'document_number',
            'state_subscription',
            'city_subscription',
            'email', //string
            'phone', //string

            'postal_code', //string
            'address', //string
            'address_number', //string
            'address_complement', //string
            'address_neighborhood', //string
            'address_city', //string
            'address_city_code',
            'address_state', //string
            'address_state_code',
        ]); */
    }
}
