export const fetchJson = async (url) => {
    const res = await fetch(url, {
        credentials: 'include',
        headers: { 'Accept': 'application/json' },
    });
    if (!res.ok) throw new Error(`Erro ${res.status}`);
    return res.json();
};
