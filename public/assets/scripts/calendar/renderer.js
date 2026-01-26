import { utils } from './utils.js';
import { domFactory } from './domFactory.js';
import { state } from './state.js';

export function createRenderer(dom) {

    return {
        clear() {
            dom.grid.innerHTML = '';
        },

        renderTitle() {
            const y = state.currentDate.getFullYear();
            const m = state.currentDate.getMonth();
            dom.title.textContent = `${utils.getMonthName(m)} ${y}`;
        },

        renderWeekdays() {
            utils.getWeekdays().forEach(label => {
                dom.grid.appendChild(domFactory.weekday(label));
            });
        },

        renderEmptyDays(count) {
            for (let i = 0; i < count; i++) {
                dom.grid.appendChild(domFactory.emptyDay());
            }
        },

        renderMonthDays() {
            const y = state.currentDate.getFullYear();
            const m = state.currentDate.getMonth();

            const { totalDays } = utils.getMonthMeta(y, m);

            for (let day = 1; day <= totalDays; day++) {
                const key = utils.formatDateKey(y, m, day);

                const info = state.fullDataMap[key] || {
                    received: 0,
                    to_receive: 0
                };

                dom.grid.appendChild(domFactory.day(day, info));
            }
        },

        build() {
            const y = state.currentDate.getFullYear();
            const m = state.currentDate.getMonth();

            const { startWeekDay } = utils.getMonthMeta(y, m);

            this.clear();
            this.renderTitle();
            this.renderWeekdays();
            this.renderEmptyDays(startWeekDay);
            this.renderMonthDays();
        },

        showLoading() {
            this.clear();
            dom.grid.appendChild(domFactory.loading());
        }
    };
}
