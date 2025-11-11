export const debounce = (fn, delay) => {
    let timeout;
    return (...args) => {
        clearTimeout(timeout);
        timeout = setTimeout(() => fn(...args), delay);
    };
};

export const formatCurrency = (value) => {
    if (typeof value !== 'number') return 'R$ -';
    return `R$ ${value.toLocaleString('pt-BR', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    })}`;
};