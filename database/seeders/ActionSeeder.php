<?php

namespace Database\Seeders;

use App\Models\Core\Action;
use App\Enums\ActionInvolvedPartyType;
use App\Enums\ActionType;
use Illuminate\Database\Seeder;

class ActionSeeder extends Seeder
{
    public function run(): void
    {
        $actions = [
            [
                'name' => 'ARRC001',
                'class_name' => 'App\\Actions\\ARRC001Action',
                'description' => 'Credenciador informa a agenda de recebíveis com as unidades de recebíveis constituídas, os valores pré-contratados e as informações sobre a liquidação dos recebíveis.',
                'type' => ActionType::FILE,
                'sender' => ActionInvolvedPartyType::ACCREDITATOR,
                'recipient' => ActionInvolvedPartyType::REGISTRAR,
            ],
            [
                'name' => 'ARRC002',
                'class_name' => 'App\\Actions\\ARRC002Action',
                'description' => 'Credenciador informa a baixa de unidades de recebíveis.',
                'type' => ActionType::FILE,
                'sender' => ActionInvolvedPartyType::ACCREDITATOR,
                'recipient' => ActionInvolvedPartyType::REGISTRAR,
            ],
            [
                'name' => 'ARRC018',
                'class_name' => 'App\\Actions\\ARRC018Action',
                'description' => 'Registradora NÚCLEA informa a agenda de recebíveis.',
                'type' => ActionType::FILE,
                'sender' => ActionInvolvedPartyType::REGISTRAR,
                'recipient' => ActionInvolvedPartyType::FINANCIER_AND_ACCREDITATOR,
            ],
            [
                'name' => 'CRRC039',
                'class_name' => 'App\\Actions\\CRRC039Action',
                'description' => 'Registradora NÚCLEA informa opt-in para conciliação.',
                'type' => ActionType::FILE,
                'sender' => ActionInvolvedPartyType::REGISTRAR,
                'recipient' => ActionInvolvedPartyType::FINANCIER_AND_ACCREDITATOR,
            ],
            [
                'name' => 'RRC0010',
                'class_name' => 'App\\Actions\\RRC0010Action',
                'description' => 'Credenciadora / Instituição Financeira / Não Financeira realiza a consulta de recebíveis.',
                'type' => ActionType::MESSAGE,
                'sender' => ActionInvolvedPartyType::FINANCIER_AND_ACCREDITATOR,
                'recipient' => ActionInvolvedPartyType::REGISTRAR,
            ],
            [
                'name' => 'RRC0011',
                'class_name' => 'App\\Actions\\RRC0011Action',
                'description' => 'Credenciadora / Instituição Financeira / Não Financeira realiza a inclusão da autorização de envio de agenda.',
                'type' => ActionType::MESSAGE,
                'sender' => ActionInvolvedPartyType::FINANCIER_AND_ACCREDITATOR,
                'recipient' => ActionInvolvedPartyType::REGISTRAR,
            ],
            [
                'name' => 'RRC0013',
                'class_name' => 'App\\Actions\\RRC0013Action',
                'description' => 'Credenciadora / Instituição Financeira / Não Financeira realiza a inclusão do cancelamento da autorização de envio de agenda.',
                'type' => ActionType::MESSAGE,
                'sender' => ActionInvolvedPartyType::FINANCIER_AND_ACCREDITATOR,
                'recipient' => ActionInvolvedPartyType::REGISTRAR,
            ],
            [
                'name' => 'RRC0028',
                'class_name' => 'App\\Actions\\RRC0028Action',
                'description' => 'Registradora NÚCLEA informa a inclusão da autorização de envio de agenda.',
                'type' => ActionType::MESSAGE,
                'sender' => ActionInvolvedPartyType::REGISTRAR,
                'recipient' => ActionInvolvedPartyType::FINANCIER_AND_ACCREDITATOR,
            ],
            [
                'name' => 'RRC0029',
                'class_name' => 'App\\Actions\\RRC0029Action',
                'description' => 'Registradora NÚCLEA informa a inclusão do cancelamento da autorização de envio de agenda.',
                'type' => ActionType::MESSAGE,
                'sender' => ActionInvolvedPartyType::REGISTRAR,
                'recipient' => ActionInvolvedPartyType::FINANCIER_AND_ACCREDITATOR,
            ],

            //--------------------------------------------------------

            [
                'name' => 'ARRC022',
                'class_name' => 'App\\Actions\\ARRC022Action',
                'description' => 'Instituição Financeira / Não Financeira realiza a inclusão e alteração da negociação de recebíveis em lote.',
                'type' => ActionType::FILE,
                'sender' => ActionInvolvedPartyType::FINANCIER,
                'recipient' => ActionInvolvedPartyType::REGISTRAR,
            ],
            [
                'name' => 'ARRC023',
                'class_name' => 'App\\Actions\\ARRC023Action',
                'description' => 'Instituição Financeira / Não Financeira realiza a inclusão do cancelamento da negociação de recebíveis em lote.',
                'type' => ActionType::FILE,
                'sender' => ActionInvolvedPartyType::FINANCIER,
                'recipient' => ActionInvolvedPartyType::REGISTRAR,
            ],
            [
                'name' => 'ARRC031',
                'class_name' => 'App\\Actions\\ARRC031Action',
                'description' => 'Registradora NÚCLEA informa negociação de recebíveis a constituir.',
                'type' => ActionType::FILE,
                'sender' => ActionInvolvedPartyType::REGISTRAR,
                'recipient' => ActionInvolvedPartyType::FINANCIER_AND_ACCREDITATOR,
            ],
            [
                'name' => 'ARRC033',
                'class_name' => 'App\\Actions\\ARRC033Action',
                'description' => 'Instituição Financeira / Não Financeira realiza a inclusão e alteração do identificador IPOC.',
                'type' => ActionType::FILE,
                'sender' => ActionInvolvedPartyType::FINANCIER,
                'recipient' => ActionInvolvedPartyType::REGISTRAR,
            ],
            [
                'name' => 'ARRC036',
                'class_name' => 'App\\Actions\\ARRC036Action',
                'description' => 'Instituição Financeira / Não Financeira realiza a alteração do domicílio bancário da negociação de recebíveis em lote.',
                'type' => ActionType::FILE,
                'sender' => ActionInvolvedPartyType::FINANCIER,
                'recipient' => ActionInvolvedPartyType::REGISTRAR,
            ],
            [
                'name' => 'CRRC034',
                'class_name' => 'App\\Actions\\CRRC034Action',
                'description' => 'Registradora NÚCLEA informa negociações para conciliação.',
                'type' => ActionType::FILE,
                'sender' => ActionInvolvedPartyType::REGISTRAR,
                'recipient' => ActionInvolvedPartyType::FINANCIER_AND_ACCREDITATOR,
            ],
            [
                'name' => 'CRRC037',
                'class_name' => 'App\\Actions\\CRRC037Action',
                'description' => 'Registradora NÚCLEA informa negociações inconsistentes para conciliação do credenciador.',
                'type' => ActionType::FILE,
                'sender' => ActionInvolvedPartyType::REGISTRAR,
                'recipient' => ActionInvolvedPartyType::ACCREDITATOR,
            ],
            [
                'name' => 'CRRC043',
                'class_name' => 'App\\Actions\\CRRC043Action',
                'description' => 'Registradora Núclea informa processo de baixa de contratos automatizada para IF/NIF.',
                'type' => ActionType::FILE,
                'sender' => ActionInvolvedPartyType::REGISTRAR,
                'recipient' => ActionInvolvedPartyType::FINANCIER,
            ],
            [
                'name' => 'RRC0009',
                'class_name' => 'App\\Actions\\RRC0009Action',
                'description' => 'Registradora NÚCLEA informa a alteração da negociação de recebíveis às Instituição Financeira / Não Financeira.',
                'type' => ActionType::MESSAGE,
                'sender' => ActionInvolvedPartyType::REGISTRAR,
                'recipient' => ActionInvolvedPartyType::FINANCIER,
            ],
            [
                'name' => 'RRC0019',
                'class_name' => 'App\\Actions\\RRC0019Action',
                'description' => 'Instituição Financeira / Não Financeira realiza a inclusão ou alteração da negociação de recebíveis.',
                'type' => ActionType::MESSAGE,
                'sender' => ActionInvolvedPartyType::FINANCIER,
                'recipient' => ActionInvolvedPartyType::REGISTRAR,
            ],
            [
                'name' => 'RRC0020',
                'class_name' => 'App\\Actions\\RRC0020Action',
                'description' => 'Instituição Financeira / Não Financeira realiza a inclusão do cancelamento da negociação de recebíveis.',
                'type' => ActionType::MESSAGE,
                'sender' => ActionInvolvedPartyType::FINANCIER,
                'recipient' => ActionInvolvedPartyType::REGISTRAR,
            ],
            [
                'name' => 'RRC0021',
                'class_name' => 'App\\Actions\\RRC0021Action',
                'description' => 'Instituição Financeira / Não Financeira realiza a consulta de negociação de recebíveis.',
                'type' => ActionType::MESSAGE,
                'sender' => ActionInvolvedPartyType::FINANCIER,
                'recipient' => ActionInvolvedPartyType::REGISTRAR,
            ],
            [
                'name' => 'RRC0035',
                'class_name' => 'App\\Actions\\RRC0035Action',
                'description' => 'Instituição Financeira / Não Financeira realiza a alteração do domicílio bancário da negociação de recebíveis.',
                'type' => ActionType::MESSAGE,
                'sender' => ActionInvolvedPartyType::FINANCIER,
                'recipient' => ActionInvolvedPartyType::REGISTRAR,
            ],

            // --------------------------------------------------------

            [
                'name' => 'RRC0012',
                'class_name' => 'App\\Actions\\RRC0012Action',
                'description' => 'Credenciadora / Instituição Financeira / Não Financeira realiza a comunicação de resilição ou liberação de excedente de garantia.',
                'type' => ActionType::MESSAGE,
                'sender' => ActionInvolvedPartyType::FINANCIER_AND_ACCREDITATOR,
                'recipient' => ActionInvolvedPartyType::REGISTRAR,
            ],
            [
                'name' => 'RRC0014',
                'class_name' => 'App\\Actions\\RRC0014Action',
                'description' => 'Registradora NÚCLEA informa a comunicação de resilição ou liberação de excedente de garantia às Instituições Financeiras / Não Financeiras / Credenciadora.',
                'type' => ActionType::MESSAGE,
                'sender' => ActionInvolvedPartyType::REGISTRAR,
                'recipient' => ActionInvolvedPartyType::FINANCIER_AND_ACCREDITATOR,
            ],
            [
                'name' => 'RRC0024',
                'class_name' => 'App\\Actions\\RRC0024Action',
                'description' => 'Registradora NÚCLEA informa o retorno da comunicação de resilição ou liberação de excedente de garantia às Credenciadoras / Instituição Financeira / Não Financeira.',
                'type' => ActionType::MESSAGE,
                'sender' => ActionInvolvedPartyType::REGISTRAR,
                'recipient' => ActionInvolvedPartyType::FINANCIER_AND_ACCREDITATOR,
            ],
            [
                'name' => 'RRC0025',
                'class_name' => 'App\\Actions\\RRC0025Action',
                'description' => 'Instituição Financeira / Não Financeira realiza o retorno de negativa da comunicação de resilição ou liberação de excedente de garantia.',
                'type' => ActionType::MESSAGE,
                'sender' => ActionInvolvedPartyType::FINANCIER,
                'recipient' => ActionInvolvedPartyType::REGISTRAR,
            ],
            [
                'name' => 'RRC0026',
                'class_name' => 'App\\Actions\\RRC0026Action',
                'description' => 'Credenciador consulta existência de negociação para análise de precedência de contrato.',
                'type' => ActionType::MESSAGE,
                'sender' => ActionInvolvedPartyType::ACCREDITATOR,
                'recipient' => ActionInvolvedPartyType::REGISTRAR,
            ],
            [
                'name' => 'RRC0038',
                'class_name' => 'App\\Actions\\RRC0038Action',
                'description' => 'Credenciador consulta negociação de recebíveis na última posição válida do contrato.',
                'type' => ActionType::MESSAGE,
                'sender' => ActionInvolvedPartyType::ACCREDITATOR,
                'recipient' => ActionInvolvedPartyType::REGISTRAR,
            ],

            // -----------------------------------

            [
                'name' => 'ARRC017',
                'class_name' => 'App\\Actions\\ARRC017Action',
                'description' => 'Registradora NÚCLEA informa a lista de Participantes ativos.',
                'type' => ActionType::FILE,
                'sender' => ActionInvolvedPartyType::REGISTRAR,
                'recipient' => ActionInvolvedPartyType::ALL,
            ],
            [
                'name' => 'ARRC030',
                'class_name' => 'App\\Actions\\ARRC030Action',
                'description' => 'Credenciador informa a lista de credenciados ativos.',
                'type' => ActionType::FILE,
                'sender' => ActionInvolvedPartyType::ACCREDITATOR,
                'recipient' => ActionInvolvedPartyType::REGISTRAR,
            ],
            [
                'name' => 'ARRC032',
                'class_name' => 'App\\Actions\\ARRC032Action',
                'description' => 'Registradora NÚCLEA informa início e término do envio de arquivos.',
                'type' => ActionType::FILE,
                'sender' => ActionInvolvedPartyType::REGISTRAR,
                'recipient' => ActionInvolvedPartyType::ALL,
            ],
            [
                'name' => 'RRC0015',
                'class_name' => 'App\\Actions\\RRC0015Action',
                'description' => 'Registradora NÚCLEA informa a abertura da janela de negociações.',
                'type' => ActionType::MESSAGE,
                'sender' => ActionInvolvedPartyType::REGISTRAR,
                'recipient' => ActionInvolvedPartyType::ALL,
            ],
            [
                'name' => 'RRC0016',
                'class_name' => 'App\\Actions\\RRC0016Action',
                'description' => 'Registradora NÚCLEA informa o fechamento da janela de negociações.',
                'type' => ActionType::MESSAGE,
                'sender' => ActionInvolvedPartyType::REGISTRAR,
                'recipient' => ActionInvolvedPartyType::ALL,
            ],
            [
                'name' => 'CRRC040',
                'class_name' => 'App\\Actions\\CRRC040Action',
                'description' => 'Registradora NÚCLEA informa estabelecimentos comerciais vinculados ao credenciador para conciliação.',
                'type' => ActionType::FILE,
                'sender' => ActionInvolvedPartyType::REGISTRAR,
                'recipient' => ActionInvolvedPartyType::ACCREDITATOR,
            ],
            [
                'name' => 'CRRC041',
                'class_name' => 'App\\Actions\\CRRC041Action',
                'description' => 'Registradora NÚCLEA informa fechamento da conciliação.',
                'type' => ActionType::FILE,
                'sender' => ActionInvolvedPartyType::REGISTRAR,
                'recipient' => ActionInvolvedPartyType::ACCREDITATOR,
            ],

        ];

        foreach ($actions as $action) {
            Action::firstOrCreate(['name' => $action['name']], $action);
        }
    }
}
