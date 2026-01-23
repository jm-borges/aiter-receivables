function formatCNPJ(value) {
    value = value.replace(/\D/g, '');
    value = value.substring(0, 14);

    value = value.replace(/^(\d{2})(\d)/, '$1.$2');
    value = value.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
    value = value.replace(/\.(\d{3})(\d)/, '.$1/$2');
    value = value.replace(/(\d{4})(\d)/, '$1-$2');

    return value;
}

document.addEventListener('DOMContentLoaded', function () {
    const inputs = document.querySelectorAll('.cnpj-input');

    inputs.forEach(function (input) {
        // ao digitar
        input.addEventListener('input', function () {
            this.value = formatCNPJ(this.value);
        });

        // se já vier preenchido
        if (input.value) {
            input.value = formatCNPJ(input.value);
        }
    });
});
