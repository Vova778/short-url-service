import Chart from "chart.js/auto";
import $ from "jquery";

$(function () {
    const clicks = window.linkClicks || [];

    function aggregate(arr, field, emptyLabel = "Unknown") {
        const counts = {};
        arr.forEach((item) => {
            let key =
                item[field] && item[field].trim() !== ""
                    ? item[field]
                    : field === "referrer"
                    ? "Direct"
                    : emptyLabel;
            counts[key] = (counts[key] || 0) + 1;
        });
        return counts;
    }

    function renderChart(canvasId, dataCounts, type = "pie") {
        const labels = Object.keys(dataCounts);
        const data = labels.map((lbl) => dataCounts[lbl]);
        const ctx = document.getElementById(canvasId).getContext("2d");

        if (window[canvasId + "Chart"]) {
            window[canvasId + "Chart"].destroy();
        }

        window[canvasId + "Chart"] = new Chart(ctx, {
            type: type,
            data: {
                labels: labels,
                datasets: [
                    {
                        data,
                        backgroundColor: [
                            "#4e73df",
                            "#1cc88a",
                            "#36b9cc",
                            "#f6c23e",
                            "#e74a3b",
                            "#858796",
                            "#5a5c69",
                            "#2e59d9",
                            "#17a673",
                            "#2c9faf",
                        ],
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: "bottom" },
                    tooltip: {
                        callbacks: {
                            label: (ctx) => `${ctx.label}: ${ctx.parsed}`,
                        },
                    },
                },
            },
        });
    }
    console.log(clicks);

    // Ініціалізація
    renderChart("countriesChart", aggregate(clicks, "country"));
    renderChart("browsersChart", aggregate(clicks, "browser"));
    renderChart("devicesChart", aggregate(clicks, "device"), "doughnut");
    renderChart("referrersChart", aggregate(clicks, "referrer"));

    // Обробники "Оновити"
    $("#refresh-countries").click(() =>
        renderChart("countriesChart", aggregate(window.linkClicks, "country"))
    );
    $("#refresh-browsers").click(() =>
        renderChart("browsersChart", aggregate(window.linkClicks, "browser"))
    );
    $("#refresh-devices").click(() =>
        renderChart(
            "devicesChart",
            aggregate(window.linkClicks, "device"),
            "doughnut"
        )
    );
    $("#refresh-referrers").click(() =>
        renderChart("referrersChart", aggregate(window.linkClicks, "referrer"))
    );
});
