<?php

namespace App\Http\Controllers\Web;

use App\Enums\BusinessPartnerType;
use App\Http\Controllers\Controller;
use App\Models\Core\BusinessPartner;
use App\Models\Core\Receivable;
use App\Services\Core\ReceivableService;

class ReceivableController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $receivables = Receivable::with(['client', 'acquirer', 'paymentArrangement', 'contracts', 'optIn'])
            ->latest()
            ->paginate(15);

        return view('receivables.index', compact('receivables'));
    }

    public function show(string $id)
    {
        $receivable = Receivable::with(['client', 'acquirer', 'paymentArrangement', 'contracts', 'optIn'])
            ->findOrFail($id);

        return view('receivables.show', compact('receivable'));
    }

    public function queryIndex(ReceivableService $receivableService)
    {
        $partners = $this->getPartners();
        $partners = $this->enrichPartnerSummaries($partners, $receivableService);

        return view('receivables.query-index', [
            'partners' => $partners
        ]);
    }

    private function getPartners()
    {
        if ($this->user->isSuperAdmin()) {
            return BusinessPartner::paginate(20);
        }

        return $this->user
            ->businessPartners()
            ->where('type', BusinessPartnerType::CLIENT)
            ->paginate(20);
    }

    private function enrichPartnerSummaries($partners, ReceivableService $receivableService)
    {
        return $partners->getCollection()->transform(function ($partner) use ($receivableService) {
            $receivablesSummary = $receivableService->calculateReceivablesSummary($partner->id);

            $partner->receivables_summary = [
                ...$receivablesSummary,
                'total_operation' => ($receivablesSummary['locked_by_user'] ?? 0) + ($receivablesSummary['to_be_received'] ?? 0),
            ];

            $partner->defaults_summary = [
                'amount_due' => 0,
                'amount_to_be_recovered' => 0,
                'amount_recovered' => 0,
            ];

            return $partner;
        });
    }
}
