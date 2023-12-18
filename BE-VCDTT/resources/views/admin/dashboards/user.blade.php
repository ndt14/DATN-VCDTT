@extends('admin.common.layout')
@section('meta_title')
    Thống kê người dùng
@endSection
@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabs-daily-5" role="tabpanel">
                                <div class="row">
                                    <div class="col">
                                        <div class="card border-0 shadow-lg rounded-4 p-4 pt-3">
                                            <h3>Số người dùng đã đăng ký tài khoản</h3>
                                            {{ $data->userCount }}
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card border-0 shadow-lg rounded-4 p-4 pt-3">
                                            <h3>Số người đã sử dụng dịch vụ chưa đăng ký tài khoản</h3>
                                            {{ $data->notRegCount }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row shadow-lg rounded-4 p-4 pt-3 mt-4">
                <div class="col">
                    <div class="card border-0 shadow-lg rounded-4 p-4 pt-3">
                        <h3>Giới tính người dùng sử dụng web</h3>
                        @if ($data->genderDP == [0, 0, 0])
                            <p class="text-orange">Có vẻ chưa người dùng nào nhập đủ thông tin cho hệ thống.</p>
                        @else
                            <div id="chartpie"></div>
                        @endif
                    </div>
                </div>
                <div class="col">
                    <div class="card border-0 shadow-lg rounded-4 p-4 pt-3">
                        <h3>Độ tuổi người dùng sử dụng web</h3>
                        @php
                            $ageDP = $data->ageDP;
                            $allZero = true;
                            foreach ($ageDP as $value) {
                                if ($value != 0) {
                                    $allZero = false;
                                    break;
                                }
                            }
                        @endphp
                        @if ($allZero)
                            <p class="text-orange">Có vẻ chưa người dùng nào nhập đủ thông tin cho hệ thống.</p>
                        @else
                            <div id="chartpie2"></div>
                        @endif
                    </div>
                </div>
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
        var chartPieInfo = @json($data).genderDP;
        // console.log(chartPieInfo);
        var options = {
            series: chartPieInfo,
            chart: {
                height: 300,
                type: 'pie',
            },
            labels: ['Nam', 'Nữ', 'Khác'],
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
                height: 300,
                type: 'pie',
            },
            labels: keyschart2,
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
