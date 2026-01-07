var options = {
    chart: {
        type: 'bar',
        height: 480
    },
    series: [
        {
            name: 'Baru',
            data: window.monthlyTickets.baru
        },
        {
            name: 'Proses',
            data: window.monthlyTickets.proses
        },
        {
            name: 'Selesai',
            data: window.monthlyTickets.selesai
        },
        {
            name: 'Ditolak',
            data: window.monthlyTickets.ditolak
        }
    ],
    xaxis: {
        categories: [
            'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
            'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
        ]
    }
};

var chart = new ApexCharts(
    document.querySelector("#growthchart"),
    options
);
chart.render();
