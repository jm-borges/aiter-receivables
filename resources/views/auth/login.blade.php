@extends('layouts.login')

@section('content')
    <div class="min-h-screen w-full grid grid-cols-1 md:grid-cols-[30%_70%]">

        {{-- COLUNA ESQUERDA – FORM --}}
        <div class="flex items-center justify-center p-8" style="background-color: #E5E1E7;">

            <div class="w-full max-w-sm">

                <div class="inset-0 flex items-center justify-center">
                    <img src="/assets/images/logo_nova.png" alt="Logo" class="w-64 mb-16">
                </div>

                <!-- Session Status -->
                <x-common.auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-common.input-label for="email" :value="__('common.email')" />
                        <x-common.text-input id="email" class="block mt-1 w-full" type="email" name="email"
                            :value="old('email')" required autofocus autocomplete="username" />
                        <x-common.input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-common.input-label for="password" :value="__('common.password')" />
                        <x-common.text-input id="password" class="block mt-1 w-full" type="password" name="password"
                            required autocomplete="current-password" />
                        <x-common.input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me + Forgot Password -->
                    <div class="flex items-center justify-between mt-4">

                        {{-- Remember me --}}
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox"
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                name="remember">
                            <span class="ms-2 text-sm text-gray-600">
                                {{ __('common.remember_me') }}
                            </span>
                        </label>

                        {{-- Forgot Password --}}
                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 hover:text-gray-900"
                                href="{{ route('password.request') }}">
                                {{ __('common.forgot_password') }}
                            </a>
                        @endif

                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-common.primary-button class="ms-3">
                            {{ __('common.login') }}
                        </x-common.primary-button>
                    </div>
                </form>

            </div>
        </div>

        {{-- COLUNA DIREITA – BACKGROUND + LOGO --}}
        <div class="relative hidden md:block">
            <div class="absolute inset-0 bg-cover bg-center"
                style="background-image: url('/assets/images/background.png');">
            </div>

            <div class="absolute inset-0 flex items-center justify-center">
                <img src="/assets/images/symbol.png" alt="Logo" class="w-full max-w-2xl h-auto opacity-90">
            </div>
        </div>

    </div>
@endsection
