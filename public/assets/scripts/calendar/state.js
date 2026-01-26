export function createState(config) {
    return {
        currentDate: new Date(),
        dataMap: {},
        context: config.context || {},

        setContext(ctx) {
            this.context = ctx;
        },

        clear() {
            this.dataMap = {};
            this.context = null;
        },

        async load() {
            if (!this.context) {
                this.dataMap = {};
                return;
            }

            const y = this.currentDate.getFullYear();
            const m = this.currentDate.getMonth();

            this.dataMap = {};

            const rawData = await config.loadData({
                year: y,
                month: m,
                context: this.context
            });

            const map = {};

            rawData.forEach(item => {
                const dayKey = item.date; // formato ISO esperado
                map[dayKey] = config.mapDayData(item);
            });

            this.dataMap = map;
        }
    };
}
