import { createCalendar } from "../calendar/index.js";

export function createCardsRevenueCalendar() {
    return createCalendar({
        id: 'cards-revenue',

        context: {
            partnerId: null
        },

        async loadData({ context }) {
            if (!context.partnerId) return [];

            const res = await fetch(`/api/v1/business-partners/${context.partnerId}/cards-revenue/schedule`);
            const json = await res.json();

            return json.schedule;
        },

        mapDayData(row) {
            return {
                creditCard: row.credit_card || 0,
                debitCard: row.debit_card || 0,
            };
        },

        emptyDayData: {
            creditCard: 0,
            debitCard: 0,
        },

        renderDay(day, info) {
            const el = document.createElement('div');
            el.className = 'bg-[#eceaec] min-h-[110px] p-2.5 flex flex-col justify-between';

            el.innerHTML = `
                <div class="text-xl font-bold text-[#211748]">
                    ${String(day).padStart(2, '0')}
                </div>

                <div class="flex flex-col gap-1.5 text-xs">
                    <div>
                        <strong class="text-[13px] text-[#211748]">
                            ${info.creditCard.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })}
                        </strong><br>
                        <span class="text-[#211748]">Cartão de Crédito</span>
                    </div>

                    <div>
                        <strong class="text-[13px] text-[#211748]">
                            ${info.debitCard.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })}
                        </strong><br>
                        <span class="text-[#211748]">Cartão de Débito</span>
                    </div>
                </div>
            `;

            return el;
        }
    });
}
