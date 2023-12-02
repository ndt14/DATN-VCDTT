@extends('admin.common.layout')
@section('meta_title')
    Chỉnh sửa vai trò
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
                    <h2 class="page-title">
                        Roles Management
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ url('/role') }}" class="btn btn-default d-none d-sm-inline-block">
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
                        <a href="{{ url('/role') }}" class="btn btn-default d-sm-none btn-icon">
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
                    <form id="frmAdd" class="card" action="" method="POST">
                        <div class="card-header">
                            <h2 class="card-title">
                                Chỉnh sửa Vai trò - Quyền
                            </h2>
                        </div>
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3 col-12">
                                    <label class="form-label">Tên vai trò</label>
                                    <input type="text" name="name" class="form-control" placeholder="Tên vai trò"
                                        value="{{ $role->name }}">
                                    <span class="text-danger d-flex justify-content-start spanError" data-tag="name">
                                        @error('name')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="mb-3 col-12">
                                    <label class="form-label">Mô tả</label>
                                    <input type="text" name="desc_role" class="form-control" placeholder="Không bắt buộc"
                                        value="{{ $role->desc_role }}">
                                    <input type="hidden" name="guard_name" value="web">
                                </div>

                            </div>
                            <div class="row">
                                <div class="mb-3 col-6">
                                    <p class="text-indigo" style="font-weight: bold;">Vai trò này có quyền gì?</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">Tích để chọn quyền cho vai trò</h3>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table card-table table-vcenter text-nowrap datatable">
                                                <thead>
                                                    <tr>
                                                        <th class="text-indigo" style="font-weight: 700;">Chức năng</th>
                                                        <th class="text-indigo" style="font-weight: 700;">Truy cập</th>
                                                        <th class="text-indigo" style="font-weight: 700;">Thêm</th>
                                                        <th class="text-indigo" style="font-weight: 700;">Sửa</th>
                                                        <th class="text-indigo" style="font-weight: 700;">Xóa</th>
                                                        <th class="text-indigo" style="font-weight: 700;">Trả lời</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr style="border-bottom: 1px solid #0D6EFD;">
                                                        <td class="text-black" style="font-weight: 500;">Quản lý tour</td>
                                                        <td><input name="permission[]" data-bs-toggle="tooltip"
                                                                title="Quyền truy cập mục tour"
                                                                class="form-check-input m-0 align-middle" type="checkbox"
                                                                aria-label="Select all invoices"
                                                                @if (in_array(4, $permissions)) checked @endif
                                                                value="4"></td>
                                                        <td><input name="permission[]" data-bs-toggle="tooltip"
                                                                title="Quyền thêm mới tour"
                                                                class="form-check-input m-0 align-middle" type="checkbox"
                                                                aria-label="Select all invoices"
                                                                @if (in_array(1, $permissions)) checked @endif
                                                                value="1"></td>
                                                        <td><input name="permission[]" data-bs-toggle="tooltip"
                                                                title="Quyền sửa tour"
                                                                class="form-check-input m-0 align-middle" type="checkbox"
                                                                aria-label="Select all invoices"
                                                                @if (in_array(2, $permissions)) checked @endif
                                                                value="2"></td>
                                                        <td><input name="permission[]" data-bs-toggle="tooltip"
                                                                title="Quyền xóa tour"
                                                                class="form-check-input m-0 align-middle" type="checkbox"
                                                                aria-label="Select all invoices"
                                                                @if (in_array(3, $permissions)) checked @endif
                                                                value="3"></td>

                                                    </tr>
                                                    <tr>
                                                        <td colspan="8">|-- Thêm mới tour</td>

                                                    </tr>
                                                    <tr>
                                                        <td colspan="8">|-- Chỉnh sửa tour</td>

                                                    </tr>
                                                    <tr>
                                                        <td colspan="8">|-- Xóa bỏ tour</td>
                                                    </tr>
                                                    <tr style="border-bottom: 1px solid #0D6EFD;">
                                                        <td class="text-black" style="font-weight: 500;">Quản lý đánh giá
                                                            tour</td>
                                                        <td colspan="3"><input
                                                                class="form-check-input m-0 align-middle"
                                                                name="permission[]" data-bs-toggle="tooltip"
                                                                title="Quyền truy cập mục đánh giá" type="checkbox"
                                                                aria-label="Select all invoices"
                                                                @if (in_array(30, $permissions)) checked @endif
                                                                value="30"></td>
                                                        <td><input class="form-check-input m-0 align-middle"
                                                                name="permission[]" data-bs-toggle="tooltip"
                                                                title="Quyền xóa đánh giá" type="checkbox"
                                                                aria-label="Select all invoices"
                                                                @if (in_array(29, $permissions)) checked @endif
                                                                value="29"></td>
                                                        <td><input class="form-check-input m-0 align-middle"
                                                                name="permission[]" type="checkbox"
                                                                data-bs-toggle="tooltip" title="Quyền trả lời đánh giá"
                                                                aria-label="Select all invoices"
                                                                @if (in_array(28, $permissions)) checked @endif
                                                                value="28"></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="8">|-- Trả lời đánh giá</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="8">|-- Xóa đánh giá</td>
                                                    </tr>
                                                    <tr style="border-bottom: 1px solid #0D6EFD;">
                                                        <td class="text-black" style="font-weight: 500;">Quản lý bài viết
                                                        </td>
                                                        <td><input name="permission[]"
                                                                class="form-check-input m-0 align-middle"
                                                                data-bs-toggle="tooltip"
                                                                title="Quyền truy cập mục bài viết" type="checkbox"
                                                                aria-label="Select all invoices"
                                                                @if (in_array(27, $permissions)) checked @endif
                                                                value="27"></td>
                                                        <td><input name="permission[]"
                                                                class="form-check-input m-0 align-middle"
                                                                data-bs-toggle="tooltip" title="Quyền thêm bài viết"
                                                                type="checkbox" aria-label="Select all invoices"
                                                                @if (in_array(24, $permissions)) checked @endif
                                                                value="24"></td>
                                                        <td><input name="permission[]"
                                                                class="form-check-input m-0 align-middle"
                                                                data-bs-toggle="tooltip" title="Quyền sửa bài viết"
                                                                type="checkbox" aria-label="Select all invoices"
                                                                @if (in_array(25, $permissions)) checked @endif
                                                                value="25"></td>
                                                        <td><input name="permission[]"
                                                                class="form-check-input m-0 align-middle"
                                                                data-bs-toggle="tooltip" title="Quyền xóa bài viết"
                                                                type="checkbox" aria-label="Select all invoices"
                                                                @if (in_array(26, $permissions)) checked @endif
                                                                value="26"></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="8">|-- Thêm mới bài viết</td>

                                                    </tr>
                                                    <tr>
                                                        <td colspan="8">|-- Chỉnh sửa bài viết</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="8">|-- Xóa bỏ bài viết</td>
                                                    </tr>

                                                    <tr style="border-bottom: 1px solid #0D6EFD;">
                                                        <td class="text-black" style="font-weight: 500;">Quản lý faq</td>
                                                        <td><input name="permission[]" data-bs-toggle="tooltip"
                                                                title="Quyền truy cập mục faq"
                                                                class="form-check-input m-0 align-middle" type="checkbox"
                                                                aria-label="Select all invoices"
                                                                @if (in_array(23, $permissions)) checked @endif
                                                                value="23"></td>
                                                        <td><input name="permission[]" data-bs-toggle="tooltip"
                                                                title="Quyền thêm mới faq"
                                                                class="form-check-input m-0 align-middle" type="checkbox"
                                                                aria-label="Select all invoices"
                                                                @if (in_array(20, $permissions)) checked @endif
                                                                value="20"></td>
                                                        <td><input name="permission[]"
                                                                class="form-check-input m-0 align-middle"
                                                                data-bs-toggle="tooltip" title="Quyền sửa faq"
                                                                type="checkbox" aria-label="Select all invoices"
                                                                @if (in_array(21, $permissions)) checked @endif
                                                                value="21"></td>
                                                        <td><input name="permission[]"
                                                                class="form-check-input m-0 align-middle" type="checkbox"
                                                                data-bs-toggle="tooltip" title="Quyền xóa faq"
                                                                aria-label="Select all invoices"
                                                                @if (in_array(22, $permissions)) checked @endif
                                                                value="22"></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="8">|-- Thêm mới faq</td>

                                                    </tr>
                                                    <tr>
                                                        <td colspan="8">|-- Chỉnh sửa faq</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="8">|-- Xóa bỏ faq</td>
                                                    </tr>
                                                    <tr style="border-bottom: 1px solid #0D6EFD;">
                                                        <td class="text-black" style="font-weight: 500;">Quản lý danh mục
                                                        </td>
                                                        <td><input name="permission[]"
                                                                class="form-check-input m-0 align-middle"
                                                                data-bs-toggle="tooltip"
                                                                title="Quyền truy cập mục danh mục" type="checkbox"
                                                                aria-label="Select all invoices"
                                                                @if (in_array(11, $permissions)) checked @endif
                                                                value="11"></td>
                                                        <td><input name="permission[]"
                                                                class="form-check-input m-0 align-middle"
                                                                data-bs-toggle="tooltip" title="Quyền thêm danh mục"
                                                                type="checkbox" aria-label="Select all invoices"
                                                                @if (in_array(8, $permissions)) checked @endif
                                                                value="8"></td>
                                                        <td><input name="permission[]"
                                                                class="form-check-input m-0 align-middle" type="checkbox"
                                                                data-bs-toggle="tooltip" title="Quyền sửa danh mục"
                                                                aria-label="Select all invoices"
                                                                @if (in_array(9, $permissions)) checked @endif
                                                                value="9"></td>
                                                        <td><input name="permission[]"
                                                                class="form-check-input m-0 align-middle" type="checkbox"
                                                                data-bs-toggle="tooltip" title="Quyền xóa danh mục"
                                                                aria-label="Select all invoices"
                                                                @if (in_array(10, $permissions)) checked @endif
                                                                value="10"></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="8">|-- Thêm mới danh mục</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="8">|-- Chỉnh sửa danh mục</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="8">|-- Xóa bỏ danh mục</td>
                                                    </tr>
                                                    <tr style="border-bottom: 1px solid #0D6EFD;">
                                                        <td class="text-black" style="font-weight: 500;">Quản lý hóa đơn
                                                        </td>
                                                        <td colspan="2"><input name="permission[]"
                                                                class="form-check-input m-0 align-middle"
                                                                data-bs-toggle="tooltip"
                                                                title="Quyền truy cập mục hóa đơn" type="checkbox"
                                                                aria-label="Select all invoices"
                                                                @if (in_array(7, $permissions)) checked @endif
                                                                value="7"></td>
                                                        <td><input name="permission[]"
                                                                class="form-check-input m-0 align-middle" type="checkbox"
                                                                data-bs-toggle="tooltip" title="Quyền sửa hóa đơn"
                                                                aria-label="Select all invoices"
                                                                @if (in_array(5, $permissions)) checked @endif
                                                                value="5"></td>
                                                        <td><input name="permission[]"
                                                                class="form-check-input m-0 align-middle" type="checkbox"
                                                                data-bs-toggle="tooltip" title="Quyền xóa hóa đơn"
                                                                aria-label="Select all invoices"
                                                                @if (in_array(6, $permissions)) checked @endif
                                                                value="6"></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="8">|-- Chỉnh sửa hóa đơn</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="8">|-- Chỉnh sửa xóa hóa đơn</td>
                                                    </tr>
                                                    <tr style="border-bottom: 1px solid #0D6EFD;">
                                                        <td class="text-black" style="font-weight: 500;">Quản lý mã giảm
                                                            giá</td>
                                                        <td><input name="permission[]"
                                                                class="form-check-input m-0 align-middle"
                                                                data-bs-toggle="tooltip"
                                                                title="Quyền truy cập mục mã giảm giá" type="checkbox"
                                                                aria-label="Select all invoices"
                                                                @if (in_array(15, $permissions)) checked @endif
                                                                value="15"></td>
                                                        <td><input name="permission[]"
                                                                class="form-check-input m-0 align-middle"
                                                                data-bs-toggle="tooltip" title="Quyền thêm mã giảm giá"
                                                                type="checkbox" aria-label="Select all invoices"
                                                                @if (in_array(12, $permissions)) checked @endif
                                                                value="12"></td>
                                                        <td><input name="permission[]"
                                                                class="form-check-input m-0 align-middle" type="checkbox"
                                                                data-bs-toggle="tooltip" title="Quyền sửa mã giảm giá"
                                                                aria-label="Select all invoices"
                                                                @if (in_array(13, $permissions)) checked @endif
                                                                value="13"></td>
                                                        <td><input name="permission[]"
                                                                class="form-check-input m-0 align-middle" type="checkbox"
                                                                data-bs-toggle="tooltip" title="Quyền xóa mã giảm giá"
                                                                aria-label="Select all invoices"
                                                                @if (in_array(14, $permissions)) checked @endif
                                                                value="14"></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="8">|-- Thêm mới mã giảm giá</td>

                                                    </tr>
                                                    <tr>
                                                        <td colspan="8">|-- Chỉnh sửa mã giảm giá</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="8">|-- Xóa bỏ mã giảm giá</td>
                                                    </tr>
                                                    <tr style="border-bottom: 1px solid #0D6EFD;">
                                                        <td class="text-black" style="font-weight: 500;">Quản lý tài khoản
                                                        </td>
                                                        <td><input name="permission[]"
                                                                class="form-check-input m-0 align-middle"
                                                                data-bs-toggle="tooltip"
                                                                title="Quyền truy cập mục tài khoản" type="checkbox"
                                                                aria-label="Select all invoices"
                                                                @if (in_array(19, $permissions)) checked @endif
                                                                value="19"></td>
                                                        <td><input name="permission[]"
                                                                class="form-check-input m-0 align-middle"
                                                                data-bs-toggle="tooltip" title="Quyền thêm tài khoản"
                                                                type="checkbox" aria-label="Select all invoices"
                                                                @if (in_array(16, $permissions)) checked @endif
                                                                value="16"></td>
                                                        <td><input name="permission[]"
                                                                class="form-check-input m-0 align-middle" type="checkbox"
                                                                data-bs-toggle="tooltip" title="Quyền sửa tài khoản"
                                                                aria-label="Select all invoices"
                                                                @if (in_array(17, $permissions)) checked @endif
                                                                value="17"></td>
                                                        <td><input name="permission[]"
                                                                class="form-check-input m-0 align-middle" type="checkbox"
                                                                data-bs-toggle="tooltip" title="Quyền xóa tài khoản"
                                                                aria-label="Select all invoices"
                                                                @if (in_array(18, $permissions)) checked @endif
                                                                value="18"></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="8">|-- Thêm mới tài khoản</td>

                                                    </tr>
                                                    <tr>
                                                        <td colspan="8">|-- Chỉnh sửa tài khoản</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="8">|-- Xóa bỏ tài khoản</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <span class="text-danger d-flex justify-content-start spanError"
                                        data-tag="permission">
                                        @error('permission')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer text-right">
                            <button id="btnSubmitAdd" type="button" data-id="{{ $role->id }}"
                                class="btn btn-indigo">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page_js')
    <script>
        $(document).ready(function() {

            $('#btnSubmitAdd').click(function(e) {
                e.preventDefault();
                // lấy dữ liệu từ form
                var formData = new FormData(this.form);
                // thực hiện Ajax
                $.ajax({

                    url: "{{ route('role.edit', ['id' => ':id']) }}".replace(':id', this.dataset
                        .id),
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        // // xử lý response từ server
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
                                text: 'Cập nhật vai trò không thành công',
                                icon: 'error'
                            });
                        }

                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
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
                                text: 'Đã xảy ra lỗi khi thực hiện cập nhật vai trò',
                                icon: 'error'
                            })
                            .then(function(error) {
                                location.reload();
                            })
                    }

                });
            });
        });
    </script>
    <!-- --------------------------------------------- !-->
@endSection
