@extends('admin.common.layout')
@section('content')
<div class="page-body">
    <div class="container-xl">
        <div class="row">
        <div class="card">
            <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs nav-fill" data-bs-toggle="tabs" role="tablist">
                <li class="nav-item" role="presentation">
                <a href="#tabs-daily-5" class="nav-link active" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">Ngày hôm nay</a>
                </li>
                <li class="nav-item" role="presentation">
                <a href="#tabs-weekly-5" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">Tuần này</a>
                </li>
                <li class="nav-item" role="presentation">
                <a href="#tabs-monthly-5" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">Tháng này</a>
                </li>
                <li class="nav-item" role="presentation">
                <a href="#tabs-yearly-5" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">Năm này</a>
                </li>
            </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="tabs-daily-5" role="tabpanel">
                        <div class="row col-12">
                            <div class="col">
                                <div class="card border-0 shadow-lg rounded-4 p-4 pt-3">
                                    <h3>Tổng tiền đã thu được</h3>
                                    {{ money_format($data->today) }}
                                </div>
                            </div>
                            <div class="col">
                                <div class="card border-0 shadow-lg rounded-4 p-4 pt-3">
                                    <h3>Tổng số tour đã bán</h3>
                                    {{ $data->PPCToday }}
                                </div>
                            </div>
                        </div>
                        <div class="row col-12 mt-4">
                            <div class="col">
                                <div class="card border-0 shadow-lg rounded-4 p-4 pt-3">
                                    <h3>Tổng số đơn chờ duyệt</h3>
                                    {{ $data->UVCount }}
                            </div>
                            </div>
                            <div class="col">
                                <div class="card border-0 shadow-lg rounded-4 p-4 pt-3">
                                    <h3>Tổng số user</h3>
                                    {{ $data->userCount }}
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tabs-weekly-5" role="tabpanel">
                        <div class="row col-12">
                            <div class="col">
                                <div class="card border-0 shadow-lg rounded-4 p-4 pt-3">
                                    <h3>Tổng tiền đã thu được</h3>
                                    {{ money_format($data->week) }}
                                </div>
                            </div>
                            <div class="col">
                                <div class="card border-0 shadow-lg rounded-4 p-4 pt-3">
                                    <h3>Tổng số tour đã bán</h3>
                                    {{ $data->PPCWeek }}
                                </div>
                            </div>
                        </div>
                        <div class="row col-12 mt-4">
                            <div class="col">
                                <div class="card border-0 shadow-lg rounded-4 p-4 pt-3">
                                    <h3>Tổng số đơn chờ duyệt</h3>
                                    {{ $data->UVCount }}
                            </div>
                            </div>
                            <div class="col">
                                <div class="card border-0 shadow-lg rounded-4 p-4 pt-3">
                                    <h3>Tổng số user</h3>
                                    {{ $data->userCount }}
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tabs-monthly-5" role="tabpanel">
                        <div class="row col-12">
                            <div class="col">
                                <div class="card border-0 shadow-lg rounded-4 p-4 pt-3">
                                    <h3>Tổng tiền đã thu được</h3>
                                    {{ money_format($data->month) }}
                                </div>
                            </div>
                            <div class="col">
                                <div class="card border-0 shadow-lg rounded-4 p-4 pt-3">
                                    <h3>Tổng số tour đã bán</h3>
                                    {{ $data->PPCMonth }}
                                </div>
                            </div>
                        </div>
                        <div class="row col-12 mt-4">
                            <div class="col">
                                <div class="card border-0 shadow-lg rounded-4 p-4 pt-3">
                                    <h3>Tổng số đơn chờ duyệt</h3>
                                    {{ $data->UVCount }}
                            </div>
                            </div>
                            <div class="col">
                                <div class="card border-0 shadow-lg rounded-4 p-4 pt-3">
                                    <h3>Tổng số user</h3>
                                    {{ $data->userCount }}
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tabs-yearly-5" role="tabpanel">
                        <div class="row col-12">
                            <div class="col">
                                <div class="card border-0 shadow-lg rounded-4 p-4 pt-3">
                                    <h3>Tổng tiền đã thu được</h3>
                                    {{ money_format($data->year) }}
                                </div>
                            </div>
                            <div class="col">
                                <div class="card border-0 shadow-lg rounded-4 p-4 pt-3">
                                    <h3>Tổng số tour đã bán</h3>
                                    {{ $data->PPCYear }}
                                </div>
                            </div>
                        </div>
                        <div class="row col-12 mt-4">
                            <div class="col">
                                <div class="card border-0 shadow-lg rounded-4 p-4 pt-3">
                                    <h3>Tổng số đơn chờ duyệt</h3>
                                    {{ $data->UVCount }}
                            </div>
                            </div>
                            <div class="col">
                                <div class="card border-0 shadow-lg rounded-4 p-4 pt-3">
                                    <h3>Tổng số user</h3>
                                    {{ $data->userCount }}
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <div class="col-12 mt-4">
                <div class="card border-0 shadow-lg rounded-4 p-4 pt-3">
                    <h3>Chart</h3>
                    <div id="chart"  style="min-height: 365px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('page_js')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    var jsonData = @json($data);
    // console.log(jsonData);
    var options = {
          series: [{
          name: 'Net Profit',
          data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
        }, {
          name: 'Revenue',
          data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
        }, {
          name: 'Free Cash Flow',
          data: [35, 41, 36, 26, 45, 48, 52, 53, 41]
        }],
          chart: {
          type: 'bar',
          height: 350
        },
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '55%',
            endingShape: 'rounded'
          },
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          show: true,
          width: 2,
          colors: ['transparent']
        },
        xaxis: {
          categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
        },
        yaxis: {
          title: {
            text: '$ (thousands)'
          }
        },
        fill: {
          opacity: 1
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return "$ " + val + " thousands"
            }
          }
        }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
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
