document.addEventListener('DOMContentLoaded', () => {
    // Toggle menu
    document.querySelectorAll('[id^="options-btn-"]').forEach(btn => {
        const partnerId = btn.id.replace('options-btn-', '');
        const menu = document.getElementById(`options-menu-${partnerId}`);
        if (!menu) return;

        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            menu.classList.toggle('hidden');
        });
    });

    // Fechar ao clicar fora
    document.addEventListener('click', () => {
        document.querySelectorAll('[id^="options-menu-"]').forEach(menu => {
            menu.classList.add('hidden');
        });
    });

    // Evitar fechar ao clicar dentro do menu
    document.querySelectorAll('[id^="options-menu-"]').forEach(menu => {
        menu.addEventListener('click', (e) => e.stopPropagation());
    });
});