<x-app-layout>
    <x-slot name="header">
        <x-page-header title="Configurações" />
    </x-slot>

    <div class="py-6">
        <form method="POST" action="{{ route('settings.update') }}">
            @csrf

            <div class="flex items-center space-x-2">
                <input type="checkbox" id="auto_operate_mode_is_enabled" name="auto_operate_mode_is_enabled" value="1"
                    {{ old('auto_operate_mode_is_enabled', $settings->auto_operate_mode_is_enabled ?? false) ? 'checked' : '' }}>
                <label for="auto_operate_mode_is_enabled">O sistema deve operar automaticamente nos contratos</label>
            </div>

            <div class="mt-4">
                <x-primary-button>Salvar</x-primary-button>
            </div>
        </form>

        @if (session('status'))
            <div class="mt-4 text-green-600">
                {{ session('status') }}
            </div>
        @endif
    </div>
</x-app-layout>
