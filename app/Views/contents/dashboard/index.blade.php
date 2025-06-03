@extends('layouts.app')

@section('content-title', 'Dashboard')

@push('styles')
<style>
    .chart-container {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        padding: 20px;
        margin-bottom: 20px;
    }
    .chart-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 15px;
        color: #333;
    }
    .stats-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        padding: 20px;
        margin-bottom: 20px;
    }
    .table-responsive {
        max-height: 400px;
        overflow-y: auto;
    }
    .dashboard-section {
        margin-bottom: 30px;
    }
</style>
@endpush

@section('content')
    <!-- Dashboard Statistics Cards -->
    @include('contents.dashboard.dashboard-card')

    <!-- Charts and Tables -->
    @include('contents.dashboard.charts-and-tables')

    <!-- Recent Comments -->
    @include('contents.dashboard.recent-comments')
@endsection

@push('custom-scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var categoryOptions = {
            chart: {
                type: 'pie',
                height: 350
            },
            series: @json(array_values($songsByCategory->toArray())),
            labels: @json(array_keys($songsByCategory->toArray())),
            colors: ['#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', '#FFEAA7', '#DDA0DD', '#FF8A80', '#82B1FF'],
            legend: {
                position: 'bottom'
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }],
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val + " songs"
                    }
                }
            }
        };
        var categoryChart = new ApexCharts(document.querySelector("#categoryChart"), categoryOptions);
        categoryChart.render();

        var monthlyData = @json($monthlySongs);
        var monthlyOptions = {
            chart: {
                type: 'line',
                height: 350,
                toolbar: {
                    show: true
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
                    text: 'Month'
                }
            },
            yaxis: {
                title: {
                    text: 'Number of Songs'
                }
            },
            colors: ['#45B7D1'],
            stroke: {
                curve: 'smooth',
                width: 3
            },
            markers: {
                size: 6,
                hover: {
                    size: 8
                }
            },
            grid: {
                show: true,
                borderColor: '#e0e0e0'
            },
            tooltip: {
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
                height: 350,
                toolbar: {
                    show: true
                }
            },
            series: [{
                name: 'Number of Songs',
                data: artistData.map(artist => artist.songs_count)
            }],
            xaxis: {
                categories: artistData.map(artist => artist.name),
                title: {
                    text: 'Artists'
                }
            },
            yaxis: {
                title: {
                    text: 'Number of Songs'
                }
            },
            colors: ['#96CEB4'],
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    borderRadius: 4
                }
            },
            dataLabels: {
                enabled: true,
                style: {
                    fontSize: '12px',
                    fontWeight: 'bold'
                }
            },
            grid: {
                show: true,
                borderColor: '#e0e0e0'
            },
            tooltip: {
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