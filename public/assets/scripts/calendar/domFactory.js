import { utils } from './utils.js';

export const domFactory = {
    weekday(label) {
        const el = document.createElement('div');
        el.className = 'bg-[#24155f] text-white p-2.5 font-semibold text-center text-sm';
        el.textContent = label;
        return el;
    },

    emptyDay() {
        const el = document.createElement('div');
        el.className = 'bg-[#f2f2f2] text-[#aaa] min-h-[110px] p-2.5';
        return el;
    },

    day(day, info) {
        const el = document.createElement('div');
        el.className = 'bg-[#eceaec] min-h-[110px] p-2.5 flex flex-col justify-between';

        el.innerHTML = `
            <div class="text-xl font-bold text-[#1e144f]">
                ${String(day).padStart(2, '0')}
            </div>

            <div class="flex flex-col gap-1.5 text-xs">
                <div>
                    <strong class="text-[13px] text-[#0a7a2f]">
                        ${utils.formatMoney(info.received)}
                    </strong><br>
                    <span class="text-[#0a7a2f]">Recebido</span>
                </div>

                <div>
                    <strong class="text-[13px] text-[#c40000]">
                        ${utils.formatMoney(info.to_receive)}
                    </strong><br>
                    <span class="text-[#c40000]">A receber</span>
                </div>
            </div>
        `;

        return el;
    },

    loading() {
        const el = document.createElement('div');
        el.className = 'col-span-7 p-4 text-center text-sm text-gray-500';
        el.textContent = 'Carregando agenda...';
        return el;
    }
};
