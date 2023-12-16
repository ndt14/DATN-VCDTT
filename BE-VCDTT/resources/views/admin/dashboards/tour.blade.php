@extends('admin.common.layout')
@section('meta_title')
    Thống kê tour
@endSection
@section('db_css')
    <style>
        .custom-card {
            border: 1px solid #3498db;
            /* Màu xanh dương */
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            color: black;
            /* Màu trắng cho văn bản */
            position: relative;
            /* Đặt vị trí tương đối để có thể sử dụng vị trí tuyệt đối cho phần tử con */
        }

        .status-dots {
            position: absolute;
            /* Đặt vị trí tuyệt đối để có thể đặt vị trí */
            top: 10px;
            /* Điều chỉnh vị trí từ trên xuống */
            right: 10px;
            /* Điều chỉnh vị trí từ phải sang trái */
        }

        .status-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-left: 4px;
            /* Khoảng cách giữa hai ô tròn */
        }

        .status-dot-green {
            background-color: #2ecc71;
            /* Màu xanh lá */
        }

        .status-dot-green:hover {
            cursor: pointer;
            /* Màu xanh lá */
        }

        .status-dot-gray {
            background-color: #7f8c8d;
            /* Màu xám */
        }

        .status-dot-gray:hover {
            cursor: pointer;
            /* Màu xám */
        }
    </style>
@endsection
@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards g-3">
                @if ($data->UVCount && $data->UVCount > 0)
                    <div class="col-12">
                        <div class="card border-0 bg-yellow shadow-lg  rounded-4 p-1 pt-3 mb-3">
                            <a class="nav-link text-center text-white" href="/purchase-history?purchase_status=2">
                                <h3>
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-alert-triangle" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 9v4" />
                                        <path
                                            d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0z" />
                                        <path d="M12 16h.01" />
                                    </svg>
                                    Có {{ $data->UVCount }} đơn chờ duyệt
                                </h3>
                            </a>
                        </div>
                    </div>
                @endif
                <div class="card border-0 rounded-4 mb-4 col-12">
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
                                        <div class="card rounded-4 p-4 pt-3">
                                            <h3>Tổng tiền đã thu được</h3>
                                            {{ money_format($data->today) }}
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card rounded-4 p-4 pt-3">
                                            <h3>Tổng số tour đã bán</h3>
                                            {{ $data->PPCToday }}
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card rounded-4 p-4 pt-3">
                                            <h3>Tổng số tour đã bán</h3>
                                            {{ $data->PPCToday }}
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card rounded-4 p-4 pt-3">
                                            <h3>Tổng số tour đã bán</h3>
                                            {{ $data->PPCToday }}
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card rounded-4 p-4 pt-3">
                                            <h3>Tổng số tour đã bán</h3>
                                            {{ $data->PPCToday }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabs-weekly-5" role="tabpanel">
                                <div class="row">
                                    <div class="col">
                                        <div class="card rounded-4 p-4 pt-3">
                                            <h3>Tổng tiền đã thu được</h3>
                                            {{ money_format($data->week) }}
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card rounded-4 p-4 pt-3">
                                            <h3>Tổng số tour đã bán</h3>
                                            {{ $data->PPCWeek }}
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card rounded-4 p-4 pt-3">
                                            <h3>Tổng số tour đã bán</h3>
                                            {{ $data->PPCWeek }}
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card rounded-4 p-4 pt-3">
                                            <h3>Tổng số tour đã bán</h3>
                                            {{ $data->PPCWeek }}
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card rounded-4 p-4 pt-3">
                                            <h3>Tổng số tour đã bán</h3>
                                            {{ $data->PPCWeek }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabs-monthly-5" role="tabpanel">
                                <div class="row">
                                    <div class="col">
                                        <div class="card rounded-4 p-4 pt-3">
                                            <h3>Tổng tiền đã thu được</h3>
                                            {{ money_format($data->month) }}
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card rounded-4 p-4 pt-3">
                                            <h3>Tổng số tour đã bán</h3>
                                            {{ $data->PPCMonth }}
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card rounded-4 p-4 pt-3">
                                            <h3>Tổng số tour đã bán</h3>
                                            {{ $data->PPCMonth }}
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card rounded-4 p-4 pt-3">
                                            <h3>Tổng số tour đã bán</h3>
                                            {{ $data->PPCMonth }}
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card rounded-4 p-4 pt-3">
                                            <h3>Tổng số tour đã bán</h3>
                                            {{ $data->PPCMonth }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabs-yearly-5" role="tabpanel">
                                <div class="row">
                                    <div class="col">
                                        <div class="card rounded-4 p-4 pt-3">
                                            <h3>Tổng tiền đã thu được</h3>
                                            {{ money_format($data->year) }}
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card rounded-4 p-4 pt-3">
                                            <h3>Tổng số tour đã bán</h3>
                                            {{ $data->PPCYear }}
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card rounded-4 p-4 pt-3">
                                            <h3>Tổng số tour đã bán</h3>
                                            {{ $data->PPCYear }}
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card rounded-4 p-4 pt-3">
                                            <h3>Tổng số tour đã bán</h3>
                                            {{ $data->PPCYear }}
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card rounded-4 p-4 pt-3">
                                            <h3>Tổng số tour đã bán</h3>
                                            {{ $data->PPCYear }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--- thêm mới  !-->
                <div class="card border-0 rounded-4 mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3">
                                <div class="card rounded-4 p-4 pt-3 custom-card">
                                    <h3>Tổng tất cả tiền</h3>
                                    <p>{{ money_format($data->total_total) }}</p>
                                </div>
                            </div>

                            <div class="col-3">
                                <div class="card rounded-4 p-4 pt-3 custom-card">
                                    <h3>Tổng số thành viên</h3>
                                    <p class="show_num_user">{{ $data->users }}</p>
                                    <!-- Phần tử chứa cả hai ô tròn -->
                                    <div class="status-dots">
                                        <!-- Ô tròn xanh -->
                                        <div class="status-dot status-dot-green btnActive" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Đang hoạt động"></div>
                                        <!-- Ô tròn xám -->
                                        <div class="status-dot status-dot-gray btnUnActive" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Không hoạt động"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-3">
                                <div class="card rounded-4 p-4 pt-3 custom-card">
                                    <h3>Tổng số bài viết</h3>
                                    <p class="show_num_blog">{{ $data->blogs }}</p>
                                    <!-- Phần tử chứa cả hai ô tròn -->
                                    <div class="status-dots">
                                        <!-- Ô tròn xanh -->
                                        <div class="status-dot status-dot-green btnActive2" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Đang hoạt động"></div>
                                        <!-- Ô tròn xám -->
                                        <div class="status-dot status-dot-gray btnUnActive2" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Không hoạt động"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-3">
                                <div class="card rounded-4 p-4 pt-3 custom-card">
                                    <h3>Tổng số lượt truy cập</h3>
                                    <p>{{ $data->totalViews->totalViews }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--- end !--->
                <div class="row">
                    <div class="card border-0 rounded-4 mb-4 p-4 col-lg me-lg-4">
                        <h3>5 Tour được chú ý nhất</h3>
                        @if ($data->tourVC == [])
                            <p class="text-orange">Có vẻ chưa có ai xem tour nào cả.</p>
                        @else
                            <div id="chartTop5ToursRemarkable"></div>
                        @endif
                    </div>
                    <div class="card border-0 rounded-4 mb-4 p-4 col-lg">
                        <h3>5 Tour được đánh giá cao nhất</h3>
                        @if ($data->tourR == [])
                            <p class="text-orange">Có vẻ chưa có đánh giá cho tour nào cả.</p>
                        @else
                            <div id="chartTop5RatedTours"></div>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="card border-0 rounded-4 mb-4 p-4 col-lg me-lg-4">
                        <h3>5 tour có doanh số cao nhất</h3>
                        <div id="chartTourSale" style="min-height: 365px;"></div>
                    </div>
                    <div class="card border-0 rounded-4 mb-4 p-4 col-lg">
                        <h3>Số lượt truy cập theo ngày</h3>
                        <div id="chartPageViewsByDay" style="min-height: 365px;"></div>
                    </div>
                </div>
                <div class="card border-0 rounded-4 mb-4 p-4 pt-3">
                    <h3>Bảng thống kê so sánh tiền thu được hàng tháng</h3>
                    <div id="chart" style="min-height: 365px;"></div>
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
        var btnActive = document.querySelector('.btnActive');
        var btnUnActive = document.querySelector('.btnUnActive');

        btnActive.addEventListener('click', () => {
            var data = {
                status: 1
            };
            $.ajax({
                url: "{{ route('dashboard.user.getData') }}",
                type: 'GET',
                data: data,
                success: function(response) {
                    var show = document.querySelector(".show_num_user");
                    show.innerHTML = response + " (hoạt động)";
                },
                error: function(e) {
                    console.log(e);
                }

            })

        })

        btnUnActive.addEventListener('click', () => {
            var data = {
                status: 'other'
            };
            $.ajax({
                url: "{{ route('dashboard.user.getData') }}",
                type: 'GET',
                data: data,
                success: function(response) {
                    var show = document.querySelector(".show_num_user");
                    show.innerHTML = response + " (không hoạt động)";
                },
                error: function(e) {
                    console.log(e);
                }

            })

        })
    </script>

    <script>
        var btnActive2 = document.querySelector('.btnActive2');
        var btnUnActive2 = document.querySelector('.btnUnActive2');

        btnActive2.addEventListener('click', () => {
            var data = {
                status: 1
            };
            $.ajax({
                url: "{{ route('dashboard.blog.getData') }}",
                type: 'GET',
                data: data,
                success: function(response) {
                    var show = document.querySelector(".show_num_blog");
                    show.innerHTML = response + " (hoạt động)";
                },
                error: function(e) {
                    console.log(e);
                }

            })

        })

        btnUnActive2.addEventListener('click', () => {
            var data = {
                status: 'other'
            };
            $.ajax({
                url: "{{ route('dashboard.blog.getData') }}",
                type: 'GET',
                data: data,
                success: function(response) {
                    var show = document.querySelector(".show_num_blog");
                    show.innerHTML = response + " (không hoạt động)";
                },
                error: function(e) {
                    console.log(e);
                }
            })
        })
    </script>
    <script>
        // Apexjs tôi đã để bên javascript là js chung cho tất cả rồi nha, ông không cần gọi lại nó nữa đâu

        // //chartPie 1
        // var chartPieInfo = @json($data).tourVC;
        // console.log(chartPieInfo);
        // const nameList = Object.values(chartPieInfo).map(({
        //     name
        // }) => name);
        // const viewCountList = Object.values(chartPieInfo).map(({
        //     view_count
        // }) => view_count);
        // console.log(nameList);
        // console.log(viewCountList);
        // var options = {
        //     series: viewCountList,
        //     chart: {
        //         height: 300,
        //         type: 'pie',
        //     },
        //     labels: nameList,
        //     responsive: [{
        //         breakpoint: 200,
        //         options: {
        //             chart: {
        //                 width: 200
        //             },
        //             legend: {
        //                 position: 'bottom'
        //             }
        //         }
        //     }]
        // };
        // var chartpie = new ApexCharts(document.querySelector("#chartpie"), options);
        // chartpie.render();

        // //chartPie2
        // var chartPieInfo2 = @json($data).tourR;
        // console.log(chartPieInfo2);
        // const nameList2 = Object.values(chartPieInfo2).map(({
        //     name,
        //     starCount
        // }) => `${name} (${starCount} lượt đánh giá)`);
        // const ratingList = Object.values(chartPieInfo2).map(({
        //     star
        // }) => star);
        // var options2 = {
        //     series: ratingList,
        //     chart: {
        //         height: 300,
        //         type: 'pie',
        //     },
        //     labels: nameList2,
        //     responsive: [{
        //         breakpoint: 200,
        //         options: {
        //             chart: {
        //                 width: 200
        //             },
        //             legend: {
        //                 position: 'bottom'
        //             }
        //         }
        //     }]
        // };
        // var chartpie2 = new ApexCharts(document.querySelector("#chartpie2"), options2);
        // chartpie2.render();

        //chartiInfo
        var chartInfo = @json($data).chart;
        // console.log(chartInfo);
        var options = {
            series: [{
                name: 'Số tiền thu được',
                data: chartInfo.map(function(value) {
                    return value.toFixed(2)
                })
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
            },
        };
        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();

        //chartTourSale
        var chartTop5ToursBySale = @json($data).chartTop5ToursBySale;
        var chartNameTop5ToursBySale = chartTop5ToursBySale.map(item => item.name);
        var chartPriceTop5ToursBySale = chartTop5ToursBySale.map(item => item.total_tour_price);
        var options = {
            series: [{
                name: 'Số tiền thu được từ tour',
                data: chartPriceTop5ToursBySale
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
                categories: chartNameTop5ToursBySale
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
            },
            colors: [
                function({
                    value,
                    seriesIndex,
                    dataPointIndex,
                    w
                }) {
                    switch (dataPointIndex) {
                        case 0:
                            return '#267EC3';
                        case 1:
                            return '#26D467';
                        case 2:
                            return '#A2E526';
                        case 3:
                            return '#A02A24';
                        case 4:
                            return '#AB7DBE';
                        default:
                            return 0;
                    }
                }
            ]
        };
        var chart = new ApexCharts(document.querySelector("#chartTourSale"), options);
        chart.render();

        //chartTop5ToursRemarkable
        var chartTop5ToursRemarkable = @json($data).tourVC;
        var chartNameTop5ToursRemarkable = chartTop5ToursRemarkable.map(item => item.name);
        var chartVCTop5ToursRemarkable = chartTop5ToursRemarkable.map(item => item.view_count);

        var options = {
            series: [{
                data: chartVCTop5ToursRemarkable,
                name: "Số lượt xem"
            }],
            chart: {
                type: 'bar',
                height: 350
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    horizontal: true,
                }
            },
            dataLabels: {
                enabled: false
            },
            xaxis: {
                categories: chartNameTop5ToursRemarkable
            },
            colors: [
                function({
                    value,
                    seriesIndex,
                    dataPointIndex,
                    w
                }) {
                    switch (dataPointIndex) {
                        case 0:
                            return '#267EC3';
                        case 1:
                            return '#26D467';
                        case 2:
                            return '#A2E526';
                        case 3:
                            return '#A02A24';
                        case 4:
                            return '#AB7DBE';
                        default:
                            return 0;
                    }
                }
            ]
        };

        var chart = new ApexCharts(document.querySelector("#chartTop5ToursRemarkable"), options);
        chart.render();

        //chartTop5RatedTours
        var chartTop5RatedTours = @json($data).tourR;
        const chartTop5RatedToursArray = Object.keys(chartTop5RatedTours).map(key => chartTop5RatedTours[key]);
        chartTop5RatedToursArray.sort((a, b) => b.star - a.star);

        var chartNameTop5RatedTours = chartTop5RatedToursArray.map(item => item.name);
        var chartRatingTop5RatedTours = chartTop5RatedToursArray.map(item => item.star);
        var options = {
            series: [{
                data: chartRatingTop5RatedTours,
                name: "Trung bình đánh giá",
            }],
            chart: {
                type: 'bar',
                height: 350,
                colors: ['#F44336']
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    horizontal: true,
                }
            },
            dataLabels: {
                enabled: false
            },
            xaxis: {
                categories: chartNameTop5RatedTours
            },
            colors: [
                function({
                    value,
                    seriesIndex,
                    dataPointIndex,
                    w
                }) {
                    switch (dataPointIndex) {
                        case 0:
                            return '#267EC3';
                        case 1:
                            return '#26D467';
                        case 2:
                            return '#A2E526';
                        case 3:
                            return '#A02A24';
                        case 4:
                            return '#AB7DBE';
                        default:
                            return 0;
                    }
                }
            ]
        };

        var chart = new ApexCharts(document.querySelector("#chartTop5RatedTours"), options);
        chart.render();

        //chartPageViewsByDay
        var chartPageViewsByDay = @json($data).totalViews;
        // console.log(chartPageViewsByDay);
        var chartPageViewsByDayArray = Object.values(chartPageViewsByDay);

        const today = new Date();
        const yesterday = new Date();
        const dayBeforeYesterday = new Date();
        const threeDaysBeforeYesterday = new Date();
        const fourDaysBeforeYesterday = new Date();
        const fiveDaysBeforeYesterday = new Date();
        const sixDaysBeforeYesterday = new Date();

        // Ngày hôm nay
        const todayString = today.toLocaleDateString();

        // Ngày hôm qua
        yesterday.setDate(today.getDate() - 1);
        const yesterdayString = yesterday.toLocaleDateString();

        // Ngày hôm kia
        dayBeforeYesterday.setDate(today.getDate() - 2);
        const dayBeforeTodayString = dayBeforeYesterday.toLocaleDateString();

        // 3 ngày trước
        dayBeforeYesterday.setDate(today.getDate() - 3);
        const threeDaysBeforeTodayString = dayBeforeYesterday.toLocaleDateString();

        // 4 ngày trước
        dayBeforeYesterday.setDate(today.getDate() - 4);
        const fourDaysBeforeTodayString = dayBeforeYesterday.toLocaleDateString();

        // 5 ngày trước
        dayBeforeYesterday.setDate(today.getDate() - 5);
        const fiveDaysBeforeTodayString = dayBeforeYesterday.toLocaleDateString();

        // 6 ngày trước
        dayBeforeYesterday.setDate(today.getDate() - 6);
        const sixDaysBeforeTodayString = dayBeforeYesterday.toLocaleDateString();
        console.log(sixDaysBeforeTodayString)

        var options = {
            series: [{
                name: "Lượt truy cập",
                data: chartPageViewsByDayArray
            }],
            chart: {
                height: 350,
                type: 'line',
                zoom: {
                    enabled: false
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'straight'
            },
            grid: {
                row: {
                    colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                    opacity: 0.5
                },
            },
            xaxis: {
                categories: [sixDaysBeforeTodayString, fiveDaysBeforeTodayString, fourDaysBeforeTodayString,
                    threeDaysBeforeTodayString, dayBeforeTodayString, yesterdayString, todayString,
                ],
            }
        };

        var chart = new ApexCharts(document.querySelector("#chartPageViewsByDay"), options);
        chart.render();
    </script>
@endSection
