<x-app-layout>
    <x-slot name="header">
        <x-common.page-header title="Análise de Crédito" />
    </x-slot>

    <div style="width: 513px; background-color: white; border-radius: 5px;padding: 15px; margin-bottom:15px">
        <div style="color:#211748; font-size: 20px; font-weight: 600">
            Identificação
        </div>
        <div style="color:#211748; font-size: 14px; font-weight: 400">
            Informe o CNPJ
        </div>
        <div style="color:#211748;font-size: 14px; font-weight: 600 ;margin-top: 10px">
            CNPJ
        </div>
        <div>
            <input type="text" id="credit-analysis-cnpj-input" name="document_number" required
                placeholder="00.000.000/0000-00" style="width: 90%;border: 1px solid #211748; border-radius: 5px; ">
            <button id="credit-analysis-fetch-cnpj" type="button" title="Buscar informações"
                style="border: none; background-color: #211748; color: white; border-radius: 5px; padding: 5px 8px; cursor: pointer;">
                <img src="/assets/images/search.png" width="24px">
            </button>
        </div>
        <div id="cnpj-result">
        </div>
    </div>

    <div id="credit-analysis-data-container" class="hidden">
        <x-credit-analysis.value-field-container />

        <x-credit-analysis.warranty-availability-section />

        <x-credit-analysis.bank-debts-section />
    </div>


</x-app-layout>
