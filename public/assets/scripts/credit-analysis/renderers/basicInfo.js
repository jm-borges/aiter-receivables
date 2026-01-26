export function renderBasicInfo(resultBox, data) {
    resultBox.innerHTML = `
    <div class="mt-2.5 text-[#211748]">
        <strong>Razão Social:</strong> ${data.company_name ?? '—'}<br>
    </div>
`;

}