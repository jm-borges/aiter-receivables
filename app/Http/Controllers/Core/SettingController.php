<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\GetSettingsRequest;
use App\Http\Requests\Settings\StoreSettingRequest;
use App\Http\Requests\Settings\UpdateSettingRequest;
use App\Http\Resources\SettingResource;
use App\Models\Core\Setting;
use App\Services\Core\SettingService;
use Illuminate\Http\JsonResponse;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetSettingsRequest $request, SettingService $settingService): JsonResponse
    {
        $query = $settingService->filter($request);

        $settings = $query->get();

        return response()->json(['data' => SettingResource::collection($settings)]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSettingRequest $request, SettingService $settingService): JsonResponse
    {
        $setting = $settingService->create($request);

        return response()->json(['data' => SettingResource::make($setting), 'message' => 'Cadastrado com sucesso'], JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Setting $setting): JsonResponse
    {
        return response()->json(SettingResource::make($setting));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSettingRequest $request, Setting $setting, SettingService $settingService): JsonResponse
    {
        $setting = $settingService->update($setting, $request);

        return response()->json(['data' => SettingResource::make($setting), 'message' => 'Atualizado com sucesso']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting): JsonResponse
    {
        $setting->delete();

        return response()->json(['message' => 'Deletado com sucesso']);
    }
}
