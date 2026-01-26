import { state } from './state.js';

export function createDataLoader(renderer) {
    return {
        async fetchSchedule(partnerId) {
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
        },

        async load(partnerId) {
            renderer.showLoading();

            state.fullDataMap = await this.fetchSchedule(partnerId);
            state.currentDate = new Date();

            renderer.build();
        }
    };
}
