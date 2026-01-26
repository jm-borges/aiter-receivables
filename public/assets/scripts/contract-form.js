document.addEventListener('DOMContentLoaded', function () {
    const radios = document.querySelectorAll('input[name="is_automatic"]');
    const valueField = document.getElementById('value-field');
    const valueInput = document.getElementById('value');
    const negotiationField = document.querySelector('input[name="negotiation_type"]').closest('div');

    function toggleFields() {
        const selected = document.querySelector('input[name="is_automatic"]:checked');
        const isManual = selected && selected.value === '0';

        if (isManual) {
            valueField.classList.add('hidden');
            negotiationField.classList.add('hidden');
            valueInput.removeAttribute('required');
            valueInput.value = '';
        } else {
            valueField.classList.remove('hidden');
            negotiationField.classList.remove('hidden');
            valueInput.setAttribute('required', 'required');
        }
    }

    toggleFields();

    radios.forEach(radio => {
        radio.addEventListener('change', toggleFields);
    });
});