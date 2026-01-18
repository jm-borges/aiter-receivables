// -----------------------------
// Layout & escala
// -----------------------------
function buildLayout({ viewWidth, height }) {
    const paddingLeft = 40;
    const paddingTop = 20;
    const paddingBottom = 40;

    const width = viewWidth - paddingLeft - 20;
    const chartHeight = height - paddingTop - paddingBottom;

    return {
        viewWidth,
        height,
        paddingLeft,
        paddingTop,
        paddingBottom,
        width,
        chartHeight,
    };
}

function getMaxValue(series) {
    const allValues = series.flatMap(s => s.values);
    return Math.max(1, ...allValues);
}

function createYScaler({ paddingTop, chartHeight }, maxValue) {
    return function yFor(value) {
        return paddingTop + (chartHeight - (value / maxValue) * chartHeight);
    };
}

function computeXStep(width, count) {
    return width / Math.max(1, count - 1);
}

// -----------------------------
// Path builders
// -----------------------------
function buildLinePath({ paddingLeft }, stepX, yFor, values) {
    let path = '';

    values.forEach((v, i) => {
        const x = paddingLeft + i * stepX;
        const y = yFor(v);
        path += (i === 0 ? 'M' : 'L') + `${x} ${y} `;
    });

    return path;
}

function buildAreaPath(linePath, { paddingLeft, paddingTop, chartHeight }, stepX, count) {
    const baseY = paddingTop + chartHeight;
    const endX = paddingLeft + (count - 1) * stepX;

    return `${linePath} L ${endX} ${baseY} L ${paddingLeft} ${baseY} Z`;
}

// -----------------------------
// SVG Parts
// -----------------------------
function renderDefs(series) {
    return `
<defs>
${series.map(s => `
    <linearGradient id="grad-${s.key}" x1="0" y1="0" x2="0" y2="1">
        <stop offset="0%" stop-color="${s.color}" stop-opacity="0.25" />
        <stop offset="100%" stop-color="${s.color}" stop-opacity="0" />
    </linearGradient>
`).join('')}
</defs>`;
}

function renderSeriesPaths(series, ctx) {
    const { layout, stepX, yFor, count } = ctx;

    let svg = '';

    series.forEach(s => {
        const linePath = buildLinePath(layout, stepX, yFor, s.values);
        const areaPath = buildAreaPath(linePath, layout, stepX, count);

        svg += `
<path d="${areaPath}" fill="url(#grad-${s.key})" />
<path d="${linePath}" fill="none" stroke="${s.color}" stroke-width="3" />
`;
    });

    return svg;
}

function renderSeriesPoints(series, ctx, valueFormatter) {
    const { layout, stepX, yFor } = ctx;

    const formatValue = valueFormatter ?? (v => String(v));

    let svg = '';

    series.forEach(s => {
        s.values.forEach((v, i) => {
            const x = layout.paddingLeft + i * stepX;
            const y = yFor(v);

            svg += `
<circle cx="${x}" cy="${y}" r="4" fill="${s.color}" />
<text x="${x}" y="${y - 8}" text-anchor="middle" font-size="12" fill="${s.color}">
    ${formatValue(v, s)}
</text>
`;
        });
    });

    return svg;
}


// -----------------------------
// HTML Parts
// -----------------------------
function renderXLabels(labels) {
    return `
<div class="flex justify-between text-xs text-[#2d1b69] mt-2 px-2">
${labels.map(label => `
    <div class="text-center">${label.replace(' ', '<br>')}</div>
`).join('')}
</div>
`;
}

function renderLegend(series) {
    return `
<div class="flex gap-6 mt-2 text-sm text-[#2d1b69]">
${series.map(s => `
    <div class="flex items-center gap-2">
        <span class="inline-block w-6 h-1 rounded" style="background:${s.color}"></span>
        <span>${s.label}</span>
    </div>
`).join('')}
</div>
`;
}

// -----------------------------
// SVG Composer
// -----------------------------
function buildSVG({ layout, series, stepX, yFor, count, valueFormatter }) {
    let svg = `
<svg viewBox="0 0 ${layout.viewWidth} ${layout.height}" class="w-full h-56">
${renderDefs(series)}
`;

    svg += renderSeriesPaths(series, { layout, stepX, yFor, count });
    svg += renderSeriesPoints(series, { layout, stepX, yFor }, valueFormatter);

    svg += `</svg>`;

    return svg;
}

// -----------------------------
// Public API
// -----------------------------
export function renderLineChart(container, { labels, series, height = 240, valueFormatter }) {
    const viewWidth = 800;

    const layout = buildLayout({ viewWidth, height });
    const count = labels.length;
    const stepX = computeXStep(layout.width, count);
    const maxValue = getMaxValue(series);
    const yFor = createYScaler(layout, maxValue);

    const svg = buildSVG({
        layout,
        series,
        stepX,
        yFor,
        count,
        valueFormatter
    });


    const labelsHtml = renderXLabels(labels);
    const legendHtml = renderLegend(series);

    container.innerHTML = `
<div class="relative">
    ${svg}
    ${labelsHtml}
    ${legendHtml}
</div>
`;
}
