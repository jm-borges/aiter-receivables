<?php

namespace App\Http\Controllers\Web;

use App\Enums\BusinessPartnerType;
use App\Http\Controllers\Controller;
use App\Models\Core\BusinessPartner;

class DashboardController extends Controller
{
    public function index()
    {
        if (request('cnpj')) {
            $cnpj = removeSpecialCharacters(request('cnpj'));
        } else {
            $cnpj = null;
        }

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

        return view('dashboard', ['partners' => $partners]);
    }
}
