<?php

namespace App\Http\Controllers;

use App\Models\BusinessPartner;
use App\Enums\BusinessPartnerType;
use Illuminate\Http\Request;

class BusinessPartnerController extends Controller
{
    public function index()
    {
        $partners = BusinessPartner::paginate(20);

        return view('business-partners.index', compact('partners'));
    }

    public function create()
    {
        $types = BusinessPartnerType::cases();
        return view('business-partners.form', [
            'partner' => new BusinessPartner(),
            'types'   => $types,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        $partner = BusinessPartner::create($data);

        return redirect()
            ->route('business-partners.index')
            ->with('success', "Parceiro {$partner->name} criado com sucesso.");
    }

    public function show(BusinessPartner $businessPartner)
    {
        return view('business-partners.show', compact('businessPartner'));
    }

    public function edit(BusinessPartner $businessPartner)
    {
        $types = BusinessPartnerType::cases();

        return view('business-partners.form', [
            'partner' => $businessPartner,
            'types'   => $types,
        ]);
    }

    public function update(Request $request, BusinessPartner $businessPartner)
    {
        $data = $this->validateData($request);

        $businessPartner->update($data);

        return redirect()
            ->route('business-partners.index')
            ->with('success', "Parceiro {$businessPartner->name} atualizado com sucesso.");
    }

    public function destroy(BusinessPartner $businessPartner)
    {
        $businessPartner->delete();

        return redirect()
            ->route('business-partners.index')
            ->with('success', "Parceiro removido com sucesso.");
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'name'                => ['required', 'string', 'max:255'],
            'fantasy_name'        => ['nullable', 'string', 'max:255'],
            'description'         => ['nullable', 'string'],
            'type'                => ['required', 'in:client,supplier,acquirer'],
            'document_number'     => ['required', 'string', 'max:50'],
            'state_subscription'  => ['nullable', 'string', 'max:50'],
            'city_subscription'   => ['nullable', 'string', 'max:50'],
            'email'               => ['nullable', 'email', 'max:255'],
            'phone'               => ['nullable', 'string', 'max:50'],
            'postal_code'         => ['nullable', 'string', 'max:20'],
            'address'             => ['nullable', 'string', 'max:255'],
            'address_number'      => ['nullable', 'string', 'max:50'],
            'address_complement'  => ['nullable', 'string', 'max:100'],
            'address_neighborhood' => ['nullable', 'string', 'max:100'],
            'address_city'        => ['nullable', 'string', 'max:100'],
            'address_city_code'   => ['nullable', 'string', 'max:20'],
            'address_state'       => ['nullable', 'string', 'max:100'],
            'address_state_code'  => ['nullable', 'string', 'max:20'],
        ]);
    }
}
