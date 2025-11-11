import { fetchJson } from "../common/api.js";

export const fetchReceivablesByCnpj = (cnpj) =>
    fetchJson(`/api/v1/business-partners/lookup/${cnpj}/receivables/summary`);
