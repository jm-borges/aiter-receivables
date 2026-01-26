import { domFactory } from './domFactory.js';
import { utils } from './utils.js';

export function createRenderer(state, config) {
    const baseId = config.id;

    const dom = {
        root: document.getElementById(`${baseId}-calendar-root`),
        title: document.getElementById(`${baseId}-calendar-title`),
        grid: document.getElementById(`${baseId}-calendar-grid`),
        loading: document.getElementById(`${baseId}-calendar-loading`),
    };

    return {
        clear() {
            dom.grid.innerHTML = '';
        },

        showLoading() {
            if (dom.loading) {
                dom.loading.classList.remove('hidden');
            }
        },

        hideLoading() {
            if (dom.loading) {
                dom.loading.classList.add('hidden');
            }
        },

        renderTitle() {
            const y = state.currentDate.getFullYear();
            const m = state.currentDate.getMonth();
            dom.title.textContent = `${utils.getMonthName(m)} ${y}`;
        },

        build() {
            const y = state.currentDate.getFullYear();
            const m = state.currentDate.getMonth();

            const { startWeekDay, totalDays } = utils.getMonthMeta(y, m);

            this.clear();
            this.renderTitle();

            utils.getWeekdays().forEach(label => {
                dom.grid.appendChild(domFactory.weekday(label));
            });

            for (let i = 0; i < startWeekDay; i++) {
                dom.grid.appendChild(domFactory.emptyDay());
            }

            for (let day = 1; day <= totalDays; day++) {
                const key = utils.formatDateKey(y, m, day);

                const info = state.dataMap[key] || config.emptyDayData || {};

                dom.grid.appendChild(
                    domFactory.day(day, info, config)
                );
            }
        }
    };
}
