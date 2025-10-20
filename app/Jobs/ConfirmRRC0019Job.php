<?php

namespace App\Jobs;

use App\Actions\RRC0019Action;
use App\DataTransferObjects\Nuclea\ConfirmOperationRequest;
use App\Models\Core\Operation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ConfirmRRC0019Job implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private Operation $operation,
        private ConfirmOperationRequest $confirmOperationRequestData,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        app(RRC0019Action::class)->confirmOperation(
            $this->operation,
            $this->confirmOperationRequestData,
        );
    }
}
