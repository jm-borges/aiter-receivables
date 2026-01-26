<form method="GET" action="{{ url('/dashboard') }}" class="mt-8">
    <label class="block">
        <p class="text-white font-semibold text-sm mb-2">
            Buscar CNPJ
        </p>
        <div class="flex justify-start items-center">
            <div>
                <input type="text" name="cnpj" class="cnpj-input w-[339px] rounded border border-[#211748] px-2 py-1"
                    value="{{ request('cnpj') }}" placeholder="00.000.000/0000-00" maxlength="18">
            </div>
            <div class="ml-1">
                <button type="submit" class="bg-transparent border-none p-0">
                    <img src="/assets/images/search_icon.png" alt="Buscar" class="cursor-pointer w-9">
                </button>
            </div>
        </div>
    </label>
</form>
