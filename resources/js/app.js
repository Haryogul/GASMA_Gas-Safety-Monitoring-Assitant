import Chart from 'chart.js/auto';

// == 1. Handle Revenue Chart ==
const canvasRevenue = document.getElementById('revenueChart');
if (canvasRevenue) {
    const ctxRevenue = canvasRevenue.getContext('2d');
    new Chart(ctxRevenue, {
        type: 'line',
        data: {
            labels: JSON.parse(canvasRevenue.dataset.labels || '[]'), 
            datasets: [{
                label: 'Total Revenue',
                data: JSON.parse(canvasRevenue.dataset.data || '[]'),
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2,
                fill: false
            }]
        },
        options: { responsive: true }
    });
}

// == 2. Handle Profit Chart ==
const canvasProfit = document.getElementById('profitChart');
if (canvasProfit) {
    const ctxProfit = canvasProfit.getContext('2d');
    new Chart(ctxProfit, {
        type: 'bar',
        data: {
            labels: JSON.parse(canvasProfit.dataset.labels || '[]'),
            datasets: [
                {
                    label: 'Sales',
                    data: JSON.parse(canvasProfit.dataset.sales || '[]'),
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Revenue',
                    data: JSON.parse(canvasProfit.dataset.revenue || '[]'),
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: { responsive: true }
    });
}