@extends('admin.common.layout')
@section('meta_title')
    Cập nhật bài viết
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
                        Quản lý bài viết
                    </h1>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ url('/blog') }}" class="btn btn-default d-none d-sm-inline-block">
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
                        <a href="{{ url('/blog') }}" class="btn btn-default d-sm-none btn-icon">
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
                    <form id="frmAdd" class="card border-0 shadow-lg rounded-4 "
                        method="POST">
                        <div class="card-header">
                            <h2 class="card-title">
                                Cập nhật bài viết
                            </h2>
                        </div>
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3 col-6">
                                    <label class="form-label">Tiêu đề</label>
                                    <input type="text" name="title" class="form-control" placeholder="Title"
                                        value="{{$response['title']}}">
                                        <span class="text-danger d-flex justify-content-start spanError" data-tag="title">
                                            @error('title')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                </div>
                                <div class="mb-3 col-6">
                                    <label class="form-label">Tác giả</label>
                                    <input type="text" name="author" class="form-control" placeholder="" value="{{$response['author']}}">
                                    <span class="text-danger d-flex justify-content-start spanError" data-tag="author">
                                        @error('author')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>

                            </div>
                            <div class="mb-3 col-8">
                                <label class="form-label">Ảnh</label>
                                <input type="text" name="main_img" class="form-control" placeholder="Image"
                                    value="{{$response['main_img']}}">
                                    <span class="text-danger d-flex justify-content-start spanError" data-tag="main_img">
                                        @error('main_img')
                                            {{ $message }}
                                        @enderror
                                    </span>
                            </div>
                            <div class="mb-3">
                                <div class="form-label">Mô tả ngắn</div>
                                <textarea id="editor-1" name="short_desc" rows="5" type="text" class="form-control">{{$response['short_desc']}}</textarea>
                                <span class="text-danger d-flex justify-content-start spanError" data-tag="short_desc">
                                    @error('short_desc')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="mb-3">
                                <div class="form-label">Mô tả</div>
                                <textarea id="editor-2" rows="6" class="form-control text-editor ckeditor" name="description">{{$response['description']}}</textarea>
                                <span class="text-danger d-flex justify-content-start spanError" data-tag="description">
                                    @error('description')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="mb-3">
                                <div class="form-label">Trạng thái</div>
                                <div class="custom-controls-stacked">
                                    <label class="custom-control custom-radio custom-control-inline me-2">
                                        <input type="radio" class="custom-control-input" name="status" @if($response['status'] == 1) checked @endif
                                            value="1">
                                        <span class="custom-control-label">Hoạt động</span>
                                    </label>
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" name="status"
                                            value="0" @if($response['status'] == 0) checked @endif>
                                        <span class="custom-control-label">Vô hiệu hóa</span>
                                    </label>

                                    <span class="text-danger d-flex justify-content-start">
                                        @error('status')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <button id="btnSubmitAdd" type="button" class="btn btn-indigo" data-id="{{$response['id']}}">Cập nhật</button>
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
@section('ckeditor_5')
    <script>
        ClassicEditor
            .create(document.querySelector('#editor-1'), {
                ckfinder: {
                    uploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
                }
            })
            .then(editor => {
                editor.model.document.on('change:data', () => {
                    editorData = editor.getData();
                    $("#editor-1").text(editorData);

                });
            })
            .catch(error => {
                console.error(error);
            });
    </script>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor-2'), {
                ckfinder: {
                    uploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
                }
            })
            .then(editor => {
                editor.model.document.on('change:data', () => {
                    editorData = editor.getData();
                    $("#editor-2").text(editorData);

                });
            })
            .catch(error => {
                console.error(error);
            });
    </script>

    <!-- Thêm blog !-->
    <script>
        $(document).ready(function() {

            $('#btnSubmitAdd').click(function(e) {
                e.preventDefault();
                var id = document.getElementById('btnSubmitAdd').dataset.id;
                // lấy dữ liệu từ form
                var formData = new FormData(this.form);
                // thực hiện Ajax
                $.ajax({

                    url: "{{ route('blog.edit', ['id' => ':id']) }}".replace(':id', id),
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
                            });
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
                            text: 'Đã xảy ra lỗi khi thực hiện cập nhật bài viết',
                            icon: 'error'
                        })
                        .then(function(status) {
                            location.reload();
                        })
                    }

                });
            });
        });
    </script>
    <!-- --------------------------------------------- !-->
@endsection
@section('page_js')
    <script type="text/javascript">
        //     if ($('#frmAdd').length) {
        //         $('#frmAdd').submit(function() {
        //             let options = {
        //                 beforeSubmit: function(formData, jqForm, options) {
        //                     $('#btnSubmitAdd').addClass('btn-loading');
        //                     $('#btnSubmitAdd').addClass("disabled");
        //                 },
        //                 success: function(response, statusText, xhr, $form) {
        //                     $('#btnSubmitAdd').removeClass('btn-loading');
        //                     if(response.status == 500){
        //                         $('#btnSubmitAdd').removeClass("disabled");
        //                         bs5Utils.Snack.show('danger', response.message, delay = 5000, dismissible = true);
        //                     }
        //                     if(response.status == 200){
        //                         $('#btnSubmitAdd').removeClass("disabled");
        //                         bs5Utils.Snack.show('success', response.message, delay = 6000, dismissible = true);
        //                     }
        //                 },
        //                 error: function() {
        //                     $('#btnSubmitAdd').removeClass('btn-loading');
        //                     $('#btnSubmitAdd').removeClass("disabled");
        //                     bs5Utils.Snack.show('danger', 'Error, please check your input', delay = 5000, dismissible = true);
        //                 },
        //                 dataType: 'json',
        //                 clearForm: false,
        //                 resetForm: false
        //             };
        //             $(this).ajaxSubmit(options);
        //             return false;
        //         });
        // }
    </script>
@endSection
