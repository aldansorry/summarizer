<script>
    var cname_url = "<?php echo base_url($cname) ?>";
    var chart_berita_month;
    var chart_berita_sumber;
    var chart_berita_katadata;
    var chart_berita_detik;
    var chart_berita_kompas;

    var chart_bar_option = {
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
                    beginAtZero: true,
                    maxTicksLimit: 5,

                    padding: 10,
                    // Include a dollar sign in the ticks
                    callback: function(value, index, values) {
                        return number_format(value);
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
                    return datasetLabel + ': ' + number_format(tooltipItem.yLabel);
                }
            }
        }
    };
    var chart_bar_option_2 = {
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
            }],
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    maxTicksLimit: 5,

                    padding: 10,
                    // Include a dollar sign in the ticks
                    callback: function(value, index, values) {
                        return number_format(value);
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
                    return datasetLabel + '' + number_format(tooltipItem.yLabel);
                }
            }
        }
    };

    $(document).ready(function() {
        init_chart();
        get_berita_month("<?php echo date("Y") ?>");
        get_content();
    });

    var get_content = () => {
        $.ajax({
            url: cname_url + "/getContent",
            dataType: "JSON",
            success: (data) => {
                chart_berita_sumber.data.label = data.chart_berita_sumber.label
                chart_berita_sumber.data.datasets[0].data = data.chart_berita_sumber.data;

                chart_berita_sumber.update({
                    duration: 800,
                    easing: 'easeOutBounce'
                });

                $("#count-total-berita").text(data.count.total_berita);
                $("#count-relevansi-berita").text(data.count.relevansi_berita);
                $('#bar-scraped-text').text(parseFloat(data.count.berita_scraped).toFixed(0) + "%");
                $('#bar-featured-text').text(parseFloat(data.count.berita_featured).toFixed(0) + "%");
                $('#bar-scraped-bar').css('width', data.count.berita_scraped + "%");
                $('#bar-featured-bar').css('width', data.count.berita_featured + "%");

                $('.counter').each(function() {
                    var $this = $(this);
                    jQuery({
                        Counter: 0
                    }).animate({
                        Counter: $this.text()
                    }, {
                        duration: 500,
                        easing: 'swing',
                        step: function() {
                            $this.text(Math.ceil(this.Counter));
                        }
                    });
                });

                //sumber_kategori
                if (chart_berita_katadata != null) {
                    chart_berita_katadata.destroy();
                }
                chart_berita_katadata = new Chart(document.getElementById("chart-berita-katadata"), {
                    type: 'bar',
                    data: {
                        labels: data.chart_berita_katadata.label,
                        datasets: [{
                            data: data.chart_berita_katadata.data,
                            backgroundColor: ['#4e73df', '#36b9cc', '#e74a3b', '#4e73df', '#36b9cc', '#e74a3b', '#4e73df', '#36b9cc', '#e74a3b', '#4e73df', '#36b9cc', '#e74a3b', '#4e73df', '#36b9cc', '#e74a3b', '#4e73df', '#36b9cc', '#e74a3b', '#4e73df', '#36b9cc', '#e74a3b'],
                            hoverBackgroundColor: ['#2e59d9', '#36b9cc', '#e74a3b', '#2e59d9', '#36b9cc', '#e74a3b', '#2e59d9', '#36b9cc', '#e74a3b', '#2e59d9', '#36b9cc', '#e74a3b', '#2e59d9', '#36b9cc', '#e74a3b', '#2e59d9', '#36b9cc', '#e74a3b', '#2e59d9', '#36b9cc', '#e74a3b'],
                            hoverBorderColor: "rgba(234, 236, 244, 1)",
                        }],
                    },
                    options: chart_bar_option_2
                });

                if (chart_berita_detik != null) {
                    chart_berita_detik.destroy();
                }
                chart_berita_detik = new Chart(document.getElementById("chart-berita-detik"), {
                    type: 'bar',
                    data: {
                        labels: data.chart_berita_detik.label,
                        datasets: [{
                            data: data.chart_berita_detik.data,
                            backgroundColor: ['#4e73df', '#36b9cc', '#e74a3b', '#4e73df', '#36b9cc', '#e74a3b', '#4e73df', '#36b9cc', '#e74a3b', '#4e73df', '#36b9cc', '#e74a3b', '#4e73df', '#36b9cc', '#e74a3b', '#4e73df', '#36b9cc', '#e74a3b', '#4e73df', '#36b9cc', '#e74a3b'],
                            hoverBackgroundColor: ['#2e59d9', '#36b9cc', '#e74a3b', '#2e59d9', '#36b9cc', '#e74a3b', '#2e59d9', '#36b9cc', '#e74a3b', '#2e59d9', '#36b9cc', '#e74a3b', '#2e59d9', '#36b9cc', '#e74a3b', '#2e59d9', '#36b9cc', '#e74a3b', '#2e59d9', '#36b9cc', '#e74a3b'],
                            hoverBorderColor: "rgba(234, 236, 244, 1)",
                        }],
                    },
                    options: chart_bar_option_2,
                });

                if (chart_berita_kompas != null) {
                    chart_berita_kompas.destroy();
                }
                chart_berita_kompas = new Chart(document.getElementById("chart-berita-kompas"), {
                    type: 'bar',
                    data: {
                        labels: data.chart_berita_kompas.label,
                        datasets: [{
                            data: data.chart_berita_kompas.data,
                            backgroundColor: ['#4e73df', '#36b9cc', '#e74a3b', '#4e73df', '#36b9cc', '#e74a3b', '#4e73df', '#36b9cc', '#e74a3b', '#4e73df', '#36b9cc', '#e74a3b', '#4e73df', '#36b9cc', '#e74a3b', '#4e73df', '#36b9cc', '#e74a3b', '#4e73df', '#36b9cc', '#e74a3b'],
                            hoverBackgroundColor: ['#2e59d9', '#36b9cc', '#e74a3b', '#2e59d9', '#36b9cc', '#e74a3b', '#2e59d9', '#36b9cc', '#e74a3b', '#2e59d9', '#36b9cc', '#e74a3b', '#2e59d9', '#36b9cc', '#e74a3b', '#2e59d9', '#36b9cc', '#e74a3b', '#2e59d9', '#36b9cc', '#e74a3b'],
                            hoverBorderColor: "rgba(234, 236, 244, 1)",
                        }],
                    },
                    
                    options: chart_bar_option_2,
                });
            }
        })
    }

    var get_berita_month = (year) => {
        $.ajax({
            url: cname_url + "/getBeritaMonth",
            type: "POST",
            data: {
                year: year,
            },
            dataType: "JSON",
            success: (data) => {
                chart_berita_month.data.label = data.chart.label
                chart_berita_month.data.datasets[0].data = data.chart.dataset.katadata;
                chart_berita_month.data.datasets[1].data = data.chart.dataset.detik;
                chart_berita_month.data.datasets[2].data = data.chart.dataset.kompas;

                chart_berita_month.update({
                    duration: 800,
                    easing: 'easeOutBounce'
                });
            }
        })
    }

    var init_chart = () => {
        chart_berita_month = new Chart(document.getElementById('chart-berita-month'), {
            type: 'bar',
            data: {
                labels: ['JAN', 'FEB', 'MAR', 'APR', 'MEI', 'JUN', 'JUL', 'AGU', 'SEP', 'NOV', 'OKT', 'DES'],
                datasets: [{
                        label: "KataData",
                        backgroundColor: "#4e73df",
                        data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                    },
                    {
                        label: "Detik",
                        backgroundColor: "#36b9cc",
                        data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                    },
                    {
                        label: "Kompas",
                        backgroundColor: "#e74a3b",
                        data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                    },
                ],
            },
            options: chart_bar_option
        });

        chart_berita_sumber = new Chart(document.getElementById("chart-berita-sumber"), {
            type: 'doughnut',
            data: {
                labels: ["Katadata", "Detik", "Kompas"],
                datasets: [{
                    data: [55, 30, 15],
                    backgroundColor: ['#4e73df', '#36b9cc', '#e74a3b'],
                    hoverBackgroundColor: ['#2e59d9', '#36b9cc', '#e74a3b'],
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                },
                legend: {
                    display: true,
                    position: 'right',
                    labels: {
                        usePointStyle: true,
                    }
                },
                cutoutPercentage: 80,
            },
        });

    }
</script>