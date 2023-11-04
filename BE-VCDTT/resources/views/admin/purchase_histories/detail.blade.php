<div class="modal-header">
    <h1 class="modal-title fs-4" id="exampleModalFullscreenMdLabel">Chi tiết hóa đơn</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body row row-deck row-cards">
    <div class="col-sm-12 col-md-12 px-6">
        <div class="card-body">
            <div class="row">
                <div class="mb-3 col-9">
                    <label class="form-label">Tên người dùng</label>
                    <input type="text" name="name" class="form-control" placeholder="Nhập tên người dùng"
                        value="{{ $item['name'] }}" disabled>
                    <span class="text-danger d-flex justify-content-start">
                        @error('name')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="mb-3 col-3">
                    <label class="form-label">ID người dùng</label>
                    <input type="text" name="user_id" class="form-control" placeholder="Nhập ID người dùng"
                        value="{{ $item['user_id'] }}" disabled>
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
                    <input type="email" name="main_img" class="form-control" placeholder="Email người đặt tour"
                        value="{{ $item['email'] }}" disabled>
                    <span class="text-danger d-flex justify-content-start">
                        @error('email')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="mb-3 col-4">
                    <label class="form-label">Số điện thoại</label>
                    <input type="text" name="phone_number" class="form-control"
                        placeholder="Nhập số điện thoại người đặt tour" value="{{ $item['phone_number'] }}" disabled>
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
                        <option @if ($item['gender'] == 1) selected @endif value="1">Nam
                        </option>
                        <option @if ($item['gender'] == 2) selected @endif value="2">Nữ
                        </option>
                        <option @if ($item['gender'] == 3) selected @endif value="3">Không xác
                            định</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col-6">
                    <div class="form-label">Tên tour</div>
                    <input name="tour_name" type="text" placeholder="Nhập tên tour" class="form-control"
                        value="{{ $item['tour_name'] }}" disabled>
                    <span class="text-danger d-flex justify-content-start">
                        @error('tour_name')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="mb-3 col-6">
                    <div class="form-label">Độ dài tour</div>
                    <input name="tour_duration" type="text" placeholder="Nhập độ dài tour" class="form-control"
                        value="{{ $item['tour_duration'] }}" disabled>
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
                    <input name="child_count" type="text" placeholder="Nhập số trẻ em" class="form-control"
                        value="{{ $item['child_count'] }}" disabled>
                    <span class="text-danger d-flex justify-content-start">
                        @error('child_count')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="mb-3 col-3">
                    <div class="form-label">Giá trẻ em</div>
                    <input name="tour_child_price" type="text" placeholder="Nhập giá cho trẻ nhỏ"
                        class="form-control" value="{{ $item['tour_child_price'] }}" disabled>
                    <span class="text-danger d-flex justify-content-start">
                        @error('tour_child_price')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="mb-3 col-3">
                    <div class="form-label">Số người lớn</div>
                    <input name="adult_count" type="text" placeholder="Nhập số người lớn" class="form-control"
                        value="{{ $item['adult_count'] }}" disabled>
                    <span class="text-danger d-flex justify-content-start">
                        @error('adult_count')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="mb-3 col-3">
                    <div class="form-label">Giá người lớn</div>
                    <input name="tour_adult_price" type="text" placeholder="Nhập giá cho người lớn"
                        class="form-control" value="{{ $item['tour_adult_price'] }}" disabled>
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
                    <input name="tour_start_destination" type="text" placeholder="Nhập điểm khởi hành tour"
                        class="form-control" value="{{ $item['tour_start_destination'] }}" disabled>
                    <span class="text-danger d-flex justify-content-start">
                        @error('tour_start_destination')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="mb-3 col-6">
                    <div class="form-label">Điểm kết thúc</div>
                    <input name="tour_end_destination" type="text" placeholder="Nhập điểm kết thúc tour"
                        class="form-control" value="{{ $item['tour_end_destination'] }}" disabled>
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
                        placeholder="Nhập vị trí của tour" value="{{ $item['tour_location'] }}" disabled>
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
                    <input name="tour_sale_percentage" type="text" class="form-control"
                        placeholder="Nhập phần trăm giảm giá của tour" value="{{ $item['tour_sale_percentage'] }}"
                        disabled>
                    <span class="text-danger d-flex justify-content-start">
                        @error('tour_sale_percentage')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="mb-3 col-3">
                    <div class="form-label">Mã giảm giá</div>
                    <input name="coupon_name" type="text" class="form-control" placeholder="Nhập mã giảm giá"
                        value="{{ $item['coupon_name'] }}" disabled>
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
                        value="{{ $item['coupon_percentage'] }}" disabled>
                    <span class="text-danger d-flex justify-content-start">
                        @error('coupon_percentage')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="mb-3 col-3">
                    <div class="form-label">Số tiền giảm trực tiếp</div>
                    <input name="coupon_fixed" type="text" class="form-control"
                        placeholder="Nhập phần trăm giảm giá của mã giảm giá" value="{{ $item['coupon_fixed'] }}"
                        disabled>
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
                        placeholder="Nhập vị trí của tour" value="{{ $item['refund_percentage'] }}" disabled>
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
                    placeholder="Nhập nội dung mô tả" disabled>{{ $item['suggestion'] }}</textarea>
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
                        class="form-control" value="{{ $item['tour_start_time'] }}" disabled>
                    <span class="text-danger d-flex justify-content-start">
                        @error('tour_start_time')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="mb-3 col-6">
                    <div class="form-label">Thời gian kết thúc</div>
                    <input name="tour_end_time" type="text" placeholder="Nhập điểm kết thúc tour"
                        class="form-control" value="{{ $item['tour_end_time'] }}" disabled>
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
                        <input type="radio" class="custom-control-input" disabled
                            @if ($item['payment_status'] == '1') checked @endif name="payment_status" value="1">
                        <span class="custom-control-label">Đã thanh toán</span>
                    </label>
                    <label class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" disabled
                            @if ($item['payment_status'] == '0') checked @endif name="payment_status" value="0">
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
                <select name="purchase_status" class="form-select" aria-label="Default select example" disabled>
                    <option>-----Trạng thái-----</option>
                    <option @if ($item['purchase_status'] == 0) selected @endif value="0">Người dùng chưa thanh toán
                    </option>
                    <option @if ($item['purchase_status'] == 1) selected @endif value="1">Đang đợi Admin xác nhận
                    </option>
                    <option @if ($item['purchase_status'] == 2) selected @endif value="2">Admin đã xác nhận, chờ người dùng ngày đi tour
                    </option>
                    <option @if ($item['purchase_status'] == 3) selected @endif value="3">Còn một ngày tới ngày đi tour
                    </option>
                    <option @if ($item['purchase_status'] == 4) selected @endif value="4">Tour đang diễn ra
                    </option>
                    <option @if ($item['purchase_status'] == 5) selected @endif value="5">Tour đã kết thúc
                    </option>
                    <option @if ($item['purchase_status'] == 6) selected @endif value="6">Admin đã hủy tour
                    </option>
                    <option @if ($item['purchase_status'] == 7) selected @endif value="7">Người dùng đã hủy
                    </option>
                    <option @if ($item['purchase_status'] == 8) selected @endif value="8">Tự  động đơn đặt  hủy do quá hạn than toán
                    </option>
                    <option @if ($item['purchase_status'] == 9) selected @endif value="9">Đã hoàn tiền
                    </option>
                    <option @if ($item['purchase_status'] == 10) selected @endif value="10">Người dùng đã đánh giá
                    </option>
                </select>
            </div>

            <a class="button btn btn-indigo" href=" {{ route('purchase_histories.edit', ['id' => $item['id']]) }}">Chỉnh sửa</a>

        </div>
    </div>
</div>
