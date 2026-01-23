import { fetchJson } from "../common/api.js";

export const fetchPartners = (query = '', type = 'client') =>
    fetchJson(`/api/v1/business-partners?search=${encodeURIComponent(query)}&type=${encodeURIComponent(type)}`);

export const fetchPartnerReceivablesDetails = (id) =>
    fetchJson(`/api/v1/business-partners/${id}/receivables/summary`);

export const fetchPartnerContractsPaymentsDetails = (id) =>
    fetchJson(`/api/v1/business-partners/${id}/contract-payments/summary`);
