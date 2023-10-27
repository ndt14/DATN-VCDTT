@extends('admin.common.layout')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col-12 ">
                    <!-- @if (Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="notiSuccess">
                                        {{ Session::get('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
    @endif
                                    @if (Session::has('fail'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="notiError">
                                        {{ Session::get('fail') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
    @endif -->
                </div>
                <div class="col">
                    <!-- Page pre-title -->
                    <!-- <div class="page-pretitle">
                                    Overview
                                </div> -->
                    <h1 class="text-primary mb-4" style="font-size: 36px;">
                        Quản lý hóa đơn
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ url('/purchase-history') }}" class="btn btn-default d-none d-sm-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-narrow-left"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M5 12l14 0"></path>
                                <path d="M5 12l4 4"></path>
                                <path d="M5 12l4 -4"></path>
                            </svg>
                            Back
                        </a>
                        <a href="{{ url('/purchase-history') }}" class="btn btn-default d-sm-none btn-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-narrow-left"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M5 12l14 0"></path>
                                <path d="M5 12l4 4"></path>
                                <path d="M5 12l4 -4"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-sm-12 col-md-8 offset-md-2">
                    <form id="frmEdit" class="card border-0 shadow-lg rounded-4 "
                        action="{{ route('api.purchase_histories.edit', ['id' => $items['id']]) }}" method="POST">
                        <div class="card-header">
                            <h2 class="card-title">
                                Edit {{ $items['name'] }}
                            </h2>
                        </div>
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <input type="hidden" name="update_admin" value="1">
                            <div class="row">
                                <div class="mb-3 col-9">
                                    <label class="form-label">Tên người dùng</label>
                                    <input type="text" name="name" class="form-control"
                                        placeholder="Nhập tên người dùng" value="{{ $items['name'] }}" disabled>
                                    <span class="text-danger d-flex justify-content-start">
                                        @error('name')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="mb-3 col-3">
                                    <label class="form-label">ID người dùng</label>
                                    <input type="text" name="user_id" class="form-control"
                                        placeholder="Nhập ID người dùng" value="{{ $items['user_id'] }}" disabled>
                                    <span class="text-danger d-flex justify-content-start">
                                        @error('user_id')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-4">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="main_img" class="form-control"
                                        placeholder="Email người đặt tour" value="{{ $items['email'] }}" disabled>
                                    <span class="text-danger d-flex justify-content-start">
                                        @error('email')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="mb-3 col-4">
                                    <label class="form-label">Số điện thoại</label>
                                    <input type="text" name="phone_number" class="form-control"
                                        placeholder="Nhập số điện thoại người đặt tour"
                                        value="{{ $items['phone_number'] }}" disabled>
                                    <span class="text-danger d-flex justify-content-start">
                                        @error('phone_number')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="mb-3 col-4">
                                    <div class="form-label">Giới tính</div>
                                    <select class="form-select" aria-label="Default select example" disabled>
                                        <option>-----Chọn giới tính-----</option>
                                        <option @if ($items['gender'] == 1) selected @endif value="1">Nam
                                        </option>
                                        <option @if ($items['gender'] == 2) selected @endif value="2">Nữ
                                        </option>
                                        <option @if ($items['gender'] == 3) selected @endif value="3">Không xác
                                            định</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-6">
                                    <div class="form-label">Tên tour</div>
                                    <input name="tour_name" type="text" placeholder="Nhập tên tour"
                                        class="form-control" value="{{ $items['tour_name'] }}" disabled>
                                    <span class="text-danger d-flex justify-content-start">
                                        @error('tour_name')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="mb-3 col-6">
                                    <div class="form-label">Độ dài tour</div>
                                    <input name="tour_duration" type="text" placeholder="Nhập độ dài tour"
                                        class="form-control" value="{{ $items['tour_duration'] }}" disabled>
                                    <span class="text-danger d-flex justify-content-start">
                                        @error('tour_duration')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-3 col-3">
                                    <div class="form-label">Số trẻ em</div>
                                    <input name="child_count" type="text" placeholder="Nhập số trẻ em"
                                        class="form-control" value="{{ $items['child_count'] }}" disabled>
                                    <span class="text-danger d-flex justify-content-start">
                                        @error('child_count')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="mb-3 col-3">
                                    <div class="form-label">Giá trẻ em</div>
                                    <input name="tour_child_price" type="text" placeholder="Nhập giá cho trẻ nhỏ"
                                        class="form-control" value="{{ $items['tour_child_price'] }}" disabled>
                                    <span class="text-danger d-flex justify-content-start">
                                        @error('tour_child_price')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="mb-3 col-3">
                                    <div class="form-label">Số người lớn</div>
                                    <input name="adult_count" type="text" placeholder="Nhập số người lớn"
                                        class="form-control" value="{{ $items['adult_count'] }}" disabled>
                                    <span class="text-danger d-flex justify-content-start">
                                        @error('adult_count')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="mb-3 col-3">
                                    <div class="form-label">Giá người lớn</div>
                                    <input name="tour_adult_price" type="text" placeholder="Nhập giá cho người lớn"
                                        class="form-control" value="{{ $items['tour_adult_price'] }}" disabled>
                                    <span class="text-danger d-flex justify-content-start">
                                        @error('tour_adult_price')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-3 col-6">
                                    <div class="form-label">Điểm bắt đầu</div>
                                    <input name="tour_start_destination" type="text"
                                        placeholder="Nhập điểm khởi hành tour" class="form-control"
                                        value="{{ $items['tour_start_destination'] }}" disabled>
                                    <span class="text-danger d-flex justify-content-start">
                                        @error('tour_start_destination')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="mb-3 col-6">
                                    <div class="form-label">Điểm kết thúc</div>
                                    <input name="tour_end_destination" type="text"
                                        placeholder="Nhập điểm kết thúc tour" class="form-control"
                                        value="{{ $items['tour_end_destination'] }}" disabled>
                                    <span class="text-danger d-flex justify-content-start">
                                        @error('tour_end_destination')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-3 ">
                                    <div class="form-label">Vị trí tour</div>
                                    <input name="tour_location" type="text" class="form-control"
                                        placeholder="Nhập vị trí của tour" value="{{ $items['tour_location'] }}"
                                        disabled>
                                    <span class="text-danger d-flex justify-content-start">
                                        @error('tour_location')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-3 col-3">
                                    <div class="form-label">Tour đang giảm giá (%)</div>
                                    <input name="tour_sale_percentage" type="text" class="form-control"
                                        placeholder="Nhập phần trăm giảm giá của tour"
                                        value="{{ $items['tour_sale_percentage'] }}" disabled>
                                    <span class="text-danger d-flex justify-content-start">
                                        @error('tour_sale_percentage')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="mb-3 col-3">
                                    <div class="form-label">Mã giảm giá</div>
                                    <input name="coupon_name" type="text" class="form-control"
                                        placeholder="Nhập mã giảm giá" value="{{ $items['coupon_name'] }}" disabled>
                                    <span class="text-danger d-flex justify-content-start">
                                        @error('coupon_name')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="mb-3 col-3">
                                    <div class="form-label">Phần trăm giảm giá</div>
                                    <input name="coupon_percentage" type="text" class="form-control"
                                        placeholder="Nhập phần trăm giảm giá của mã giảm giá"
                                        value="{{ $items['coupon_percentage'] }}" disabled>
                                    <span class="text-danger d-flex justify-content-start">
                                        @error('coupon_percentage')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="mb-3 col-3">
                                    <div class="form-label">Số tiền được giảm trực tiếp</div>
                                    <input name="coupon_fixed" type="text" class="form-control"
                                        placeholder="Nhập phần trăm giảm giá của mã giảm giá"
                                        value="{{ $items['coupon_fixed'] }}" disabled>
                                    <span class="text-danger d-flex justify-content-start">
                                        @error('coupon_fixed')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-3 ">
                                    <div class="form-label">Phần trăm hoàn tiền</div>
                                    <input name="refund_percentage" type="text" class="form-control"
                                        placeholder="Nhập vị trí của tour" value="{{ $items['refund_percentage'] }}"
                                        disabled>
                                    <span class="text-danger d-flex justify-content-start">
                                        @error('refund_percentage')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-label">Góp ý của khách hàng</div>
                                <textarea id="editor" rows="6" class="form-control text-editor ckeditor" name="suggestion"
                                    placeholder="Nhập nội dung mô tả" disabled>{{ $items['suggestion'] }}</textarea>
                                <span class="text-danger d-flex justify-content-start">
                                    @error('suggestion')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="row">
                                <div class="mb-3 col-6">
                                    <div class="form-label">Thời gian bắt đầu</div>
                                    <input name="tour_start_time" type="text" placeholder="Nhập điểm khởi hành tour"
                                        class="form-control" value="{{ $items['tour_start_time'] }}" disabled>
                                    <span class="text-danger d-flex justify-content-start">
                                        @error('tour_start_time')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="mb-3 col-6">
                                    <div class="form-label">Thời gian kết thúc</div>
                                    <input name="tour_end_time" type="text" placeholder="Nhập điểm kết thúc tour"
                                        class="form-control" value="{{ $items['tour_end_time'] }}" disabled>
                                    <span class="text-danger d-flex justify-content-start">
                                        @error('tour_end_time')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-label">Trạng thái thanh toán</div>
                                <div class="custom-controls-stacked">
                                    <label class="custom-control custom-radio custom-control-inline me-2">
                                        <input type="radio" class="custom-control-input"
                                            @if ($items['payment_status'] == '1') checked @endif name="payment_status"
                                            value="1" disabled>
                                        <span class="custom-control-label">Đã thanh toán</span>
                                    </label>
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input"
                                            @if ($items['payment_status'] == '0') checked @endif name="payment_status"
                                            value="0" disabled>
                                        <span class="custom-control-label">Chưa thanh toán</span>
                                    </label>

                                    <span class="text-danger d-flex justify-content-start">
                                        @error('payment_status')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-label">Trạng thái mua hàng</div>
                                <select name="purchase_status" class="form-select" aria-label="Default select example">
                                    <option>-----Trạng thái-----</option>
                                    <option @if ($items['purchase_status'] == 0) selected @endif value="0">Chưa thanh
                                        toán
                                    </option>
                                    <option @if ($items['purchase_status'] == 1) selected @endif value="1">Đang đợi xác
                                        nhận
                                    </option>
                                    <option @if ($items['purchase_status'] == 2) selected @endif value="2">Chưa tới ngày
                                        đi
                                    </option>
                                    <option @if ($items['purchase_status'] == 3) selected @endif value="3">Tour đang
                                        diễn ra
                                    </option>
                                    <option @if ($items['purchase_status'] == 4) selected @endif value="4">Người dùng đã
                                        hủy
                                    </option>
                                    <option @if ($items['purchase_status'] == 5) selected @endif value="5">Admin đã hủy
                                        tour
                                    </option>
                                    <option @if ($items['purchase_status'] == 6) selected @endif value="6">Tự động hủy
                                        do quá hạn
                                    </option>
                                </select>
                            </div>

                        </div>
                        <div class="card-footer text-center">
                            <button id="btnSubmitEdit" type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page_js')
    <script type="text/javascript">
        if ($('#frmEdit').length) {
            $('#frmEdit').submit(function() {
                let options = {
                    beforeSubmit: function(formData, jqForm, options) {
                        $('#btnSubmitEdit').addClass('btn-loading');
                        $('#btnSubmitEdit').addClass("disabled");
                    },
                    success: function(response, statusText, xhr, $form) {
                        $('#btnSubmitEdit').removeClass('btn-loading');
                        if (response.status == 404) {
                            $('#btnSubmitEdit').removeClass("disabled");
                            bs5Utils.Snack.show('danger', response.message, delay = 5000, dismissible =
                                true);
                        }
                        if (response.status == 200) {
                            $('#btnSubmitEdit').removeClass("disabled");
                            bs5Utils.Snack.show('success', response.message, delay = 6000, dismissible =
                                true);
                        }
                    },
                    error: function() {
                        $('#btnSubmitEdit').removeClass('btn-loading');
                        $('#btnSubmitEdit').removeClass("disabled");
                        bs5Utils.Snack.show('danger', 'Error, please check your input', delay = 5000,
                            dismissible = true);
                    },
                    dataType: 'json',
                    clearForm: false,
                    resetForm: false
                };
                $(this).ajaxSubmit(options);
                return false;
            });
        }
    </script>
@endSection
