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
                            Quay lại
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
                    <form id="frmAdd" class="card border-0 shadow-lg rounded-4 " action="" method="POST">
                        <div class="card-header">
                            <h2 class="card-title">
                                Chỉnh sửa đơn đặt của khách hàng: {{ $items['name'] }}
                            </h2>
                            <button id="btnSubmitAdd" type="button" class="btn btn-indigo ms-auto"
                                data-id="{{ $items['id'] }}">Sửa</button>
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
                                                $items['purchase_status'] == 1 ||
                                                $items['user_id'] != null) disabled @endif>
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
                                                    @if ($items['user_id'] == null)
                                                        <option @if ($items['purchase_status'] == 6) selected @endif value="6">
                                                            Đã
                                                            hủy tour thành công
                                                        </option>
                                                    @endif
                                                @elseif ($items['purchase_status'] == 3)
                                                    <option @if ($items['purchase_status'] == 3) selected @endif value="3">Đã
                                                        phê duyệt
                                                    </option>
                                                    @if ($items['user_id'] == null)
                                                        <option @if ($items['purchase_status'] == 6) selected @endif value="6">
                                                            Đã
                                                            hủy tour thành công
                                                        </option>
                                                    @endif
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
                                @if ($items['purchase_status'] == 4 || $items['purchase_status'] == 5 || $items['purchase_status'] == 6)
                                    <div class="row">
                                        <div class="mb-3 col-9">
                                            <div class="form-label">Lý do hủy tour</div>
                                            <span name="cancel_reason">{{ $items['cancel_reason'] }}
                                            </span>
                                        </div>
                                        <div class="mb-3 col-3">
                                            <div class="form-label">Số tài khoản</div>
                                            <span name="bank_number">{{ $items['bank_number'] }}
                                            </span>
                                        </div>
                                    </div>
                                @endif
                                <div class="hr-text fs-2">Chỉnh sửa thông tin</div>
                                <div class="row">
                                    <div class="mb-3 col-9">
                                        <label class="form-label fs-2">Tên người dùng</label>
                                        <span name="user_id" class="fs-2">{{ $items['name'] }}
                                        </span>
                                        <span class="text-danger d-flex justify-content-start">
                                            @error('name')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="mb-3 col-3">
                                        <label class="form-label fs-2">ID người dùng</label>
                                        <span name="user_id" class="fs-2">{{ $items['user_id'] }}
                                        </span>
                                        <span class="text-danger d-flex justify-content-start ">
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
                                        <span name="child_count">{{ $items['child_count'] }}
                                        </span>
                                        <span class="text-danger d-flex justify-content-start">
                                            @error('child_count')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="mb-3 col-3">
                                        <div class="form-label">Giá trẻ em</div>
                                        <span name="tour_child_price">{{ $items['tour_child_price'] }}
                                        </span>
                                        <span class="text-danger d-flex justify-content-start">
                                            @error('tour_child_price')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="mb-3 col-3">
                                        <div class="form-label">Số người lớn</div>
                                        <span name="adult_count">{{ $items['adult_count'] }} </span>
                                        <span class="text-danger d-flex justify-content-start">
                                            @error('adult_count')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="mb-3 col-3">
                                        <div class="form-label">Giá người lớn</div>
                                        <span name="tour_adult_price">{{ $items['tour_adult_price'] }} </span>
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
                                        <div class="form-label">Tour giảm giá (%)</div>
                                        <span name="tour_sale_percentage">{{ $items['tour_sale_percentage'] }}</span>
                                        <span class="text-danger d-flex justify-content-start">
                                            @error('tour_sale_percentage')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="mb-3 col-3">
                                        <div class="form-label">Mã giảm giá</div>
                                        <span name="coupon_name">{{ $items['coupon_name'] }}</span>
                                        <span class="text-danger d-flex justify-content-start">
                                            @error('coupon_name')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="mb-3 col-3">
                                        <div class="form-label">Phần trăm giảm giá</div>
                                        <span name="coupon_percentage">{{ $items['coupon_percentage'] }}</span>
                                        <span class="text-danger d-flex justify-content-start">
                                            @error('coupon_percentage')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="mb-3 col-3">
                                        <div class="form-label">Số tiền giảm thẳng</div>
                                        <span name="coupon_fixed">{{ $items['coupon_fixed'] }}</span>
                                        <span class="text-danger d-flex justify-content-start">
                                            @error('coupon_fixed')
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
                                            class="form-control" value="{{
                                                \Carbon\Carbon::createFromFormat('d-m-Y',$items['tour_start_time'])->addDays($items['tour_duration'])->format('d-m-Y');
                                            }}" disabled>
                                        <span class="text-danger d-flex justify-content-start">
                                            @error('tour_end_time')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>

                            </div>
                            {{-- <div class="card-footer text-end">
                                <div class="mb-3">
                                    <button id="btnSubmitAdd" type="button" class="btn btn-indigo"
                                        data-id="{{ $items['id'] }}">Sửa</button>
                                </div>
                            </div> --}}
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal modal-blur fade" id="modalContainer" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                    </div>
                </div>
            </div>
        </div>
    @endSection
    @section('page_js')
        <!-- Cập nhật đơn hàng !-->
        <script>
            $(document).ready(function() {
                $('#btnSubmitAdd').click(function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: "Xác nhận",
                        text: "Bạn có chắc chắn thay đổi không? Bạn sẽ KHÔNG thay đổi được nữa và người dùng sẽ nhận thông báo về thay đổi của bạn!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Được rồi!",
                        cancelButtonText: 'Không'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var id = document.querySelector('#btnSubmitAdd').dataset.id;
                            // lấy dữ liệu từ form
                            var formData = new FormData(this.form);
                            // thực hiện Ajax
                            $.ajax({

                                url: "{{ route('purchase_histories.edit', ['id' => ':id']) }}"
                                    .replace(':id', id),
                                type: "POST",
                                data: formData,
                                contentType: false,
                                processData: false,
                                success: function(response) {
                                    // xử lý response từ server
                                    if (response.status === 200) {

                                        // Hiển thị SweetAlert khi thành công
                                        Swal.fire({
                                                title: 'Thành công!',
                                                text: response.message,
                                                icon: 'success'
                                            })
                                            .then(function(response) {
                                                location.reload();
                                            })
                                    } else {
                                        Swal.fire({
                                            title: 'Lỗi!',
                                            text: response.message,
                                            icon: 'error'
                                        });
                                    }

                                },
                                error: function(xhr, status, error) {
                                    // Xóa tất cả lỗi hiện tại trên giao diện
                                    var listSpans = document.querySelectorAll(".spanError");
                                    listSpans.forEach(function(item) {
                                        item.innerHTML = '';
                                    });

                                    // Xử lý lỗi ajax nếu có
                                    var errorResponse = JSON.parse(xhr.responseText);

                                    // Lặp qua từng trường lỗi
                                    Object.keys(errorResponse.errors).forEach(function(
                                        fieldName) {
                                        // `fieldName` là tên trường có lỗi
                                        var errorMessages = errorResponse.errors[
                                            fieldName];

                                        // Lặp qua từng thông điệp lỗi trong mảng
                                        errorMessages.forEach(function(
                                            errorMessage) {
                                            var listSpans = document
                                                .querySelectorAll(
                                                    ".spanError");

                                            listSpans.forEach(function(
                                                item) {
                                                if (item.dataset.tag
                                                    .trim() ==
                                                    fieldName.trim()
                                                ) {
                                                    // Hiển thị lỗi chỉ ở trường tương ứng
                                                    item.innerHTML =
                                                        errorMessage;
                                                }
                                            });
                                        });
                                    });

                                    Swal.fire({
                                        title: 'Lỗi!',
                                        text: 'Đã xảy ra lỗi khi thực hiện sửa faq',
                                        icon: 'error'
                                    });
                                }

                            });
                        }
                    });
                });
            });
        </script>
        <!-- --------------------------------------------- !-->
    @endsection
