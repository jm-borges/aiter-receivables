<?php

namespace App\Auxiliary;

use App\Models\Core\Contract;

class UpdatedContractInfo
{
    public function __construct(
        public Contract $contract,
        public bool $hasAchievedGoal,
        public bool $thereWerePreviousOperations,
    ) {}
}
