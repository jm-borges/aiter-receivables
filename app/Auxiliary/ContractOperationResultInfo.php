<?php

namespace App\Auxiliary;

use App\Models\Core\Contract;
use App\Models\Core\Operation;

class ContractOperationResultInfo
{

    public function __construct(
        public Contract $contract,
        public Operation $operation,
        public bool $hasError,
    ) {}
}
