import { fetchJson } from "../common/api.js";

export const fetchCreditAnalysis = (id) =>
    fetchJson(`/api/v1/business-partners/${id}/credit-analysis`);
