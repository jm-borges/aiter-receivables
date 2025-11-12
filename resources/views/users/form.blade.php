<x-app-layout>
    <x-slot name="header">
        <x-page-header :title="isset($user) ? 'Editar usuário' : 'Cadastrar usuário'" />
    </x-slot>

    {{-- Errors --}}
    @if ($errors->any())
        <div class="mb-6 rounded-md bg-red-50 p-4">
            <h2 class="text-sm font-semibold text-red-800 mb-2">Ocorreram erros:</h2>
            <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <form method="POST" action="{{ isset($user) ? route('users.update', $user) : route('users.store') }}">
                    @csrf
                    @if (isset($user))
                        @method('PUT')
                    @endif

                    {{-- Nome --}}
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name ?? '') }}"
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('name')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email"
                            value="{{ old('email', $user->email ?? '') }}" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('email')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Senha --}}
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            Senha {{ isset($user) ? '(deixe em branco para manter)' : '' }}
                        </label>
                        <input type="password" name="password" id="password" {{ isset($user) ? '' : 'required' }}
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('password')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Telefone --}}
                    <div class="mb-4">
                        <label for="phone" class="block text-sm font-medium text-gray-700">Telefone</label>
                        <input type="text" name="phone" id="phone"
                            value="{{ old('phone', $user->phone ?? '') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('phone')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Fornecedor --}}
                    <div class="mb-4">
                        <label for="supplier_id" class="block text-sm font-medium text-gray-700">Fornecedor</label>
                        <select name="supplier_id" id="supplier_id"
                            class="mt-1 block w-full rounded-md border-gray-300 bg-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">Nenhum fornecedor</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" @selected(old('supplier_id', $user->supplier_id ?? '') == $supplier->id)>
                                    {{ $supplier->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('supplier_id')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Super Admin --}}
                    <div class="mb-4 flex items-center">
                        <input id="is_super_admin" name="is_super_admin" type="checkbox" value="1"
                            class="h-4 w-4 text-indigo-600 border-gray-300 rounded"
                            {{ old('is_super_admin', $user->is_super_admin ?? false) ? 'checked' : '' }}>
                        <label for="is_super_admin" class="ml-2 block text-sm text-gray-700">
                            Usuário é Super Admin
                        </label>
                    </div>

                    {{-- Botões --}}
                    <div class="mt-6 flex justify-end space-x-3">
                        <a href="{{ route('users.index') }}"
                            class="inline-flex justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                            Salvar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
