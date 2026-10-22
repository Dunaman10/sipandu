import Alpine from 'alpinejs';
import Chart from 'chart.js/auto';

window.Alpine = Alpine;
window.Chart = Chart;

// TailAdmin Dark Mode Theme Manager
(function () {
    var stored = localStorage.getItem('darkMode');
    var isDark = stored !== null ? JSON.parse(stored) : false;

    if (isDark) {
        document.documentElement.classList.add('dark');
        document.documentElement.setAttribute('data-color-scheme', 'dark');
    } else {
        document.documentElement.classList.remove('dark');
        document.documentElement.setAttribute('data-color-scheme', 'light');
    }
})();

Alpine.start();
