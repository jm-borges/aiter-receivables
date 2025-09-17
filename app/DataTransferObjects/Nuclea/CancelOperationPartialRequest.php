<?php

namespace App\DataTransferObjects\Nuclea;

class CancelOperationPartialRequest extends CancelOperationRequest
{
    public string $cnpjOuCnpjBaseOuCpfTitlar;
    public array $unidadesRecebiveis = [];

    public function addUnidadeRecebivel(array $unidade): void
    {
        $this->unidadesRecebiveis[] = $unidade;
    }
}
