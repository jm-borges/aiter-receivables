import { handleFetchCnpj } from "./handlers-fetch.js";
import { handleInstallmentTypeFieldChange, handleInstallmentsSelectChange } from "./handlers-installments.js";
import { handleSubmitButtonClick } from "./handlers-submit.js";
import { attachLiveValidation } from "./handlers-validation.js";

const button = document.getElementById('fetch-cnpj');
const installmentTypeField = document.getElementById('installment-type-field');
const submitButtonContainer = document.getElementById('submit-button-container');
const submitButton = document.getElementById('submit-button');
const informInstallmentsSelect = document.getElementById('inform-installments-select');

if (button) button.addEventListener('click', handleFetchCnpj);
if (installmentTypeField) installmentTypeField.addEventListener('change', handleInstallmentTypeFieldChange);
if (informInstallmentsSelect) informInstallmentsSelect.addEventListener('change', handleInstallmentsSelectChange);
if (submitButton) submitButton.addEventListener('click', handleSubmitButtonClick);

attachLiveValidation();

export { installmentTypeField, submitButtonContainer };

