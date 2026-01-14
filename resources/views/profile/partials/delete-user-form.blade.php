<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 ">
            {{ __('common.delete_account') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('common.delete_account_warning') }}
        </p>
    </header>

    <x-common.danger-button x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">{{ __('common.delete_account') }}</x-common.danger-button>

    <x-common.modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900 ">
                {{ __('common.confirm_delete_account') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 ">
                {{ __('common.confirm_delete_account_desc') }}
            </p>

            <div class="mt-6">
                <x-common.input-label for="password" :value="__('common.password')" class="sr-only" />

                <x-common.text-input id="password" name="password" type="password" class="mt-1 block w-3/4"
                    placeholder="{{ __('common.password') }}" />

                <x-common.input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-common.secondary-button x-on:click="$dispatch('close')">
                    {{ __('common.cancel') }}
                </x-common.secondary-button>

                <x-common.danger-button class="ms-3">
                    {{ __('common.delete_account') }}
                </x-common.danger-button>
            </div>
        </form>
    </x-common.modal>
</section>
