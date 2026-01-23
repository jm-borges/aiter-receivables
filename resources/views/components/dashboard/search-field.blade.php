<form method="GET" action="{{ url('/dashboard') }}" style="margin-top: 30px">
    <label>
        <p style="color: white; font-weight: 600; font-size: 14px">
            Buscar CNPJ
        </p>
        <div style="display: flex; justify-content: start">
            <div>
                <input type="text" name="cnpj" class="cnpj-input" value="{{ request('cnpj') }}"
                    placeholder="00.000.000/0000-00" maxlength="18"
                    style="width: 339px; border-radius: 5px; border-color: #211748">
            </div>
            <div style="margin-left: 4px">
                <button type="submit" style="background: transparent; border: none; padding: 0">
                    <img src="/assets/images/search_icon.png" alt="Buscar" style="cursor: pointer; width: 36px">
                </button>
            </div>
        </div>
    </label>
</form>
