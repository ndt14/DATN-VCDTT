@extends('admin.common.layout')
@section('meta_title')
    Chỉnh sửa đơn đặt
@endSection
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col-12 ">
                    @if (Session::has('success'))
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
                    @endif
                </div>
                <div class="col">
                    <!-- Page pre-title -->
                    <!-- <div class="page-pretitle">
                                                                    Overview
                                                                    </div> -->
                    <h1 class="text-indigo mb-4" style="font-size: 36px;">
                        Quản lý đơn đặt
                    </h1>
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
                        action="{{ route('purchase_histories.edit', ['id' => $items['id']]) }}" method="POST">
                        <div class="card-header">
                            <h2 class="card-title">
                                Chỉnh sửa đơn đặt: {{ $items['name'] }}
                            </h2>
                            <button id="btnSubmitEdit" onclick="confirmFunction()" type="submit"
                                class="btn btn-indigo ms-auto">Sửa</button>
                        </div>
                        @csrf
                        <div class="card-body">
                            <input type="hidden" name="update_admin" value="1">
                            <div class="hr-text fs-2">Cập nhật trạng thái</div>
                            <div class="row">
                                <div class="mb-3 col-4">
                                    <div class="form-label">Trạng thái thanh toán</div>
                                    <select name="payment_status" class="form-select" aria-label="Default select example"
                                        @if (
                                            $items['payment_status'] == 2 ||
                                                $items['purchase_method'] == 2 ||
                                                $items['purchase_status'] == 9 ||
                                                $items['purchase_status'] == 1) disabled @endif>
                                        @if ($items['payment_status'] == 1)
                                            <option>-----Trạng thái thanh toán-----</option>
                                        @endif
                                        <option @if ($items['payment_status'] == 1) selected @endif value="1">Người dùng
                                            chưa thanh toán
                                        </option>
                                        <option @if ($items['payment_status'] == 2) selected @endif value="2">Người
                                            dùng đã
                                            thanh toán
                                        </option>
                                    </select>
                                </div>
                                <div class="mb-3 col-4">
                                    <div class="form-label">Trạng thái đơn hàng</div>
                                    <select name="purchase_status" class="form-select" aria-label="Default select example"
                                        @if ($items['payment_status'] == 1) disabled @endif>
                                        @if ($items['payment_status'] == 1)
                                            <option @if ($items['purchase_status'] == 9) selected @endif value="9">
                                                -----Trạng
                                                thái đơn hàng-----</option>
                                        @endif
                                        @switch ($items['payment_status'])
                                            @case(2)
                                                @if ($items['purchase_status'] == 2 || $items['purchase_status'] == 7 || $items['purchase_status'] == 8)
                                                    <option @if ($items['purchase_status'] == 2) selected @endif value="2">Đang
                                                        đợi phê duyệt thanh
                                                        toán
                                                    </option>
                                                    <option @if ($items['purchase_status'] == 3) selected @endif value="3">Đã
                                                        phê duyệt
                                                    </option>
                                                    @if ($items['purchase_method'] == 1)
                                                        <option @if ($items['purchase_status'] == 7) selected @endif value="7">
                                                            Khách chuyển thiếu
                                                        </option>
                                                        <option @if ($items['purchase_status'] == 8) selected @endif value="8">
                                                            Khách chuyển thừa
                                                        </option>
                                                    @endif
                                                @elseif ($items['purchase_status'] == 3)
                                                    <option @if ($items['purchase_status'] == 3) selected @endif value="3">Đã
                                                        phê duyệt
                                                    </option>
                                                @elseif ($items['purchase_status'] == 4 || $items['purchase_status'] == 5)
                                                    <option @if ($items['purchase_status'] == 4) selected @endif value="4">Đang
                                                        đợi phê duyệt hủy tour
                                                    </option>
                                                    <option @if ($items['purchase_status'] == 5) selected @endif value="5">Đã
                                                        phê duyệt, chưa hoàn tiền
                                                    </option>
                                                    <option @if ($items['purchase_status'] == 6) selected @endif value="6">Đã
                                                        hủy tour thành công
                                                    </option>
                                                @elseif ($items['purchase_status'] == 6)
                                                    <option @if ($items['purchase_status'] == 6) selected @endif value="6">Đã
                                                        hủy tour thành công
                                                    </option>
                                                @endif
                                            @case(1)
                                                @if ($items['purchase_status'] == 1)
                                                    <option @if ($items['purchase_status'] == 1) selected disabled @endif
                                                        value="1">Tự động
                                                        hủy do quá hạn
                                                @endif

                                                @default
                                            @endswitch
                                        </select>
                                    </div>
                                    <div class="mb-3 col-4">
                                        <div class="form-label">Trạng thái tour</div>
                                        <select name="tour_status" class="form-select" aria-label="Default select example"
                                            disabled>
                                            @if (
                                                $items['payment_status'] == 2 &&
                                                    ($items['purchase_status'] != 4 || $items['purchase_status'] != 5 || $items['purchase_status'] != 6))
                                                <option @if ($items['tour_status'] == 1) selected @endif value="1">Chưa
                                                    tới
                                                    ngày đi
                                                </option>
                                                <option @if ($items['tour_status'] == 2) selected @endif value="2">Đang
                                                    diễn ra
                                                </option>
                                                <option @if ($items['tour_status'] == 3) selected @endif value="3">Đã
                                                    kết
                                                    thúc
                                                </option>
                                                <option @if ($items['tour_status'] == 4) selected @endif value="4">Còn
                                                    1 ngày đến ngày đi tour
                                                </option>
                                            @else
                                                <option>
                                                    -----Trạng thái tour-----</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3">
                                        <div class="form-label">Phương thức thanh toán</div>
                                        <div class="custom-controls-stacked">
                                            <label class="custom-control custom-radio custom-control-inline me-2">
                                                <input type="radio" class="custom-control-input"
                                                    @if ($items['purchase_method'] == '2') checked @endif name="purchase_method"
                                                    value="1" disabled>
                                                <span class="custom-control-label">VN Pay</span>
                                            </label>
                                            <label class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" class="custom-control-input"
                                                    @if ($items['purchase_method'] == '1') checked @endif name="purchase_method"
                                                    value="0" disabled>
                                                <span class="custom-control-label">Chuyển khoản trực tiếp</span>
                                            </label>

                                            <span class="text-danger d-flex justify-content-start">
                                                @error('purchase_method')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="hr-text fs-2">Chỉnh sửa thông tin</div>
                                <div class="row">
                                    <div class="mb-3 col-9">
                                        <label class="form-label">Tên người dùng</label>
                                        <input type="text" name="name" class="form-control"
                                            placeholder="Nhập tên người dùng" value="{{ $items['name'] }}">
                                        <span class="text-danger d-flex justify-content-start">
                                            @error('name')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="mb-3 col-3">
                                        <label class="form-label">ID người dùng</label>
                                        <input type="text" name="user_id" class="form-control"
                                            placeholder="Nhập ID người dùng" value="{{ $items['user_id'] }}">
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
                                        <input type="email" name="email" class="form-control"
                                            placeholder="Email người đặt tour" value="{{ $items['email'] }}">
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
                                            value="{{ $items['phone_number'] }}">
                                        <span class="text-danger d-flex justify-content-start">
                                            @error('phone_number')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="mb-3 col-4">
                                        <div class="form-label">Giới tính</div>
                                        <select class="form-select" aria-label="Default select example">
                                            <option>-----Chọn giới tính-----</option>
                                            <option @if ($items['gender'] == 1) selected @endif value="1">Nam
                                            </option>
                                            <option @if ($items['gender'] == 2) selected @endif value="2">Nữ
                                            </option>
                                            <option @if ($items['gender'] == 3) selected @endif value="3">Không
                                                xác
                                                định</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-6">
                                        <div class="form-label">Tên tour</div>
                                        <input name="tour_name" type="text" placeholder="Nhập tên tour"
                                            class="form-control" value="{{ $items['tour_name'] }}">
                                        <span class="text-danger d-flex justify-content-start">
                                            @error('tour_name')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="mb-3 col-6">
                                        <div class="form-label">Độ dài tour</div>
                                        <input name="tour_duration" type="text" placeholder="Nhập độ dài tour"
                                            class="form-control" value="{{ $items['tour_duration'] }}">
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
                                            class="form-control" value="{{ $items['child_count'] }}">
                                        <span class="text-danger d-flex justify-content-start">
                                            @error('child_count')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="mb-3 col-3">
                                        <div class="form-label">Giá trẻ em</div>
                                        <input name="tour_child_price" type="text" placeholder="Nhập giá cho trẻ nhỏ"
                                            class="form-control" value="{{ $items['tour_child_price'] }}">
                                        <span class="text-danger d-flex justify-content-start">
                                            @error('tour_child_price')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="mb-3 col-3">
                                        <div class="form-label">Số người lớn</div>
                                        <input name="adult_count" type="text" placeholder="Nhập số người lớn"
                                            class="form-control" value="{{ $items['adult_count'] }}">
                                        <span class="text-danger d-flex justify-content-start">
                                            @error('adult_count')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="mb-3 col-3">
                                        <div class="form-label">Giá người lớn</div>
                                        <input name="tour_adult_price" type="text" placeholder="Nhập giá cho người lớn"
                                            class="form-control" value="{{ $items['tour_adult_price'] }}">
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
                                            value="{{ $items['tour_start_destination'] }}">
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
                                            value="{{ $items['tour_end_destination'] }}">
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
                                            placeholder="Nhập vị trí của tour" value="{{ $items['tour_location'] }}">
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
                                            value="{{ $items['tour_sale_percentage'] }}">
                                        <span class="text-danger d-flex justify-content-start">
                                            @error('tour_sale_percentage')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="mb-3 col-3">
                                        <div class="form-label">Mã giảm giá</div>
                                        <input name="coupon_name" type="text" class="form-control"
                                            placeholder="Nhập mã giảm giá" value="{{ $items['coupon_name'] }}">
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
                                            value="{{ $items['coupon_percentage'] }}">
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
                                            value="{{ $items['coupon_fixed'] }}">
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
                                            placeholder="Nhập vị trí của tour" value="{{ $items['refund_percentage'] }}">
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
                                        placeholder="Nhập nội dung mô tả">{{ $items['suggestion'] }}</textarea>
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
                                            class="form-control" value="{{ $items['tour_start_time'] }}">
                                        <span class="text-danger d-flex justify-content-start">
                                            @error('tour_start_time')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="mb-3 col-6">
                                        <div class="form-label">Thời gian kết thúc</div>
                                        <input name="tour_end_time" type="text" placeholder="Nhập điểm kết thúc tour"
                                            class="form-control" value="{{ $items['tour_end_time'] }}">
                                        <span class="text-danger d-flex justify-content-start">
                                            @error('tour_end_time')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer text-end">
                                <div class="mb-3">
                                    <button id="btnSubmitEdit" onclick="confirmFunction()" type="submit"
                                        class="btn btn-indigo">Sửa</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
            let confirmFunction = function() {
                if (confirm(
                        'Bạn có chắc chắn thay đổi không? Bạn sẽ KHÔNG thay đổi được nữa và người dùng sẽ nhận thông báo về thay đổi của bạn'
                    ) == false) {
                    event.preventDefault()
                }
            }
        </script>
    @endsection
