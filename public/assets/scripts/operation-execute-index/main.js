import { initOperationCompanySelector } from "./selector.js";
import { handleInstallmentTypeFieldChange, handleInstallmentsSelectChange } from "./handlers-installments.js";
import { handleSubmitButtonClick } from "./handlers-submit.js";
import { attachLiveValidation } from "./handlers-validation.js";
import { bindCalendarModal } from '../common/calendar-modal.js';
import { createReceivablesCalendar } from '../receivables/receivables-calendar.js';

const installmentTypeField = document.getElementById('installment-type-field');
const submitButtonContainer = document.getElementById('submit-button-container');
const submitButton = document.getElementById('submit-button');
const informInstallmentsSelect = document.getElementById('inform-installments-select');

initOperationCompanySelector();

if (installmentTypeField) installmentTypeField.addEventListener('change', handleInstallmentTypeFieldChange);
if (informInstallmentsSelect) informInstallmentsSelect.addEventListener('change', handleInstallmentsSelectChange);
if (submitButton) submitButton.addEventListener('click', handleSubmitButtonClick);

attachLiveValidation();

export { installmentTypeField, submitButtonContainer };

const calendar = createReceivablesCalendar();
calendar.render();

window.receivablesCalendar = calendar;

bindCalendarModal({
    id: 'receivables',
    calendar
});