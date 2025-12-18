export const fetchJson = async (url, options = {}) => {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const res = await fetch(url, {
        credentials: 'include',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            ...options.headers,
        },
        ...options,
    });

    if (!res.ok) throw new Error(`Erro ${res.status}`);
    return res.json();
};
