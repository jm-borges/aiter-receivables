import { fetchJson } from "../common/api.js";

export const fetchReceivables = (id) =>
    fetchJson(`/api/v1/business-partners/${id}/receivables/summary`);
