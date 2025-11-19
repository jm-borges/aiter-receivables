<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\Core\SettingService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class SettingController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(SettingService $settingService)
    {
        $viewData = $settingService->getIndexViewData();
        return view('settings.index', $viewData);
    }

    public function update(Request $request, SettingService $settingService): RedirectResponse
    {
        $validated = $request->validate([
            'auto_operate_mode_is_enabled' => 'boolean',
        ]);

        $settingService->updateOrCreate($validated);

        return redirect()
            ->route('settings.index')
            ->with('status', 'Configurações atualizadas com sucesso!');
    }
}
