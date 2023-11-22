@extends('admin.common.layout')
@section('meta_title')
Thống kê tour
@endSection
@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                @if($data->UVCount && $data->UVCount>0)
                <div class="row">
                    <div class="card border-0 bg-yellow shadow-lg  rounded-4 p-1 pt-3 mb-3">
                        <a class="nav-link text-center text-white" href="/purchase-history?purchase_status=2">
                        <h3>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-alert-triangle" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 9v4" />
                            <path d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z" />
                            <path d="M12 16h.01" />
                        </svg>
                        Có {{ $data->UVCount }} đơn chờ duyệt
                        </h3>
                        </a>
                    </div>
                </div>
                @endif
                <div class="card">
                    <div class="card-header">
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
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabs-daily-5" role="tabpanel">
                                <div class="row">
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
                            </div>
                            <div class="tab-pane" id="tabs-weekly-5" role="tabpanel">
                                <div class="row">
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
                            </div>
                            <div class="tab-pane" id="tabs-monthly-5" role="tabpanel">
                                <div class="row">
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
                            </div>
                            <div class="tab-pane" id="tabs-yearly-5" role="tabpanel">
                                <div class="row">
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
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row  shadow-lg rounded-4 p-4 pt-3 mt-4">
                    <div class="col-6 card border-0 shadow-lg rounded-4 p-4 pt-3">
                        <h3>5 Tour được chú ý nhất</h3>
                        <div id="chartpie"></div>
                    </div>
                    <div class="col-6 card border-0 shadow-lg rounded-4 p-4 pt-3">
                        <h3>5 Tour được đánh giá cao nhất</h3>
                        <div id="chartpie2"></div>
                    </div>
                </div>
                <div class="col-12 mt-4">
                    <div class="card border-0 shadow-lg rounded-4 p-4 pt-3">
                        <h3>Bảng thống kê so sánh tiền thu được hàng tháng</h3>
                        <div id="chart" style="min-height: 365px;"></div>
                    </div>
                </div>
            </div>

            {{-- Hiển thị chi tiết từ thông báo, vui lòng không xóa đi --}}
            <div class="modal modal-blur fade" id="modalContainer" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page_js')
    <script>
        // Apexjs tôi đã để bên javascript là js chung cho tất cả rồi nha, ông không cần gọi lại nó nữa đâu

        var chartPieInfo = @json($data).tourVC;
        // console.log(chartPieInfo);
        const nameList = Object.values(chartPieInfo).map(({
            name
        }) => name);
        const viewCountList = Object.values(chartPieInfo).map(({
            view_count
        }) => view_count);
        var options = {
            series: viewCountList,
            chart: {
                width: 600,
                type: 'pie',
            },
            labels: nameList,
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
        var chartPieInfo2 = @json($data).tourR;
        // console.log(chartPieInfo2);
        const nameList2 = Object.values(chartPieInfo2).map(({
            name,
            starCount
        }) => `${name} (${starCount} lượt đánh giá)`);
        const ratingList = Object.values(chartPieInfo2).map(({
            star
        }) => star);
        var options2 = {
            series: ratingList,
            chart: {
                width: 600,
                type: 'pie',
            },
            labels: nameList2,
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

        var chartInfo = @json($data).chart;
        // console.log(chartInfo);
        var options = {
            series: [{
                name: 'Số tiền thu được',
                data: chartInfo
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
                categories: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8',
                    'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'
                ],
            },
            yaxis: {
                title: {
                    text: '(Triệu VNĐ)'
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val + " Triệu VNĐ"
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
