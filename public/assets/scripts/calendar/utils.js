export const utils = {
    formatDateKey(year, month, day) {
        return `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
    },

    getMonthName(month) {
        return [
            'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho',
            'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
        ][month];
    },

    getWeekdays() {
        return ['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'];
    },

    getMonthMeta(year, month) {
        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);

        return {
            startWeekDay: (firstDay.getDay() + 6) % 7,
            totalDays: lastDay.getDate(),
        };
    }
};
