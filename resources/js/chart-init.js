import { Chart, LineController, LineElement, PointElement, LinearScale, CategoryScale, Filler, Tooltip } from 'chart.js';

Chart.register(LineController, LineElement, PointElement, LinearScale, CategoryScale, Filler, Tooltip);

document.addEventListener('alpine:init', () => {
    window.Alpine.data('viewsChart', (labels, data) => ({
        chart: null,
        resizeObserver: null,
        init() {
            this.chart = new Chart(this.$refs.canvas, {
                type: 'line',
                data: {
                    labels,
                    datasets: [{
                        label: 'Views',
                        data,
                        borderColor: '#0B2545',
                        backgroundColor: 'rgba(11, 37, 69, 0.08)',
                        fill: true,
                        tension: 0.35,
                        pointRadius: 3,
                        pointBackgroundColor: '#F4B400',
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, ticks: { precision: 0 } },
                    },
                },
            });

            this.resizeObserver = new ResizeObserver(() => this.chart?.resize());
            this.resizeObserver.observe(this.$refs.canvas.parentElement);
        },
        destroy() {
            this.resizeObserver?.disconnect();
        },
    }));
});
