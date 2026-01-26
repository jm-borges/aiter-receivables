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

    day(day, info, config) {
        if (config.renderDay) {
            return config.renderDay(day, info);
        }

        // fallback genérico
        const el = document.createElement('div');
        el.className = 'bg-[#eceaec] min-h-[110px] p-2.5';
        el.textContent = day;
        return el;
    },

    loading() {
        const el = document.createElement('div');
        el.className = 'col-span-7 p-4 text-center text-sm text-gray-500';
        el.textContent = 'Carregando agenda...';
        return el;
    }
};
