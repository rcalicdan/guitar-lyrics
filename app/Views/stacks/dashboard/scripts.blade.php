@push('custom-scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const colorPalette = [
            '#4f46e5', '#06b6d4', '#10b981', '#f59e0b', 
            '#ef4444', '#8b5cf6', '#ec4899', '#14b8a6'
        ];

        var categoryOptions = {
            chart: {
                type: 'pie',
                height: 380,
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800,
                }
            },
            series: @json(array_values($songsByCategory->toArray())),
            labels: @json(array_keys($songsByCategory->toArray())),
            colors: colorPalette,
            legend: {
                position: 'bottom',
                fontSize: '14px',
                fontWeight: 500,
                markers: {
                    width: 12,
                    height: 12,
                    radius: 6
                }
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '40%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                fontSize: '18px',
                                fontWeight: 600,
                                color: '#111827'
                            }
                        }
                    },
                    expandOnClick: true
                }
            },
            dataLabels: {
                enabled: true,
                style: {
                    fontSize: '12px',
                    fontWeight: 600
                },
                dropShadow: {
                    enabled: false
                }
            },
            tooltip: {
                style: {
                    fontSize: '14px',
                },
                y: {
                    formatter: function (val) {
                        return val + " songs"
                    }
                }
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        height: 300
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };
        var categoryChart = new ApexCharts(document.querySelector("#categoryChart"), categoryOptions);
        categoryChart.render();

        var monthlyData = @json($monthlySongs);
        var monthlyOptions = {
            chart: {
                type: 'area',
                height: 380,
                toolbar: {
                    show: true,
                    tools: {
                        download: true,
                        selection: true,
                        zoom: true,
                        zoomin: true,
                        zoomout: true,
                        pan: true,
                        reset: true
                    }
                },
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800,
                }
            },
            series: [{
                name: 'Songs Created',
                data: monthlyData.map(item => item.count)
            }],
            xaxis: {
                categories: monthlyData.map(item => {
                    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                    return months[item.month - 1] + ' ' + item.year;
                }),
                title: {
                    text: 'Month',
                    style: {
                        fontSize: '14px',
                        fontWeight: 600
                    }
                },
                labels: {
                    style: {
                        fontSize: '12px'
                    }
                }
            },
            yaxis: {
                title: {
                    text: 'Number of Songs',
                    style: {
                        fontSize: '14px',
                        fontWeight: 600
                    }
                },
                labels: {
                    style: {
                        fontSize: '12px'
                    }
                }
            },
            colors: ['#4f46e5'],
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'light',
                    type: 'vertical',
                    shadeIntensity: 0.25,
                    gradientToColors: ['#06b6d4'],
                    inverseColors: false,
                    opacityFrom: 0.85,
                    opacityTo: 0.25,
                }
            },
            stroke: {
                curve: 'smooth',
                width: 3
            },
            markers: {
                size: 6,
                hover: {
                    size: 8
                },
                colors: ['#ffffff'],
                strokeColors: '#4f46e5',
                strokeWidth: 2
            },
            grid: {
                show: true,
                borderColor: '#e5e7eb',
                strokeDashArray: 5
            },
            tooltip: {
                style: {
                    fontSize: '14px',
                },
                x: {
                    format: 'MMM yyyy'
                }
            }
        };
        var monthlyChart = new ApexCharts(document.querySelector("#monthlyChart"), monthlyOptions);
        monthlyChart.render();

        var artistData = @json($topArtists);
        var artistOptions = {
            chart: {
                type: 'bar',
                height: 380,
                toolbar: {
                    show: true
                },
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800,
                }
            },
            series: [{
                name: 'Number of Songs',
                data: artistData.map(artist => artist.songs_count)
            }],
            xaxis: {
                categories: artistData.map(artist => artist.name),
                title: {
                    text: 'Artists',
                    style: {
                        fontSize: '14px',
                        fontWeight: 600
                    }
                },
                labels: {
                    style: {
                        fontSize: '12px'
                    },
                    rotate: -45
                }
            },
            yaxis: {
                title: {
                    text: 'Number of Songs',
                    style: {
                        fontSize: '14px',
                        fontWeight: 600
                    }
                },
                labels: {
                    style: {
                        fontSize: '12px'
                    }
                }
            },
            colors: ['#10b981'],
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '60%',
                    borderRadius: 8,
                    borderRadiusApplication: 'end',
                    borderRadiusWhenStacked: 'last'
                }
            },
            dataLabels: {
                enabled: true,
                style: {
                    fontSize: '12px',
                    fontWeight: 600,
                    colors: ['#ffffff']
                },
                offsetY: -10
            },
            grid: {
                show: true,
                borderColor: '#e5e7eb',
                strokeDashArray: 5
            },
            tooltip: {
                style: {
                    fontSize: '14px',
                },
                y: {
                    formatter: function (val) {
                        return val + " songs"
                    }
                }
            }
        };
        var artistChart = new ApexCharts(document.querySelector("#artistChart"), artistOptions);
        artistChart.render();
    });
</script>
@endpush