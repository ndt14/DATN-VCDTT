<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="{{ asset('ckeditor-5/ckeditor.js') }}"></script>
    <script src="{{ asset('ckfinder/ckfinder.js') }}"></script>
    @include('admin.common.css')
    @yield('header_js')
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }
    </style>
    @yield('page_css')
    @yield('select2_css')
</head>

<body class="layout-fluid">
    <script src="{{ asset('admin/assets/js/demo-theme.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            document.getElementById('modalContainer').show();
        });
    </script>
    <div >
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" style="padding-left: 0">
                    <h1>Hóa đơn</h1>
                </div>
                <div class="modal-body row row-deck row-cards">
                    <div class="col-sm-12 col-md-12" style="height: 60rem;">
                        <div class="card-body card-body-scrollable">
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <div class="form-label">Trạng thái thanh toán</div>
                                    <div class="custom-controls-stacked">
                                        @switch ($item['payment_status'])
                                            @case(1)
                                                <span class="badge bg-red-lt">Chưa thanh toán</span>
                                            @break

                                            @case(2)
                                                <span class="badge bg-green-lt">Đã thanh toán</span>
                                            @break
                                        @endswitch
                                    </div>
                                </div>
                                <div class="col-4 mb-3">
                                    <div class="form-label">Trạng thái dơn hàng</div>
                                    @switch($item['purchase_status'])
                                        @case(1)
                                            <span class="badge bg-muted-lt">Tự động hủy do quá hạn</span>
                                        @break

                                        @case(2)
                                            <span class="badge bg-orange-lt">Chưa phê duyệt thanh toán</span>
                                        @break

                                        @case(3)
                                            <span class="badge bg-green-lt">Đã phê duyệt thanh toán</span>
                                        @break

                                        @case(4)
                                            <span class="badge bg-orange-lt">Đang muốn hủy tour</span>
                                        @break

                                        @case(5)
                                            <span class="badge bg-red-lt">Đã phê duyệt hủy tour, chưa hoàn
                                                tiền</span>
                                        @break

                                        @case(6)
                                            <span class="badge bg-green-lt">Đã hủy thành công @if ($item['payment_status'] == 1)
                                                    (đã hoàn tiền)
                                                @endif </span>
                                        @break

                                        @case(7)
                                            <span class="badge bg-orange-lt">Chuyển khoản thiếu</span>
                                        @break

                                        @case(8)
                                            <span class="badge bg-orange-lt">Chuyển khoản thừa</span>
                                        @break

                                        @default
                                        @break

                                    @endswitch
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <div class="form-label">Trạng thái tour</div>
                                    <div class="custom-controls-stacked">
                                        @switch($item['tour_status'])
                                            @case(1)
                                                <span class="badge bg-muted-lt">Chưa tới ngày đi</span>
                                            @break

                                            @case(2)
                                                <span class="badge bg-green-lt">Đang diễn ra</span>
                                            @break

                                            @case(3)
                                                <span class="badge bg-light-lt">Đã kết thúc</span>
                                            @break

                                            @case(4)
                                                <span class="badge bg-orange-lt">Còn 1 ngày tới ngày đi tour</span>
                                            @break

                                            @default
                                            @break
                                        @endswitch
                                    </div>
                                </div>
                            </div>
                            <hr class="my-3">
                            <div class="row">
                                <div class="col-auto">
                                    <label class="form-label">Tên người dùng</label>
                                    <h3>{{ $item['name'] }}</h3>
                                </div>
                                <div class="col-auto px-3">
                                    <label class="form-label">ID người dùng</label>
                                    {{ $item['user_id'] }}
                                </div>
                                <div class="col-auto px-3">
                                    <label class="form-label">Email</label>
                                    {{ $item['email'] }}
                                </div>
                                <div class="col-auto px-3">
                                    <label class="form-label">Số điện thoại</label>
                                    {{ $item['phone_number'] }}

                                </div>
                                <div class="col-auto px-3">
                                    <div class="form-label">Giới tính</div>
                                    @switch ($item['gender'])
                                        @case(0)
                                            Nam
                                        @break

                                        @case(1)
                                            Nữ
                                        @break

                                        @case(2)
                                            Không xác định
                                        @break
                                    @endswitch
                                </div>
                            </div>
                            <hr class="my-3">
                            <div class="row">
                                <div class="col-9">
                                    <div class="form-label">Tên tour</div>
                                    {{ $item['tour_name'] }}
                                </div>
                                <div class="col-3">
                                    <div class="form-label">Độ dài tour</div>
                                    {{ $item['tour_duration'] }}
                                </div>
                            </div>
                            <hr class="my-3">
                            <div class="row">
                                <div class="col-3">
                                    <div class="form-label">Số trẻ em</div>
                                    {{ $item['child_count'] }}
                                </div>
                                <div class="col-3">
                                    <div class="form-label">Giá trẻ em</div>
                                    {{ $item['tour_child_price'] }}
                                </div>
                                <div class="col-3">
                                    <div class="form-label">Số người lớn</div>
                                    {{ $item['adult_count'] }}
                                </div>
                                <div class="col-3">
                                    <div class="form-label">Giá người lớn</div>
                                    {{ $item['tour_adult_price'] }}
                                </div>
                            </div>
                            <hr class="my-3">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-label">Điểm bắt đầu</div>
                                    {{ $item['tour_start_destination'] }}
                                </div>
                                <div class="col-6">
                                    <div class="form-label">Điểm kết thúc</div>
                                    {{ $item['tour_end_destination'] }}
                                </div>
                            </div>
                            <hr class="my-3">
                            <div class="row">
                                <div class="">
                                    <div class="form-label">Vị trí tour</div>
                                    {{ $item['tour_location'] }}
                                </div>
                            </div>
                            <hr class="my-3">
                            <div class="row">
                                <div class="col-3">
                                    <div class="form-label">Tour giảm giá (%)</div>
                                    {{ $item['tour_sale_percentage'] }}
                                </div>
                                <div class="col-3">
                                    <div class="form-label">Mã giảm giá</div>
                                    {{ $item['coupon_name'] }}
                                </div>
                                <div class="col-3">
                                    <div class="form-label">Phần trăm giảm giá</div>
                                    {{ $item['coupon_percentage'] }}
                                </div>
                                <div class="col-3">
                                    <div class="form-label">Số tiền giảm trực tiếp</div>
                                    {{ $item['coupon_fixed'] }}
                                </div>
                            </div>
                            <hr class="my-3">
                            <div class="row">
                                <div class="col-3">
                                    <div class="form-label">Phần trăm hoàn tiền</div>
                                    {{ $item['refund_percentage'] }}
                                </div>


                                <div class="col-9">
                                    <div class="form-label">Góp ý của khách hàng</div>
                                    {{ $item['suggestion'] }}
                                </div>
                            </div>
                            <hr class="my-3">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-label">Thời gian bắt đầu</div>
                                    {{ $item['tour_start_time'] }}
                                </div>
                                <div class="col-6">
                                    <div class="form-label">Thời gian kết thúc</div>
                                    {{ $item['tour_end_time'] }}
                                </div>
                            </div>
                            <hr class="my-3">
                            <div class="row">
                                <div class="card-body-scrollable" style="max-height: 20rem;">
                                    <div class="form-label">Chính sách và điều khoản đã đồng ý</div>
                                    <div>
                                        {!! $item['payment_term'] !!}
                                    </div>
                                </div>
                                <div class="card-body-scrollable" style="max-height: 20rem;">
                                    <div class="markdown">
                                        {!! $item['payment_privacy'] !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.common.javascript')
    @yield('page_js')
    @yield('select2_js')
    @yield('ckeditor_5')
</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>

</html>
