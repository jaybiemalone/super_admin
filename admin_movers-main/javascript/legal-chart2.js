const ctx = document.getElementById('legalchart2');
const legalchart2 = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Safety Measures', 'Vehicle Maintenance', 'insurance Coverage', 'Background Checks', 'App Functionality'],
        datasets: [{
            label: 'User Compliance',
            backgroundColor: "rgb(44, 101, 187)",
            data: [0,0,0,0,0]
        }, {
            label: 'Driver Compliance',
            backgroundColor: "#f7760c",
            data: [0,0,0,0,0]
        }]
    },
    options: {
        scales: {
            yAxes:[{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});