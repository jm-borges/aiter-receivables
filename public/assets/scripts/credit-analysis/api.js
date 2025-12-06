import { fetchJson } from "../common/api.js";

export const fetchCreditAnalysisByCnpj = (cnpj) =>
    fetchJson(`/api/v1/business-partners/lookup/${cnpj}/credit-analysis`);
