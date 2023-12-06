@extends('admin.common.layout')
@section('meta_title')
    Thêm mới bài viết
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
                    <form id="frmAdd" class="card border-0 shadow-lg rounded-4 " action="{{ route('blog.add') }}"
                        method="POST">
                        <div class="card-header">
                            <h2 class="card-title">
                                Thêm bài viết mới
                            </h2>
                        </div>
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3 col-6">
                                    <label class="form-label">Tiêu đề</label>
                                    <input type="text" name="title" class="form-control" placeholder="Title"
                                        value="">
                                    <span class="text-danger d-flex justify-content-start spanError" data-tag="title">
                                        @error('title')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="mb-3 col-6">
                                    <label class="form-label">Tác giả</label>
                                    <input type="text" name="author" class="form-control" placeholder="" value="">
                                    <span class="text-danger d-flex justify-content-start spanError" data-tag="author">
                                        @error('author')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>

                            </div>
                            <label class="form-label">Ảnh</label>

                            <div class="row">
                                <div class="mb-3 col-8">
                                    <input type="text" name="main_img" class="form-control" placeholder="Image"
                                        value="">
                                    <span class="text-danger d-flex justify-content-start spanError" data-tag="main_img">
                                        @error('main_img')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="col-auto">
                                    <a href="/image/dropzone" target="_blank" class="btn btn-icon btn-indigo"
                                        aria-label="Button">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-upload" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path>
                                            <path d="M7 9l5 -5l5 5"></path>
                                            <path d="M12 4l0 12"></path>
                                        </svg>
                                    </a>
                                </div>
                                <div class="col-auto">
                                    <a href="javascript: viewImageList();" class="btn btn-icon btn-indigo"
                                        aria-label="Button">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-photo-search" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M15 8h.01"></path>
                                            <path
                                                d="M11.5 21h-5.5a3 3 0 0 1 -3 -3v-12a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v5.5">
                                            </path>
                                            <path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                                            <path d="M20.2 20.2l1.8 1.8"></path>
                                            <path d="M3 16l5 -5c.928 -.893 2.072 -.893 3 0l2 2"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            <div class="mb-3 col-12">
                                <label class="form-label">Lựa chọn danh mục</label>
                                <select type="text" class="form-select" name="categories_data[]"
                                    placeholder="Chọn danh mục" id="select-category" multiple></select>
                            </div>
                            <div class="mb-3">
                                <div class="form-label">Mô tả ngắn</div>
                                <textarea id="editor-1" name="short_desc" rows="5" type="text" class="form-control"></textarea>
                                <span class="text-danger d-flex justify-content-start spanError" data-tag="short_desc">
                                    @error('short_desc')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="mb-3">
                                <div class="form-label">Mô tả</div>
                                <textarea id="editor-2" rows="6" class="form-control text-editor ckeditor" name="description"></textarea>
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
                                        <input type="radio" class="custom-control-input" name="status" checked=""
                                            value="1">
                                        <span class="custom-control-label">Hoạt động</span>
                                    </label>
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" name="status"
                                            value="0">
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
                            <button id="btnSubmitAdd" type="button" class="btn btn-indigo">Thêm mới</button>
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
    <script src="{{ asset('admin/assets/js/vendors/clipboard-polyfill.window-var.promise.es5.js') }}"></script>

    <!-- Thêm blog !-->
    <script>
                let viewImageList = function() {
            axios.get(`/image/image-list`)
                .then(function(response) {
                    $('#modalContainer div.modal-content').html(response.data.html);
                    modalContainer.show();
                })
                .catch(function(error) {
                    bs5Utils.Snack.show('danger', 'Error', delay = 5000, dismissible = true);
                })
                .finally(function() {});
        };
        Fancybox.bind('[data-fancybox]');
        $('.btn-copy-url').click(function() {
            let _self = $(this);
            let url = _self.attr('data-url');
            clipboard.writeText(url).then(function() {
                bs5Utils.Snack.show('success', 'Đã copy đường dẫn thành công!', delay = 5000, dismissible =
                    true);
            }, function(err) {
                bs5Utils.Snack.show('danger', 'Lỗi.', delay = 5000, dismissible = true);
            });
        });
        $(document).ready(function() {

            $('#btnSubmitAdd').click(function(e) {
                e.preventDefault();

                // lấy dữ liệu từ form
                var formData = new FormData(this.form);
                // thực hiện Ajax
                $.ajax({

                    url: "{{ route('blog.add') }}",
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
                            text: 'Đã xảy ra lỗi khi thực hiện thêm tour',
                            icon: 'error'
                        });
                    }

                });
            });
        });
    </script>
    <!-- --------------------------------------------- !-->
@endsection
@section('page_js')
    <script src="{{ asset('admin/assets/libs/tom-select/dist/js/tom-select.base.min.js') }}" defer></script>
    <script type="text/javascript">
        $(document).ready(function() {
            modalContainer = new bootstrap.Modal('#modalContainer', {
                keyboard: true,
                backdrop: 'static'
            });

            let categories_data = [];
            if ($('#frmAdd').length) {
                $.ajax({
                    url: "/api/category",
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        //gender category
                        let selectCatogories = $('#select-category');
                        $.each(response.data.categoriesParent, function(index, category) {
                            let id = category.id
                            id = +id
                            let option = $('<option></option>').val(id).text(category.name);
                            selectCatogories.append(option);
                            $.each(category.child, function(index, childCategory) {
                                let chlidId = childCategory.id;
                                chlidId = +chlidId;
                                let option = $('<option></option>').val(chlidId).text(
                                    '(' + category.name + ')' + ' - ' +
                                    childCategory.name);
                                selectCatogories.append(option);
                            });
                        });

                        //add to select by tom-select lib
                        let el;
                        window.TomSelect && (new TomSelect(el = document.getElementById(
                            'select-category'), {
                            copyClassesToDropdown: false,
                            dropdownParent: 'body',
                            controlInput: '<input>',
                            render: {
                                item: function(data, escape) {
                                    if (data.customProperties) {
                                        return '<div><span class="dropdown-item-indicator">' +
                                            data.customProperties + '</span>' + escape(
                                                data.text) + '</div>';
                                    }
                                    return '<div>' + escape(data.text) + '</div>';
                                },
                                option: function(data, escape) {
                                    if (data.customProperties) {
                                        return '<div><span class="dropdown-item-indicator">' +
                                            data.customProperties + '</span>' + escape(
                                                data.text) + '</div>';
                                    }
                                    return '<div>' + escape(data.text) + '</div>';
                                },
                            },
                        }));
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }
            $('#select-category').change(function() {
                catogories_data = $(this).val();
            });
        });
    </script>
@endSection
