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
            ['code' => '006', 'name' => 'Amex Cartão de Crédito', 'type' => 'credit'],
            ['code' => '013', 'name' => 'Banescard Cartão de Crédito', 'type' => 'credit'],
            ['code' => '043', 'name' => 'Banescard Cartão de Débito', 'type' => 'debit'],
            ['code' => '010', 'name' => 'Cabal Crédito', 'type' => 'credit'],
            ['code' => '030', 'name' => 'Cabal Débito', 'type' => 'debit'],
            ['code' => '023', 'name' => 'CREDZ Crédito', 'type' => 'credit'],
            ['code' => '005', 'name' => 'Diners Cartão de Crédito', 'type' => 'credit'],
            ['code' => '008', 'name' => 'Elo Cartão de Crédito', 'type' => 'credit'],
            ['code' => '027', 'name' => 'Elo Cartão de Débito', 'type' => 'debit'],
            ['code' => '037', 'name' => 'Goodcard Crédito', 'type' => 'credit'],
            ['code' => '021', 'name' => 'Hipercard Cartão de Crédito', 'type' => 'credit'],
            ['code' => '031', 'name' => 'JCB Cartão de Crédito', 'type' => 'credit'],
            ['code' => '003', 'name' => 'Mastercard Cartão de Crédito', 'type' => 'credit'],
            ['code' => '025', 'name' => 'Mastercard Cartão de Débito', 'type' => 'debit'],
            ['code' => '047', 'name' => 'Ourocard Cartão de Débito', 'type' => 'debit'],
            ['code' => '019', 'name' => 'Sorocred Cartão de Crédito', 'type' => 'credit'],
            ['code' => '048', 'name' => 'Sorocred Cartão de Débito', 'type' => 'debit'],
            ['code' => '004', 'name' => 'Visa Cartão de Crédito', 'type' => 'credit'],
            ['code' => '026', 'name' => 'Visa Cartão de Débito', 'type' => 'debit'],
            ['code' => '020', 'name' => 'Verdecard Cartão de Crédito', 'type' => 'credit'],
            ['code' => '015', 'name' => 'Mais Cartão de Crédito', 'type' => 'credit'],
            ['code' => '016', 'name' => 'China UnionPay', 'type' => null],
            ['code' => '007', 'name' => 'Hipercard Cartão de Débito', 'type' => 'debit'],
            ['code' => '018', 'name' => 'Sicred Crédito', 'type' => 'credit'],
            ['code' => '060', 'name' => 'Agiplan', 'type' => null],
            ['code' => '061', 'name' => 'Aura', 'type' => null],
            ['code' => '062', 'name' => 'Avista', 'type' => null],
            ['code' => '063', 'name' => 'Banese Card', 'type' => null],
            ['code' => '064', 'name' => 'Brasil Card', 'type' => null],
            ['code' => '065', 'name' => 'Banrisul', 'type' => null],
            ['code' => '066', 'name' => 'Calcard', 'type' => null],
            ['code' => '067', 'name' => 'Credi-Shop', 'type' => null],
            ['code' => '069', 'name' => 'Dacasa', 'type' => null],
            ['code' => '070', 'name' => 'Discover', 'type' => null],
            ['code' => '071', 'name' => 'Fortbrasil', 'type' => null],
            ['code' => '072', 'name' => 'Maxifrota', 'type' => null],
            ['code' => '073', 'name' => 'Redesplan', 'type' => null],
            ['code' => '074', 'name' => 'Senff', 'type' => null],
            ['code' => '075', 'name' => 'Sem Parar', 'type' => null],
            ['code' => '076', 'name' => 'TicketLog Pós', 'type' => null],
        ];

        foreach ($arrangements as $arrangement) {
            PaymentArrangement::create($arrangement);
        }
    }
}
