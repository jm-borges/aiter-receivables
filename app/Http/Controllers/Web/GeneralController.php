<?php

namespace App\Http\Controllers\Web;

use App\Actions\RRC0011Action;
use App\Http\Controllers\Controller;
use App\Models\Core\BusinessPartner;
use App\Models\Operation;
use App\Models\Core\OptIn;
use App\Models\Core\PaymentArrangement;
use App\Models\Core\Receivable;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GeneralController extends Controller
{
    //1 - Altri fecha contrato com EC e Fornecedor do EC, no valor X. Altri paga a dívida do EC com fornecedor, e o EC passa a dever o valor X para a altri, que vai ser paga com as garantias ou liquidando o valor até a data limite
    //2 - Uma vez fechado o contrato, Altri solicita Opt-in da agenda de recebiveis para todos os adquires e arranjos de pagamento combinados no contrato
    //3 - todo dia, os recebiveis que aparecem via atualização da agenda de recebiveis daquele EC, são "marcados" pelo sistema
    //4 - com os recebiveis marcados, é feita operação XXXX, que coloca aqueles recebíveis como garantia para Altri
    //5 - isso ocorre até que o valor X do contrato seja atingido
    //6 - dúvida: como ocorre a liquidação disso? no caso, os recebíveis que estavam como garantia, quando pagos, automaticamente vão para a conta da Altri? como funcionaria isso?

    public function index()
    {
        $optIns = OptIn::get();
        $receivables = Receivable::get();

        //A QUESTÃO DA PAGINAÇÃO NA RRC0010

        //NA RRC0010, QUEM É O TITULAR?

        //O que é o valor total e o valor livre usuario final de um recebível?
        // O que impede a Altri de especificar que um determinado valor de recebível deve ficar como garantia para ela?

        //Falta organizar para guardar no banco também as infos de titulares/domicilios dos recebiveis ao buscar a RRC0010

        //Scheduler busca toda vez que abrir a grade de negociação (é o ideal? ou o que seria melhor?)
        //Quem são os "titulares" ?
        //Uma unidade recebível nunca tem uma ID ou um identificador único? 

        return view('index', ['optIns' => $optIns, 'receivables' => $receivables]);
    }

    public function optIn(Request $request)
    {
        $action = app(RRC0011Action::class);

        $optIn = OptIn::create([
            // ARRANJO DE PAGAMENTO
            'codInstitdrArrajPgto' => $request->codInstitdrArrajPgto,
            'payment_arrangement_id' => PaymentArrangement::findByCode($request->codInstitdrArrajPgto)?->id,
            // ADQUIRENTE
            'cnpjCreddrSub' => $request->cnpjCreddrSub,
            'acquirer_id' => BusinessPartner::findByDocumentNumber($request->cnpjCreddrSub)?->id,
            // CLIENT
            'cnpjOuCnpjBaseOuCpfUsuFinalRecbdrOuTitlar' => $request->cnpjOuCnpjBaseOuCpfUsuFinalRecbdrOuTitlar, // ESTABELECIMENTO COMERCIAL
            'client_id' => BusinessPartner::findByDocumentNumber($request->cnpjOuCnpjBaseOuCpfUsuFinalRecbdrOuTitlar)?->id,
            //
            'status' => 'pending',
            'unique_identifier' => (string) Str::uuid(), //IDENTIFICADOR ÚNICO? UUID? NUMÉRICO?
            'cnpj_financiadora' => '52399494000122', //CNPJ ALTRI? COMPLETO OU BASE?
            //
            'indrDomcl' => $request->indrDomcl, // ???
            'dtOptIn' => $request->dtOptIn, // HOJE/AGORA?
            'dtIniOptIn' =>  $request->dtIniOptIn, // HOJE/AGORA?
            'dtFimOptIn' =>  $request->dtFimOptIn, // QUAL O MELHOR MOMENTO? TEM MÁXIMO?
        ]);

        $response = $action->execute(
            identdCtrlReqSolicte: $optIn->unique_identifier,
            cnpjFincdr: $optIn->cnpj_financiadora,
            //
            cnpjOuCnpjBaseOuCpfUsuFinalRecbdrOuTitlar: $optIn->cnpjOuCnpjBaseOuCpfUsuFinalRecbdrOuTitlar,
            cnpjCreddrSub: $optIn->cnpjCreddrSub,
            codInstitdrArrajPgto: $optIn->codInstitdrArrajPgto,
            indrDomcl: $optIn->indrDomcl,
            dtOptIn: $optIn->dtOptIn,
            dtIniOptIn: $optIn->dtIniOptIn,
            dtFimOptIn: $optIn->dtFimOptIn,
        );

        if ($response['status_code'] === 200) {
            $optIn->update([
                'identdCtrlOptIn' => $response['body']['identdCtrlOptIn'],
                'status' => 'successful',
            ]);
        }

        redirect('/');
    }

    public function optOut(Request $request, OptIn $optIn)
    {
        //
    }
}
