<?php

namespace App\Services;

use App\Models\Account;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request; 
        
class AccountService
{
    /**
     * Filter resources based on the provided criteria.
     */
    public function filter(Request $request): Builder
    {
        $query = Account::query();

        return $query;
    }

    public function create(Request $request): Account
    {
        $account = Account::create($request->all());

        return $account;
    }

    public function update(Account $account, Request $request): Account
    {
        $account->update($request->all());

        return $account;
    }
}