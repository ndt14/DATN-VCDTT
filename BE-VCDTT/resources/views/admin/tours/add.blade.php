@extends('admin.common.layout')
@section('meta_title')
    Thêm mới tour
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
                        Quản lý tour
                    </h1>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ url('/tour') }}" class="btn btn-default d-none d-sm-inline-block">
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
                        <a href="{{ url('/tour') }}" class="btn btn-default d-sm-none btn-icon">
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
            <form class="row row-cards" id="frmAdd" action="{{ route('tour.add') }}" method="POST"
                enctype="multipart/form-data">
                <div class="col-sm-12 col-md-9">
                    <div class="card border-0 shadow-lg rounded-4 ">
                        <div class="card-header">
                            <h2 class="card-title">
                                Thêm tour
                            </h2>
                        </div>
                        @csrf
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Tên tour</label>
                                <input type="text" name="name" class="form-control" placeholder="Nhập tên cho tour"
                                    value="{{ old('name') ?? '' }}">
                                <span class="text-danger d-flex justify-content-start spanError" data-tag="name">
                                    @error('name')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="row">
                                <div class="mb-3 col">
                                    <label class="form-label">Ảnh đại diện</label>
                                    <div class="row g-2">
                                        <div class="col">
                                            <input type="text" name="main_img" class="form-control"
                                                placeholder="Link ảnh đại diện" value="{{ old('main_img') ?? '' }}">
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
                                    <span class="text-danger d-flex justify-content-start spanError" data-tag="main_img">
                                        @error('main_img')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-6">
                                    <div class="form-label">Điểm bắt đầu</div>
                                    <input name="start_destination" type="text" placeholder="Nhập điểm bắt đầu tour"
                                        class="form-control" value="{{ old('start_destination') ?? '' }}">
                                    <span class="text-danger d-flex justify-content-start spanError"
                                        data-tag="start_destination">
                                        @error('start_destination')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="mb-3 col-6">
                                    <div class="form-label">Điểm kết thúc</div>
                                    <input name="end_destination" type="text" placeholder="Nhập điểm kết thúc tour"
                                        class="form-control" value="{{ old('end_destination') ?? '' }}">
                                    <span class="text-danger d-flex justify-content-start spanError"
                                        data-tag="end_destination">
                                        @error('end_destination')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                            <div class="row">

                                <div class="mb-3 col-6">
                                    <div class="form-label">Vị trí tour</div>
                                    <input name="location" type="text" class="form-control"
                                        placeholder="Nhập vị trí của tour" value="{{ old('end_destination') ?? '' }}">
                                    <span class="text-danger d-flex justify-content-start spanError" data-tag="location">
                                        @error('location')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="mb-3 col-6">
                                    <div class="form-label">Vị trí chính xác tour</div>
                                    <input name="exact_location" type="text" class="form-control"
                                        placeholder="Nhập vị trí chính xác của tour"
                                        value="{{ old('exact_location') ?? '' }}">
                                    <span class="text-danger d-flex justify-content-start spanError"
                                        data-tag="exact_location">
                                        @error('exact_location')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>

                            </div>

                            <div class="row">
                                <div class="mb-3 col">
                                    <div class="form-label">Lịch trình tour</div>
                                    <textarea id="editor-schedule" rows="6" class="form-control" name="pathway"
                                        placeholder="Nhập lịch trình của tour">{{ old('pathway') ?? '' }}</textarea>
                                    <span class="text-danger d-flex justify-content-start spanError" data-tag="pathway">
                                        @error('pathway')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-12">
                                    <div class="form-label">Giá bao gồm</div>
                                    <textarea id="editor-includes" rows="6" class="form-control" name="includes" class="includes"
                                        placeholder="Giá tour bao gồm">{{ old('includes') ?? '' }}</textarea>
                                    <span class="text-danger d-flex justify-content-start spanError" data-tag="includes">
                                        @error('includes')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="mb-3 col-md-12">
                                    <div class="form-label">Nội dung mô tả</div>
                                    <textarea id="editor" rows="6" class="form-control" name="details" placeholder="Nhập nội dung mô tả">{{ old('details') ?? '' }}</textarea>
                                    <span class="text-danger d-flex justify-content-start spanError" data-tag="details">
                                        @error('details')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                            <input name="imgArray" type="hidden" id="imgArray">
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-3">
                    <div class="card border-0 shadow-lg rounded-4 ">
                        <div class="card-header">
                            <h2 class="card-title"><br></h2>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3 col-12">
                                    <label class="form-label">Khoảng thời gian</label>
                                    <input type="number" name="duration" class="form-control"
                                        placeholder="Nhập khoảng thời gian diễn ra tour"
                                        value="{{ old('duration') ?? '' }}">
                                    <span class="text-danger d-flex justify-content-start spanError" data-tag="duration">
                                        @error('duration')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-12">
                                    <div class="form-label">Giá người lớn</div>
                                    <input name="adult_price" type="number" placeholder="Nhập giá người lớn"
                                        class="form-control" value="{{ old('adult_price') ?? '' }}">
                                    <span class="text-danger d-flex justify-content-start spanError"
                                        data-tag="adult_price">
                                        @error('adult_price')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="mb-3 col-12">
                                    <div class="form-label">Giá trẻ nhỏ</div>
                                    <input name="child_price" type="number" placeholder="Nhập giá cho trẻ nhỏ"
                                        class="form-control" value="{{ old('child_price') ?? '' }}">
                                    <span class="text-danger d-flex justify-content-start spanError"
                                        data-tag="child_price">
                                        @error('child_price')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-3 col-12">
                                    <label class="form-label">Lựa chọn danh mục</label>
                                    <select type="text" class="form-select" name="categories_data[]"
                                        placeholder="Chọn danh mục" id="select-category" multiple></select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-3 col-12">
                                    <div class="form-label">Phần trăm giảm giá</div>
                                    <input name="sale_percentage" type="number" class="form-control"
                                        placeholder="Nhập phần trăm giảm giá" value="{{ old('sale_percentage') ?? '' }}">
                                    <span class="text-danger d-flex justify-content-start spanError"
                                        data-tag="sale_percentage">
                                        @error('sale_percentage')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>

                                <div class="mb-3 col-12">
                                    <div class="form-label">Số lượng hành khách</div>
                                    <input name="tourist_count" type="number" class="form-control"
                                        placeholder="Nhập số lượng hành khách" value="{{ old('tourist_count') ?? '' }}">
                                    <span class="text-danger d-flex justify-content-start spanError"
                                        data-tag="tourist_count">
                                        @error('tourist_count')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-12">
                                    <div class="form-label">Người thêm</div>
                                    <input name="creator" type="text" value="{{ Auth::user()->name ?? '' }}"
                                        placeholder="" class="form-control" readonly disabled>
                                </div>
                            </div>
                            <div class="mb-3 col-md-12 d-none">
                                <div class="form-label">Trạng thái</div>
                                <div class="custom-controls-stacked">
                                    <div class="" style="padding: 9px;">
                                        <label class="custom-control custom-radio custom-control-inline me-2">
                                            <input type="radio" class="custom-control-input"
                                                @if (old('status') == '1') checked @endif name="status"
                                                checked="" value="1">
                                            <span class="custom-control-label">Kích hoạt</span>
                                        </label>
                                        <label class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" class="custom-control-input"
                                                @if (old('status') == '0') checked @endif name="status"
                                                value="0">
                                            <span class="custom-control-label">Vô hiệu hóa</span>
                                        </label>
                                    </div>

                                    <span class="text-danger d-flex justify-content-start">
                                        @error('status')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button id="btnSubmitAdd" type="button" class="btn btn-indigo">Thêm mới</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>

    <div class="modal modal-blur fade" id="modalContainer" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            </div>
        </div>
    </div>
@endsection
@section('ckeditor_5')
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'), {
                ckfinder: {
                    uploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
                }
            })
            .then(editor => {
                editor.model.document.on('change:data', () => {
                    editorData = editor.getData();
                    $("#editor").text(editorData);

                });
            })
            .catch(error => {
                console.error(error);
            });
    </script>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor-includes'), {
                ckfinder: {
                    uploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
                }
            })
            .then(editor => {
                editor.model.document.on('change:data', () => {
                    editorData = editor.getData();
                    $("#editor-includes").text(editorData);

                });
            })
            .catch(error => {
                console.error(error);
            });
    </script>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor-schedule'), {
                ckfinder: {
                    uploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
                }
            })
            .then(editor => {
                editor.model.document.on('change:data', () => {
                    editorData = editor.getData();
                    $("#editor-schedule").text(editorData);

                });
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
@section('page_js')
    <script src="{{ asset('admin/assets/js/vendors/clipboard-polyfill.window-var.promise.es5.js') }}"></script>
    <script src="{{ asset('admin/assets/libs/tom-select/dist/js/tom-select.base.min.js') }}" defer></script>
    <script type="text/javascript">
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
                            if(category.child.length > 0){
                                option.prop('disabled', true);
                            }
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

    <!-- Thêm tour !-->
    <script>
        $(document).ready(function() {

            $('#btnSubmitAdd').click(function(e) {
                e.preventDefault();

                // lấy dữ liệu từ form
                var formData = new FormData(this.form);
                // thực hiện Ajax
                $.ajax({

                    url: "{{ route('tour.add') }}",
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
    <script type="text/javascript">
        $('.multi-file_insert_attach').click(function() {
            if ($('.list_attach').hasClass('show-btn') === false) {
                $('.list_attach').addClass('show-btn');
            }
            var _lastimg = jQuery('.multi-file_attach_view li').last().find('input[type="file"]').val();

            if (_lastimg != '') {
                var d = new Date();
                var _time = d.getTime();
                var _html = '<li id="li_files_' + _time + '" class="li_file_hide">';
                _html += '<div class="img-wrap">';
                _html += '<span class="close" onclick="DelImg(this)">×</span>';
                _html += ' <div class="img-wrap-box"></div>';
                _html += '</div>';
                _html += '<div class="' + _time + '">';
                _html +=
                    '<input type="file" class="hidden" name="files[]" multiple onchange="uploadImg(this)" id="files_' +
                    _time + '"   />';
                _html += '</div>';
                _html += '</li>';
                jQuery('.multi-file_attach_view').append(_html);
                jQuery('.multi-file_attach_view li').last().find('input[type="file"]').click();
            } else {
                if (_lastimg == '') {
                    jQuery('.multi-file_attach_view li').last().find('input[type="file"]').click();
                } else {
                    if ($('.list_attach').hasClass('show-btn') === true) {
                        $('.list_attach').removeClass('show-btn');
                    }
                }
            }
        });

        function uploadImg(el) {
            var file_data = $(el).prop('files')[0];
            var type = file_data.type;
            var fileToLoad = file_data;

            var fileReader = new FileReader();

            fileReader.onload = function(fileLoadedEvent) {
                var srcData = fileLoadedEvent.target.result;

                var newImage = document.createElement('img');
                newImage.src = srcData;
                var _li = $(el).closest('li');
                if (_li.hasClass('li_file_hide')) {
                    _li.removeClass('li_file_hide');
                }
                _li.find('.img-wrap-box').append(newImage.outerHTML);


            }
            fileReader.readAsDataURL(fileToLoad);

        }

        function DelImg(el) {
            jQuery(el).closest('li').remove();

        }
    </script>
@endSection
@section('page_css')
    <link rel="stylesheet" href="{{ asset('admin/assets/css/fancybox.css') }}" />
    <style>
        .list_attach {
            display: block;
            margin-top: 30px;
        }

        ul.multi-file_attach_view {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        ul.multi-file_attach_view li {
            float: left;
            width: 14%;
            margin: 0 2% 2% 0 !important;
            padding: 0 !important;
            border: 0 !important;
            overflow: inherit;
            clear: none;
        }

        ul.multi-file_attach_view .img-wrap {
            position: relative;
        }

        ul.multi-file_attach_view .img-wrap .close {
            position: absolute;
            right: -10px;
            top: -10px;
            background: #000;
            color: #fff !important;
            border-radius: 50%;
            z-index: 2;
            display: block;
            width: 20px;
            height: 20px;
            font-size: 16px;
            text-align: center;
            line-height: 18px;
            cursor: pointer !important;
            opacity: 1 !important;
            text-shadow: none;
        }

        ul.multi-file_attach_view li.li_file_hide {
            opacity: 0;
            visibility: visible;
            width: 0 !important;
            height: 0 !important;
            overflow: hidden;
            margin: 0 !important;
        }

        ul.multi-file_attach_view .img-wrap-box {
            position: relative;
            overflow: hidden;
            padding-top: 100%;
            height: auto;
            background-position: 50% 50%;
            background-size: cover;
        }

        .img-wrap-box img {
            right: 0;
            border-radius: 10px;
            width: 100% !important;
            height: 100% !important;
            bottom: 0;
            left: 0;
            top: 0;
            position: absolute;
            object-position: 50% 50%;
            object-fit: cover;
            transition: all .5s linear;
            -moz-transition: all .5s linear;
            -webkit-transition: all .5s linear;
            -ms-transition: all .5s linear;
        }

        .list_attach span.multi-file_insert_attach {
            width: 80px;
            height: 80px;
            text-align: center;
            display: inline-block;
            border: 2px dashed #ccc;
            line-height: 76px;
            font-size: 25px;
            color: #ccc;
            display: none;
            cursor: pointer;
        }

        ul.multi-file_attach_view {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        ul.multi-file_attach_view .img-wrap {
            position: relative;
        }

        .list_attach.show-btn span.multi-file_insert_attach {
            display: block;
            margin: 0 0 20px !important;
        }

        i.multi-file-plus {
            font-style: normal;
            font-weight: 900;
            font-size: 35px;
            line-height: 1;
        }

        ul.multi-file_attach_view li input {
            display: none;
        }
    </style>
@endsection
