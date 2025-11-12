<?php

namespace App\Http\Controllers\Web;

use App\Enums\BusinessPartnerType;
use App\Http\Controllers\Controller;
use App\Models\Core\BusinessPartner;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class UserController extends Controller
{
    public function index(): Factory|View
    {
        $users = User::paginate(20);

        return view('users.index', ['users' => $users]);
    }

    public function create(): Factory|View
    {
        $suppliers = BusinessPartner::where('type', BusinessPartnerType::SUPPLIER)->get();

        return view('users.form', ['suppliers' => $suppliers]);
    }

    public function store(Request $request): Redirector | RedirectResponse
    {
        $user = User::create($request->all());

        $user->businessPartners()->attach($request->supplier_id);

        return redirect('/users')->with('success', 'Salvo com sucesso');
    }

    public function show(User $user): Factory|View
    {
        return view('users.show', ['user' => $user]);
    }

    public function edit(User $user): Factory|View
    {
        $suppliers = BusinessPartner::where('type', BusinessPartnerType::SUPPLIER)->get();
        $user->supplier_id = $user->supplier()?->id;

        return view('users.form', ['user' => $user, 'suppliers' => $suppliers]);
    }

    public function update(Request $request, User $user): Redirector | RedirectResponse
    {
        $data = $request->all();

        $data['is_super_admin'] = $request->has('is_super_admin');

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $user->update($data);

        if ($request->filled('supplier_id')) {
            $user->businessPartners()->sync([$request->supplier_id]);
        } else {
            $user->businessPartners()->detach();
        }

        return redirect('/users')->with('success', 'Salvo com sucesso');
    }


    public function destroy(User $user): Redirector | RedirectResponse
    {
        $user->delete();

        return redirect('/users')->with('success', 'Removido com sucesso');
    }
}
