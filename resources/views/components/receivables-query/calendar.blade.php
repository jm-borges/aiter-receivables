<div class="calendar-modal-content">
    <div class="calendar-header">
        <button class="nav-btn" id="calendar-prev-month">◀</button>

        <h2 id="receivables-calendar-title">Mês</h2>

        <button class="nav-btn" id="calendar-next-month">▶</button>
    </div>

    <div class="calendar-grid" id="receivables-calendar-grid"></div>
</div>


<style>
    .calendar-modal-content {
        width: 100%;
        max-width: 1000px;
        background: white;
        border-radius: 16px;
        padding: 20px;
        font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    /* Header */
    .calendar-header {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        position: relative;
        margin-bottom: 16px;
    }

    .calendar-header h2 {
        margin: 0;
        font-size: 24px;
        font-weight: 700;
        color: #1e144f;
    }

    .nav-btn {
        border: none;
        background: none;
        font-size: 20px;
        cursor: pointer;
    }

    .close-btn {
        position: absolute;
        right: 0;
        top: 0;
        border: none;
        background: #eee;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        cursor: pointer;
    }

    /* Grid */
    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 2px;
        background: #ddd;
        border-radius: 12px;
        overflow: hidden;
    }

    /* Weekdays header */
    .calendar-weekday {
        background: #24155f;
        color: white;
        padding: 10px;
        font-weight: 600;
        text-align: center;
        font-size: 14px;
    }

    /* Days */
    .calendar-day {
        background: #eceaec;
        min-height: 110px;
        padding: 10px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .calendar-day.empty {
        background: #f2f2f2;
        color: #aaa;
    }

    /* Day number */
    .day-number {
        font-size: 20px;
        font-weight: 700;
        color: #1e144f;
    }

    /* Values */
    .day-values {
        display: flex;
        flex-direction: column;
        gap: 6px;
        font-size: 12px;
    }

    .received strong {
        color: #0a7a2f;
        font-size: 13px;
    }

    .received span {
        color: #0a7a2f;
    }

    .to-receive strong {
        color: #c40000;
        font-size: 13px;
    }

    .to-receive span {
        color: #c40000;
    }
</style>
