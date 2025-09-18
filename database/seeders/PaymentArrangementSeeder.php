<?php

namespace Database\Seeders;

use App\Models\Core\PaymentArrangement;
use Illuminate\Database\Seeder;

class PaymentArrangementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrangements = [
            ['code' => '006', 'name' => 'Amex Cartão de Crédito'],
            ['code' => '013', 'name' => 'Banescard Cartão de Crédito'],
            ['code' => '043', 'name' => 'Banescard Cartão de Débito'],
            ['code' => '010', 'name' => 'Cabal Crédito'],
            ['code' => '030', 'name' => 'Cabal Débito'],
            ['code' => '023', 'name' => 'CREDZ Crédito'],
            ['code' => '005', 'name' => 'Diners Cartão de Crédito'],
            ['code' => '008', 'name' => 'Elo Cartão de Crédito'],
            ['code' => '027', 'name' => 'Elo Cartão de Débito'],
            ['code' => '037', 'name' => 'Goodcard Crédito'],
            ['code' => '021', 'name' => 'Hipercard Cartão de Crédito'],
            ['code' => '031', 'name' => 'JCB Cartão de Crédito'],
            ['code' => '003', 'name' => 'Mastercard Cartão de Crédito'],
            ['code' => '025', 'name' => 'Mastercard Cartão de Débito'],
            ['code' => '047', 'name' => 'Ourocard Cartão de Débito'],
            ['code' => '019', 'name' => 'Sorocred Cartão de Crédito'],
            ['code' => '048', 'name' => 'Sorocred Cartão de Débito'],
            ['code' => '004', 'name' => 'Visa Cartão de Crédito'],
            ['code' => '026', 'name' => 'Visa Cartão de Débito'],
            ['code' => '020', 'name' => 'Verdecard Cartão de Crédito'],
            ['code' => '015', 'name' => 'Mais Cartão de Crédito'],
            ['code' => '016', 'name' => 'China UnionPay'],
            ['code' => '007', 'name' => 'Hipercard Cartão de Débito'],
            ['code' => '018', 'name' => 'Sicred Crédito'],
            ['code' => '060', 'name' => 'Agiplan'],
            ['code' => '061', 'name' => 'Aura'],
            ['code' => '062', 'name' => 'Avista'],
            ['code' => '063', 'name' => 'Banese Card'],
            ['code' => '064', 'name' => 'Brasil Card'],
            ['code' => '065', 'name' => 'Banrisul'],
            ['code' => '066', 'name' => 'Calcard'],
            ['code' => '067', 'name' => 'Credi-Shop'],
            ['code' => '069', 'name' => 'Dacasa'],
            ['code' => '070', 'name' => 'Discover'],
            ['code' => '071', 'name' => 'Fortbrasil'],
            ['code' => '072', 'name' => 'Maxifrota'],
            ['code' => '073', 'name' => 'Redesplan'],
            ['code' => '074', 'name' => 'Senff'],
            ['code' => '075', 'name' => 'Sem Parar'],
            ['code' => '076', 'name' => 'TicketLog Pós'],
        ];

        foreach ($arrangements as $arrangement) {
            PaymentArrangement::create($arrangement);
        }
    }
}
