@extends('admin.common.layout')
@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="card">
                    {{-- <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs nav-fill" data-bs-toggle="tabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a href="#tabs-daily-5" class="nav-link active" data-bs-toggle="tab" aria-selected="false"
                                    role="tab" tabindex="-1">Ngày hôm nay</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="#tabs-weekly-5" class="nav-link" data-bs-toggle="tab" aria-selected="false"
                                    role="tab" tabindex="-1">Tuần này</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="#tabs-monthly-5" class="nav-link" data-bs-toggle="tab" aria-selected="false"
                                    role="tab" tabindex="-1">Tháng này</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="#tabs-yearly-5" class="nav-link" data-bs-toggle="tab" aria-selected="false"
                                    role="tab" tabindex="-1">Năm này</a>
                            </li>
                        </ul>
                    </div> --}}
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabs-daily-5" role="tabpanel">
                                <div class="row">
                                    <div class="col">
                                        <div class="card border-0 shadow-lg rounded-4 p-4 pt-3">
                                            <h3>Số người dùng</h3>
                                            {{ $data->userCount }}
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card border-0 shadow-lg rounded-4 p-4 pt-3">
                                            <h3>Số người dùng bị cấm</h3>
                                            {{ $data->userBannedCount }}
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card border-0 shadow-lg rounded-4 p-4 pt-3">
                                            <h3>Số người dùng chưa đăng ký</h3>
                                            {{ $data->notRegisteredCount }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row  shadow-lg rounded-4 p-4 pt-3 mt-4">
                    <div class="col-6 card border-0 shadow-lg rounded-4 p-4 pt-3">
                        <h3>Giới tính người dùng sử dụng web</h3>
                        <div id="chartpie"></div>
                    </div>
                    <div class="col-6 card border-0 shadow-lg rounded-4 p-4 pt-3">
                        <h3>Độ tuổi người dùng sử dụng web</h3>
                        <div id="chartpie2"></div>
                    </div>
                </div>
                {{-- <div class="col-12 mt-4">
                    <div class="card border-0 shadow-lg rounded-4 p-4 pt-3">
                        <h3>Bảng thống kê so sánh tiền thu được hàng tháng</h3>
                        <div id="chart" style="min-height: 365px;"></div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
@endsection
@section('page_js')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        var chartPieInfo = @json($data).genderDP;
        // console.log(chartPieInfo);
        var options = {
            series: chartPieInfo,
            chart: {
                width: 400,
                type: 'pie',
            },
            labels: ['Nam','Nữ','Khác'],
            responsive: [{
                breakpoint: 200,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };
        var chartpie = new ApexCharts(document.querySelector("#chartpie"), options);
        chartpie.render();
        var chartPieInfo2 = @json($data).ageDP;
        const keyschart2 = Object.keys(chartPieInfo2);
        const valueschart2 = Object.values(chartPieInfo2);
        console.log(keyschart2);
        console.log(valueschart2);
        var options2 = {
            series: valueschart2,
            chart: {
                width: 400,
                type: 'pie',
            },
            labels:  keyschart2,
            responsive: [{
                breakpoint: 200,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };
        var chartpie2 = new ApexCharts(document.querySelector("#chartpie2"), options2);
        chartpie2.render();

        // var chartInfo = @json($data).chart;
        // // console.log(chartInfo);
        // var options = {
        //     series: [{
        //         name: 'Số tiền thu được',
        //         data: chartInfo
        //     }],
        //     chart: {
        //         type: 'bar',
        //         height: 350
        //     },
        //     plotOptions: {
        //         bar: {
        //             horizontal: false,
        //             columnWidth: '55%',
        //             endingShape: 'rounded'
        //         },
        //     },
        //     dataLabels: {
        //         enabled: false
        //     },
        //     stroke: {
        //         show: true,
        //         width: 2,
        //         colors: ['transparent']
        //     },
        //     xaxis: {
        //         categories: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8',
        //             'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'
        //         ],
        //     },
        //     yaxis: {
        //         title: {
        //             text: '(Triệu VNĐ)'
        //         }
        //     },
        //     fill: {
        //         opacity: 1
        //     },
        //     tooltip: {
        //         y: {
        //             formatter: function(val) {
        //                 return val + " Triệu VNĐ"
        //             }
        //         }
        //     }
        // };

        // var chart = new ApexCharts(document.querySelector("#chart"), options);
        // chart.render();
    </script>
    {{-- <script type="text/javascript">
//
</script> --}}
@endSection
{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}
