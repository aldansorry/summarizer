<script>
    var cname_url = "<?php echo base_url($cname) ?>";

    var table_pengujian;

    var table_bobot;
    var chart_bobot;
    var data_bobot = [];
    var chart_option = {
        maintainAspectRatio: false,
        layout: {
            padding: {
                left: 10,
                right: 25,
                top: 25,
                bottom: 0
            }
        },
        scales: {
            xAxes: [{
                time: {
                    unit: 'date'
                },
                gridLines: {
                    display: false,
                    drawBorder: false
                },
                ticks: {
                    maxTicksLimit: 7
                }
            }],
            yAxes: [{
                ticks: {
                    max: 100,
                    beginAtZero: true,
                    maxTicksLimit: 5,
                    stepSize: 25,
                    padding: 10,
                    // Include a dollar sign in the ticks
                    callback: function(value, index, values) {
                        return number_format(value) + "%";
                    }
                },
                gridLines: {
                    color: "rgb(234, 236, 244)",
                    zeroLineColor: "rgb(234, 236, 244)",
                    drawBorder: false,
                    borderDash: [2],
                    zeroLineBorderDash: [2]
                }
            }],
        },
        legend: {
            display: false
        },
        tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            titleMarginBottom: 10,
            titleFontColor: '#6e707e',
            titleFontSize: 14,
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            intersect: false,
            mode: 'index',
            caretPadding: 10,
            callbacks: {
                label: function(tooltipItem, chart) {
                    var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                    return datasetLabel + ': ' + number_format(tooltipItem.yLabel) + "%";
                }
            }
        }
    };

    $(document).ready(function() {

        table_pengujian = $('#table-pengujian').DataTable({
            ajax: {
                url: cname_url + "/getPengujianAccuracy",
            },
            'columns': [{
                    "title": "No",
                    "width": "15px",
                    "data": null,
                    "visible": true,
                    "class": "text-center",
                    render: (data, type, row, meta) => {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    'title': '',
                    "width": "79px",
                    'class': "",
                    'data': (data) => {
                        let ret = "";
                        ret += '<div class="btn-group">';
                        ret += '<a href="javascript:void(0)" class="btn btn-sm text-warning" onclick="get_accuracy(this)" data-id="' + data.id + '"><i class="fa fa-pencil-alt"></i> View</a>';
                        ret += '</div>';
                        return ret;
                    }
                },
                {
                    'title': 'Tanggal',
                    'data': 'tanggal'
                },
                {
                    'title': 'berita',
                    'data': 'berita'
                },
                {
                    'title': 'bobot',
                    "width": "170px",
                    'class': "wrapok",
                    'data': 'bobot'
                }
            ],
        });

    });

    
</script>