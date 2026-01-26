import { createCalendar } from "../calendar/index.js";

export function createReceivablesCalendar() {
    return createCalendar({
        id: 'receivables',

        context: {
            partnerId: null
        },

        async loadData({ context }) {
            if (!context.partnerId) return [];

            const res = await fetch(`/api/v1/business-partners/${context.partnerId}/receivables/schedule`);
            const json = await res.json();

            return json.schedule;
        },

        mapDayData(row) {
            return {
                received: row.received,
                to_receive: row.to_receive,
            };
        },

        emptyDayData: {
            received: 0,
            to_receive: 0,
        },

        renderDay(day, info) {
            const el = document.createElement('div');
            el.className = 'bg-[#eceaec] min-h-[110px] p-2.5 flex flex-col justify-between';

            el.innerHTML = `
                <div class="text-xl font-bold text-[#1e144f]">
                    ${String(day).padStart(2, '0')}
                </div>

                <div class="flex flex-col gap-1.5 text-xs">
                    <div>
                        <strong class="text-[13px] text-[#0a7a2f]">
                            ${info.received.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })}
                        </strong><br>
                        <span class="text-[#0a7a2f]">Recebido</span>
                    </div>

                    <div>
                        <strong class="text-[13px] text-[#c40000]">
                            ${info.to_receive.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })}
                        </strong><br>
                        <span class="text-[#c40000]">A receber</span>
                    </div>
                </div>
            `;

            return el;
        }
    });
}
