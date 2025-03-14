const ctx2 = document.getElementById('legalchart').getContext('2d');
const legalchart = new Chart(ctx2, {
    type: 'doughnut',
    data: {
        datasets: [{
            label: 'This Month',
            data: [0,0,0,0,0],
            backgroundColor: [
                'rgba(65, 53, 235, 0.623)',
                'rgba(187, 61, 23, 0.658)',
                'rgba(12, 107, 55, 0.596)',
                'rgba(112, 52, 209, 0.541)',
                'rgba(187, 96, 22, 0.589)'
            ],
            borderColor: [
                'rgba(65, 53, 235, 0.623)',
                'rgba(187, 61, 23, 0.658)',
                'rgba(12, 107, 55, 0.596)',
                'rgba(112, 52, 209, 0.541)',
                'rgba(187, 96, 22, 0.589)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});