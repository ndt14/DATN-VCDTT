@extends('admin.common.layout')
@section('meta_title')
    Chỉnh sửa danh mục
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
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="notiError">
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
                        Quản lý danh mục
                    </h1>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">


                        <a href="{{ route('category.list') }}" class="btn btn-default d-none d-sm-inline-block">

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
                        <a href="{{ url('/category') }}" class="btn btn-default d-sm-none btn-icon">
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
                        @csrf
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Tên</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter question"
                                    value="{{ $data->name }}">
                                <span class="text-danger d-flex justify-content-start spanError" data-tag="name">
                                    @error('name')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Thuộc danh mục cha</label>

                                <select class="form-select" name="parent_id"
                                    {{ count($listCateParent) <= 0 ? 'disabled' : '' }}>
                                    <option value="">Chưa thuộc danh mục cha nào</option>
                                    @foreach ($listCateParent as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $data->parent_id == $item->id ? 'selected' : '' }}>{{ $item->name }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>

                        </div>
                        <div class="card-footer text-right">
                            <button id="btnSubmitAdd" type="button" data-id="{{ $data->id }}"
                                class="btn btn-indigo">Cập nhật</button>
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
                var id = document.querySelector('#btnSubmitAdd').dataset.id;
                // lấy dữ liệu từ form
                var formData = new FormData(this.form);
                // thực hiện Ajax
                $.ajax({

                    url: "{{ route('category.edit', ['id' => ':id']) }}".replace(':id', id),
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
                                .then((response) => {
                                    if (response) {
                                        location.reload();
                                    }
                                });
                        } else {
                            Swal.fire({
                                    title: 'Lỗi!',
                                    text: response.message,
                                    icon: 'error'
                                })
                                .then((response) => {
                                    if (response) {
                                        location.reload();
                                    }
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
                                text: 'Đã xảy ra lỗi khi thực hiện sửa danh mục',
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
    {{-- <script type="text/javascript">
    if ($('#frmAdd').length) {
        $('#frmAdd').submit(function() {
            let options = {
                beforeSubmit: function(formData, jqForm, options) {
                    $('#btnSubmitAdd').addClass('btn-loading');
                    $('#btnSubmitAdd').addClass("disabled");
                },
                success: function(response, statusText, xhr, $form) {
                    $('#btnSubmitAdd').removeClass('btn-loading');
                    if (response.status == 404) {
                        $('#btnSubmitAdd').removeClass("disabled");
                        bs5Utils.Snack.show('danger', response.message, delay = 5000, dismissible = true);
                    }
                    if (response.status == 200) {
                        $('#btnSubmitAdd').removeClass("disabled");
                        bs5Utils.Snack.show('success', response.message, delay = 6000, dismissible = true);
                    }
                },
                error: function() {
                    $('#btnSubmitAdd').removeClass('btn-loading');
                    $('#btnSubmitAdd').removeClass("disabled");
                    bs5Utils.Snack.show('danger', response.message, delay = 5000, dismissible = true);
                },
                dataType: 'json',
                clearForm: false,
                resetForm: false
            };
            $(this).ajaxSubmit(options);
            return false;
        });
    }
</script> --}}
@endSection
