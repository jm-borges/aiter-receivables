<?php

namespace App\Http\Controllers\Web;

use App\Enums\BusinessPartnerType;
use App\Http\Controllers\Controller;
use App\Models\Core\BusinessPartner;
use App\Services\ClientMonitoringService;
use App\Services\Core\ReceivableService;

class DashboardController extends Controller
{
    public function index(ReceivableService $receivableService, ClientMonitoringService $clientMonitoringService)
    {
        $cnpj = request('cnpj') ? removeSpecialCharacters(request('cnpj')) : null;

        if ($this->user->isSuperAdmin()) {
            $partners = BusinessPartner::query();
        } else {
            $partners = $this->user->businessPartners()
                ->where('type', BusinessPartnerType::CLIENT);
        }

        if (!empty($cnpj)) {
            $partners->where('document_number', 'like', "%{$cnpj}%");
        }

        $partners = $partners->paginate(20);

        $partners = $this->enrichPartnerSummaries($partners, $receivableService, $clientMonitoringService);

        return view('dashboard', ['partners' => $partners]);
    }

    private function enrichPartnerSummaries($partners, ReceivableService $receivableService, ClientMonitoringService $clientMonitoringService)
    {
        return $partners->getCollection()->transform(function ($partner) use ($receivableService, $clientMonitoringService) {
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

            $partner->monitoring = $clientMonitoringService->buildForClient($partner);

            return $partner;
        });
    }
}
