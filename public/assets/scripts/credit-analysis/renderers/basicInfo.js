export function renderBasicInfo(resultBox, data) {
    resultBox.innerHTML = `
        <div style="margin-top: 10px; color:#211748;">
            <strong>Razão Social:</strong> ${data.company_name ?? '—'}<br>
        </div>
    `;
}