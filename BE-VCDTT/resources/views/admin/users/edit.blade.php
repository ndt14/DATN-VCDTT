@extends('admin.common.layout')
@section('meta_title')
    Thêm quản trị viên
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
                        Quản lý tài khoản
                    </h1>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ url('/user') }}" class="btn btn-default d-none d-sm-inline-block">
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
                        <a href="{{ url('/user') }}" class="btn btn-default d-sm-none btn-icon">
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
                                Thêm mới người dùng
                            </h2>
                        </div>
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3 col-6">
                                    <label class="form-label">Tên</label>
                                    <input type="text" name="name" class="form-control" placeholder="Tên"
                                        value="{{ $response->name }}">
                                    <span class="text-danger d-flex justify-content-start spanError" data-tag="name">
                                        @error('name')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="mb-3 col-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="Email"
                                        value="{{ $response->email }}">
                                    <span class="text-danger d-flex justify-content-start spanError" data-tag="email">
                                        @error('email')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>

                            </div>
                            <div class="row">
                                <div class="mb-3 col-6">
                                    <label class="form-label">Mật khẩu</label>
                                    <input type="password" name="password" class="form-control" placeholder="Mật khẩu"
                                        value="{{ $response->password }}">
                                    <span class="text-danger d-flex justify-content-start spanError" data-tag="password">
                                        @error('password')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="mb-3 col-6">
                                    <label class="form-label">Ảnh đại diện</label>
                                    <input type="text" name="image" class="form-control" placeholder="Ảnh"
                                        value="{{ $response->image }}">
                                    <span class="text-danger d-flex justify-content-start spanError" data-tag="image">
                                        @error('image')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-6">
                                    <label class="form-label">Số điện thoại</label>
                                    <input type="text" name="phone_number" class="form-control" placeholder="Sđt"
                                        value="{{ $response->phone_number }}">
                                    <span class="text-danger d-flex justify-content-start spanError"
                                        data-tag="phone_number">
                                        @error('phone_number')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="mb-3 col-6">
                                    <label class="form-label">Ngày sinh</label>
                                    <input type="date" name="date_of_birth" class="form-control"
                                        placeholder="Ngày sinh" value="{{ $response->date_of_birth }}">
                                    <span class="text-danger d-flex justify-content-start spanError"
                                        data-tag="date_of_birth">
                                        @error('date_of_birth')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-6">
                                    <label class="form-label">Địa chỉ</label>
                                    <input type="text" name="address" class="form-control" placeholder="Địa chỉ"
                                        value="{{ $response->address }}">
                                    <span class="text-danger d-flex justify-content-start spanError" data-tag="address">
                                        @error('address')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="mb-3 col-6">
                                    <label class="form-label">Giới tính</label>
                                    <select name="gender" id="" class="form-control">
                                        <option value="">Chọn</option>
                                        <option value="1" {{ $response->gender == 1 ? 'selected' : '' }}>Nam</option>
                                        <option value="2" {{ $response->gender == 2 ? 'selected' : '' }}>Nữ</option>
                                    </select>
                                    <span class="text-danger d-flex justify-content-start spanError" data-tag="gender">
                                        @error('date_of_birth')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-6">
                                    <div class="form-label">Trạng thái</div>
                                    <div class="custom-controls-stacked">
                                        <label class="custom-control custom-radio custom-control-inline me-2">
                                            <input type="radio" class="custom-control-input" name="status"
                                                checked="" value="1"
                                                {{ $response->status == 1 ? 'checked' : '' }}>
                                            <span class="custom-control-label">Hoạt động</span>
                                        </label>
                                        <label class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" class="custom-control-input" name="status"
                                                value="0" {{ $response->status == 0 ? 'checked' : '' }}>
                                            <span class="custom-control-label">Vô hiệu hóa</span>
                                        </label>

                                        <span class="text-danger d-flex justify-content-start">
                                        </span>
                                    </div>
                                </div>

                                @if (auth()->user()->is_admin == 1)
                                    <div class="mb-3 col-6">
                                        <div class="form-label">Admin ?</div>
                                        <div class="custom-controls-stacked">
                                            <label class="custom-control custom-radio custom-control-inline me-2">
                                                <input type="radio" class="custom-control-input" name="is_admin"
                                                    value="2" {{ $response->is_admin == 2 ? 'checked' : '' }}>
                                                <span class="custom-control-label">Không</span>
                                            </label>
                                            <label class="custom-control custom-radio custom-control-inline me-2">
                                                <input type="radio" class="custom-control-input" name="is_admin"
                                                    value="3" {{ $response->is_admin == 3 ? 'checked' : '' }}>
                                                <span class="custom-control-label">Khác. Cho phép truy cập dashboard</span>
                                            </label>
                                            <span class="text-danger d-flex justify-content-start">
                                            </span>
                                        </div>
                                    </div>
                                @else
                                    <div class="mb-3 col-6">
                                        <div class="form-label">Admin ?</div>
                                        <div class="custom-controls-stacked">
                                            <label class="custom-control custom-radio custom-control-inline me-2">
                                                <input type="radio" class="custom-control-input" name="is_admin"
                                                    value="2" {{ $response->is_admin == 2 ? 'checked' : '' }}>
                                                <span class="custom-control-label">Không</span>
                                            </label>
                                            <label class="custom-control custom-radio custom-control-inline me-2">
                                                <input type="radio" class="custom-control-input" name="is_admin"
                                                    value="3" {{ $response->is_admin == 3 ? 'checked' : '' }}>
                                                <span class="custom-control-label">Khác. Cho phép truy cập dashboard</span>
                                            </label>
                                            <span class="text-danger d-flex justify-content-start">
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button id="btnSubmitAdd" type="button" class="btn btn-indigo"
                                data-id="{{ $response->id }}">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal modal-blur fade" id="modalContainer" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page_js')
    <!-- Thêm faq !-->
    <script>
        $(document).ready(function() {

            $('#btnSubmitAdd').click(function(e) {
                e.preventDefault();

                // lấy dữ liệu từ form
                var formData = new FormData(this.form);
                // thực hiện Ajax
                $.ajax({

                    url: "{{ route('user.edit', ['id' => ':id']) }}".replace(':id', this.dataset
                        .id),
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
                                    if (response) {
                                        location.reload();
                                    }
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
                        Object.keys(errorResponse.errors).forEach(function(fieldName) {
                            // `fieldName` là tên trường có lỗi
                            var errorMessages = errorResponse.errors[fieldName];

                            // Lặp qua từng thông điệp lỗi trong mảng
                            errorMessages.forEach(function(errorMessage) {
                                var listSpans = document.querySelectorAll(
                                    ".spanError");

                                listSpans.forEach(function(item) {
                                    if (item.dataset.tag.trim() ==
                                        fieldName.trim()) {
                                        // Hiển thị lỗi chỉ ở trường tương ứng
                                        item.innerHTML = errorMessage;
                                    }
                                });
                            });
                        });

                        Swal.fire({
                                title: 'Lỗi!',
                                text: 'Đã xảy ra lỗi khi thực hiện cập nhật tài khoản',
                                icon: 'error'
                            })
                            .then((response) => {
                                if (response) {
                                    location.reload();
                                }
                            });
                    }

                });
            });
        });
    </script>
    <!-- --------------------------------------------- !-->
@endSection
