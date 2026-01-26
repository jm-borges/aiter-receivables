import { registerEventHandlers } from './handlers.js';
import { bindCalendarModal } from '../common/calendar-modal.js';
import { createReceivablesCalendar } from '../receivables/receivables-calendar.js';
import { createCardsRevenueCalendar } from '../receivables/cards-revenue-calendar.js';

document.addEventListener('DOMContentLoaded', registerEventHandlers);

const receivablesCalendar = createReceivablesCalendar();
const cardsRevenueCalendar = createCardsRevenueCalendar();
receivablesCalendar.render();
cardsRevenueCalendar.render();

window.receivablesCalendar = receivablesCalendar;
window.cardsRevenueCalendar = cardsRevenueCalendar;

bindCalendarModal({
    id: 'receivables',
    calendar: receivablesCalendar
});

bindCalendarModal({
    id: 'cards-revenue',
    calendar: cardsRevenueCalendar
});