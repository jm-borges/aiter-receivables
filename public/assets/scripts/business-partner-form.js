document.addEventListener('DOMContentLoaded', () => {

    const toggle = document.getElementById('toggle_opt_in');
    const wrapper = document.getElementById('opt_in_dates');
    const inputs = wrapper.querySelectorAll('input');

    /**
     * Mostra ou oculta o container com base no estado do toggle
     */
    function toggleWrapper(show) {
        if (show) {
            wrapper.classList.remove('hidden');
        } else {
            wrapper.classList.add('hidden');
        }
    }

    /**
     * Habilita ou desabilita os inputs dentro do container
     */
    function setInputsState(enabled) {
        inputs.forEach(input => input.disabled = !enabled);
    }

    /**
     * Atualiza o estado do formulário com base no toggle
     */
    function updateState() {
        const checked = toggle.checked;
        toggleWrapper(checked);
        setInputsState(checked);
    }

    // Eventos
    toggle.addEventListener('change', updateState);

    // Inicializa
    updateState();

});