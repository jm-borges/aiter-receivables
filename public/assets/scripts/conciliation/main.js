import { bindCalendarModal } from '../common/calendar-modal.js';
import { createReceivablesCalendar } from '../receivables/receivables-calendar.js';
import { registerEventHandlers } from './handlers.js';

registerEventHandlers();

const calendar = createReceivablesCalendar();
calendar.render();

window.receivablesCalendar = calendar;

bindCalendarModal({
    id: 'receivables',
    calendar
});