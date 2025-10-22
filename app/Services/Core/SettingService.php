<?php

namespace App\Services\Core;

use App\Models\Core\Setting;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SettingService
{
    /**
     * Filter resources based on the provided criteria.
     */
    public function filter(Request $request): Builder
    {
        $query = Setting::query();

        return $query;
    }

    public function create(Request $request): Setting
    {
        $setting = Setting::create($request->all());

        return $setting;
    }

    public function update(Setting $setting, Request $request): Setting
    {
        $setting->update($request->all());

        return $setting;
    }
}
