<x-app-layout>
    <x-slot name="header">
        <x-common.page-header title="Conciliação de Operações"
            subtitle="Selecione uma empresa e visualize o status de recebíveis e inadimplência" />
    </x-slot>

    <x-receivables-query.partner-selector-container />

    <x-receivables-query.receivables-status-section :partners="$partners" />

    <x-receivables-query.payment-default-section :partners="$partners" />

    <div id="receivables-modal-overlay" class="modal-overlay" style="display: none;">
        <div class="modal-container">
            <div class="modal-header">
                <span id="receivables-modal-title">Agenda</span>
                <button id="receivables-modal-close" class="modal-close-btn">✕</button>
            </div>

            <div class="modal-body" id="receivables-modal-body">
                <x-receivables-query.calendar />
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const overlay = document.getElementById('receivables-modal-overlay');
            const closeBtn = document.getElementById('receivables-modal-close');
            const grid = document.getElementById('receivables-calendar-grid');
            const title = document.getElementById('receivables-calendar-title');

            const prevBtn = document.getElementById('calendar-prev-month');
            const nextBtn = document.getElementById('calendar-next-month');

            if (!overlay || !closeBtn || !grid || !title || !prevBtn || !nextBtn) return;

            let currentDate = new Date();
            let currentPartnerId = null;

            // cache com TODOS os dados vindos da API
            let fullDataMap = {};

            // ----------------------
            // Utils
            // ----------------------

            function formatMoney(value) {
                return value.toLocaleString('pt-BR', {
                    style: 'currency',
                    currency: 'BRL'
                });
            }

            function formatDateKey(year, month, day) {
                return `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
            }

            function getMonthName(month) {
                const monthNames = [
                    'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho',
                    'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
                ];
                return monthNames[month];
            }

            function getWeekdays() {
                return ['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'];
            }

            function getMonthMeta(year, month) {
                const firstDay = new Date(year, month, 1);
                const lastDay = new Date(year, month + 1, 0);

                return {
                    startWeekDay: (firstDay.getDay() + 6) % 7, // segunda = 0
                    totalDays: lastDay.getDate(),
                };
            }

            // ----------------------
            // DOM Builders
            // ----------------------

            function clearGrid() {
                grid.innerHTML = '';
            }

            function renderTitle(year, month) {
                title.textContent = `${getMonthName(month)} ${year}`;
            }

            function createWeekdayElement(label) {
                const el = document.createElement('div');
                el.className = 'calendar-weekday';
                el.textContent = label;
                return el;
            }

            function createEmptyDayElement() {
                const el = document.createElement('div');
                el.className = 'calendar-day empty';
                return el;
            }

            function createDayElement(day, info) {
                const el = document.createElement('div');
                el.className = 'calendar-day';

                el.innerHTML = `
            <div class="day-number">${String(day).padStart(2, '0')}</div>
            <div class="day-values">
                <div class="received">
                    <strong>${formatMoney(info.received)}</strong><br>
                    <span>Recebido</span>
                </div>
                <div class="to-receive">
                    <strong>${formatMoney(info.to_receive)}</strong><br>
                    <span>A receber</span>
                </div>
            </div>
        `;

                return el;
            }

            // ----------------------
            // Render parts
            // ----------------------

            function renderWeekdays() {
                getWeekdays().forEach(label => {
                    grid.appendChild(createWeekdayElement(label));
                });
            }

            function renderEmptyDays(count) {
                for (let i = 0; i < count; i++) {
                    grid.appendChild(createEmptyDayElement());
                }
            }

            function renderMonthDays(year, month) {
                const {
                    totalDays
                } = getMonthMeta(year, month);

                for (let day = 1; day <= totalDays; day++) {
                    const key = formatDateKey(year, month, day);

                    const info = fullDataMap[key] || {
                        received: 0,
                        to_receive: 0
                    };

                    grid.appendChild(createDayElement(day, info));
                }
            }

            // ----------------------
            // Main builder
            // ----------------------

            function buildCalendar() {
                const year = currentDate.getFullYear();
                const month = currentDate.getMonth();

                clearGrid();
                renderTitle(year, month);
                renderWeekdays();

                const {
                    startWeekDay
                } = getMonthMeta(year, month);
                renderEmptyDays(startWeekDay);

                renderMonthDays(year, month);
            }

            // ----------------------
            // Data
            // ----------------------

            function showLoading() {
                grid.innerHTML = '<div style="padding:20px;">Carregando agenda...</div>';
            }

            async function fetchSchedule(partnerId) {
                const res = await fetch(`/api/v1/business-partners/${partnerId}/receivables/schedule`);
                const json = await res.json();

                const map = {};
                json.schedule.forEach(row => {
                    map[row.date] = {
                        received: row.received,
                        to_receive: row.to_receive,
                    };
                });

                return map;
            }

            async function loadSchedule(partnerId) {
                showLoading();

                fullDataMap = await fetchSchedule(partnerId);

                // volta para o mês atual quando abre
                currentDate = new Date();

                buildCalendar();
            }

            // ----------------------
            // Navigation
            // ----------------------

            function changeMonth(delta) {
                currentDate.setMonth(currentDate.getMonth() + delta);
                buildCalendar();
            }

            prevBtn.addEventListener('click', () => changeMonth(-1));
            nextBtn.addEventListener('click', () => changeMonth(1));

            // ----------------------
            // Modal
            // ----------------------

            function openModal(partnerId) {
                overlay.style.display = 'flex';
                currentPartnerId = partnerId;
                return loadSchedule(partnerId);
            }

            function closeModal() {
                overlay.style.display = 'none';
            }

            document.addEventListener('click', async (e) => {
                const btn = e.target.closest('.open-receivables-modal');
                if (!btn) return;

                const partnerId = btn.dataset.partnerId;
                await openModal(partnerId);
            });

            closeBtn.addEventListener('click', closeModal);

            overlay.addEventListener('click', (e) => {
                if (e.target === overlay) closeModal();
            });
        });
    </script>

</x-app-layout>
