import Alpine from 'alpinejs';
import persist from '@alpinejs/persist';
import ApexCharts from 'apexcharts';
import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';
import Chart from 'chart.js/auto';

Alpine.plugin(persist);
window.Alpine = Alpine;
window.ApexCharts = ApexCharts;
window.Chart = Chart;

// TailAdmin Theme Manager
(function () {
    var stored = localStorage.getItem('darkMode');
    var isDark = stored !== null ? JSON.parse(stored) : true;

    if (isDark) {
        document.documentElement.classList.add('dark');
        document.documentElement.setAttribute('data-color-scheme', 'dark');
    } else {
        document.documentElement.classList.remove('dark');
        document.documentElement.setAttribute('data-color-scheme', 'light');
    }
})();

// Chart 01: Sebaran Kelompok Usia Warga RT 03 (TailAdmin Bar Chart)
const initChart01 = () => {
    const el = document.querySelector("#chartOne");
    if (!el) return;

    const usiaLabels = Array.isArray(window.usiaLabels) ? window.usiaLabels : [];
    const usiaData = Array.isArray(window.usiaData) ? window.usiaData : [];

    const chartOneOptions = {
        series: [
            {
                name: "Jumlah Warga",
                data: usiaData,
            },
        ],
        colors: ["#465fff"],
        chart: {
            fontFamily: "Outfit, sans-serif",
            type: "bar",
            height: 180,
            toolbar: {
                show: false,
            },
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: "39%",
                borderRadius: 5,
                borderRadiusApplication: "end",
            },
        },
        dataLabels: {
            enabled: false,
        },
        stroke: {
            show: true,
            width: 4,
            colors: ["transparent"],
        },
        xaxis: {
            categories: usiaLabels,
            title: {
                text: 'Kelompok Usia (tahun)',
                style: {
                    color: document.documentElement.classList.contains('dark') ? '#98A2B3' : '#667085',
                    fontSize: '11px',
                    fontFamily: 'Outfit, sans-serif',
                    fontWeight: 500,
                },
            },
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false,
            },
            labels: {
                style: {
                    colors: document.documentElement.classList.contains('dark') ? '#98A2B3' : '#667085',
                    fontSize: '12px',
                    fontFamily: 'Outfit, sans-serif',
                }
            }
        },
        yaxis: {
            title: false,
            labels: {
                formatter: function (val) {
                    return Math.round(val);
                },
                style: {
                    colors: document.documentElement.classList.contains('dark') ? '#98A2B3' : '#667085',
                    fontSize: '12px',
                    fontFamily: 'Outfit, sans-serif',
                }
            }
        },
        legend: {
            show: true,
            position: "top",
            horizontalAlign: "left",
            fontFamily: "Outfit",
            markers: {
                radius: 99,
            },
            labels: {
                colors: document.documentElement.classList.contains('dark') ? '#EAECF0' : '#344054',
            }
        },
        grid: {
            borderColor: document.documentElement.classList.contains('dark') ? '#1D2939' : '#E4E7EC',
            yaxis: {
                lines: {
                    show: true,
                },
            },
        },
        fill: {
            opacity: 1,
        },
        tooltip: {
            theme: document.documentElement.classList.contains('dark') ? 'dark' : 'light',
            x: {
                show: false,
            },
            y: {
                formatter: function (val) {
                    return val + ' warga';
                },
            },
        },
    };

    const chart = new ApexCharts(el, chartOneOptions);
    chart.render();
};

// Chart 02: Persentase Kelengkapan KTP Warga RT 03 (TailAdmin Radial Bar)
const initChart02 = () => {
    const el = document.querySelector("#chartTwo");
    if (!el) return;

    const isDark = document.documentElement.classList.contains('dark');
    const percentValue = typeof window.ktpPercent !== 'undefined'
        ? Number(window.ktpPercent)
        : 0;

    const chartTwoOptions = {
        series: [percentValue],
        colors: ["#465FFF"],
        chart: {
            fontFamily: "Outfit, sans-serif",
            type: "radialBar",
            height: 330,
            sparkline: {
                enabled: true,
            },
        },
        plotOptions: {
            radialBar: {
                startAngle: -90,
                endAngle: 90,
                hollow: {
                    size: "80%",
                },
                track: {
                    background: isDark ? "#1D2939" : "#E4E7EC",
                    strokeWidth: "100%",
                    margin: 5,
                },
                dataLabels: {
                    name: {
                        show: false,
                    },
                    value: {
                        fontSize: "36px",
                        fontWeight: "600",
                        offsetY: 60,
                        color: isDark ? "#FFFFFF" : "#1D2939",
                        formatter: function (val) {
                            return val + "%";
                        },
                    },
                },
            },
        },
        fill: {
            type: "solid",
            colors: ["#465FFF"],
        },
        stroke: {
            lineCap: "round",
        },
        labels: ["Progress"],
    };

    const chart = new ApexCharts(el, chartTwoOptions);
    chart.render();
};

// Chart 03: Evaluasi Kependudukan & Clustering (TailAdmin Area Chart)
const initChart03 = () => {
    const el = document.querySelector("#chartThree");
    if (!el) return;

    const isDark = document.documentElement.classList.contains('dark');

    const chartThreeOptions = {
        series: [
            {
                name: "Warga Aktif",
                data: [45, 52, 48, 55, 53, 56, 58, 60, 60, 60, 60, 60],
            },
            {
                name: "Partisipasi Ronda",
                data: [35, 40, 38, 42, 45, 47, 50, 52, 55, 54, 56, 58],
            },
        ],
        legend: {
            show: true,
            position: "top",
            horizontalAlign: "left",
            labels: {
                colors: isDark ? '#EAECF0' : '#344054',
            }
        },
        colors: ["#465FFF", "#10B981"],
        chart: {
            fontFamily: "Outfit, sans-serif",
            height: 310,
            type: "area",
            toolbar: {
                show: false,
            },
        },
        fill: {
            gradient: {
                enabled: true,
                opacityFrom: 0.55,
                opacityTo: 0,
            },
        },
        stroke: {
            curve: "smooth",
            width: ["2", "2"],
        },
        markers: {
            size: 0,
        },
        grid: {
            borderColor: isDark ? '#1D2939' : '#E4E7EC',
            xaxis: {
                lines: {
                    show: false,
                },
            },
            yaxis: {
                lines: {
                    show: true,
                },
            },
        },
        dataLabels: {
            enabled: false,
        },
        xaxis: {
            type: "category",
            categories: [
                "Jan", "Feb", "Mar", "Apr", "May", "Jun",
                "Jul", "Aug", "Sep", "Oct", "Nov", "Dec",
            ],
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false,
            },
            labels: {
                style: {
                    colors: isDark ? '#98A2B3' : '#667085',
                    fontSize: '12px',
                    fontFamily: 'Outfit, sans-serif',
                }
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors: isDark ? '#98A2B3' : '#667085',
                    fontSize: '12px',
                    fontFamily: 'Outfit, sans-serif',
                }
            }
        },
        tooltip: {
            theme: isDark ? 'dark' : 'light',
        }
    };

    const chart = new ApexCharts(el, chartThreeOptions);
    chart.render();
};

// Document Loaded Handler
document.addEventListener("DOMContentLoaded", () => {
    initChart01();
    initChart02();
    initChart03();

    // Flatpickr range init
    if (document.querySelectorAll(".datepicker").length) {
        flatpickr(".datepicker", {
            mode: "range",
            static: true,
            monthSelectorType: "static",
            dateFormat: "M j",
            defaultDate: [new Date(Date.now() - 6 * 24 * 60 * 60 * 1000), new Date()],
            prevArrow: '<svg class="stroke-current" width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M15.25 6L9 12.25L15.25 18.5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
            nextArrow: '<svg class="stroke-current" width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M8.75 19L15 12.75L8.75 6.5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
            onReady: (selectedDates, dateStr, instance) => {
                instance.element.value = "Periode " + new Date().toLocaleString('id-ID', { month: 'short', year: 'numeric' });
            },
            onChange: (selectedDates, dateStr, instance) => {
                instance.element.value = dateStr.replace("to", "-");
            },
        });
    }
});

Alpine.start();
