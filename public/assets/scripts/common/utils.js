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

export const formatCnpj = (cnpj) => {
    if (!cnpj) return '';

    const digits = String(cnpj).replace(/\D/g, '');

    if (digits.length !== 14) return cnpj; // fallback seguro

    return digits.replace(
        /^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/,
        '$1.$2.$3/$4-$5'
    );
};
