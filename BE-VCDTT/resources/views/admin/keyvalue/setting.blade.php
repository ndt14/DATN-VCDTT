@extends('admin.common.layout')
@section('meta_title')
    Hệ thống
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
                        Hệ thống
                    </h1>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-sm-12">
                    <form id="frmAdd" class="card border-0 shadow-lg rounded-4 row" action=""
                        method="POST" enctype="multipart/form-data">
                        <div class="card-header"> <h2 class="card-title">Chỉnh sửa hệ thống</h2>
                        </div>
                        @csrf
                        <div class="card-body">
                            <div class="row mb-3">
                                @foreach ($data as $item)
                                    @if ($item->key == 'webTitle' || $item->key == 'email' || $item->key == 'facebookLink' || $item->key == 'address')
                                        <div class="mb-3 col-12 col-md">
                                            <label class="form-label">{{ $item->name }}</label>
                                            <input type="text" name="{{ $item->key }}" class="form-control"
                                                value="{{ $item->value }}">
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <div class="row mb-3">
                                @foreach ($data as $item)
                                    @if ($item->key == 'metaTitle' || $item->key == 'metaDescription' || $item->key == 'webPhoneNumber1' || $item->key == 'webPhoneNumber2')
                                        <div class="mb-3 col-12 col-md">
                                            <label class="form-label">{{ $item->name }}</label>
                                            <input type="text" name="{{ $item->key }}" class="form-control"
                                                value="{{ $item->value }}">
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <div class="row mb-3">
                                @foreach ($data as $item)
                                    @if ($item->key == 'bankName' || $item->key == 'bankAccountName' || $item->key == 'bankAccountNumber' || $item->key == 'bankingContent')
                                        <div class="mb-3 col-12 col-md">
                                            <label class="form-label">{{ $item->name }}</label>
                                            <input type="text" name="{{ $item->key }}" class="form-control"
                                                value="{{ $item->value }}">
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <div class="row mb-3">
                                @foreach ($data as $item)
                                    @if ($item->key == 'BankAccountQR' || $item->key == 'loadingScreen' || $item->key == 'logo' || $item->key == 'favicon' || $item->key == 'subBanner')
                                        <div class="mb-3 col-12 col-md">
                                            <label class="form-label">{{ $item->name }}</label>
                                            <div class="row">
                                                <div class="col-10">
                                                    <input type="text" name="{{ $item->key }}" class="form-control"
                                                        value="{{ $item->value }}">
                                                </div>
                                                    <a href="javascript:void(0);"
                                                        onclick="viewImageShow('{{ $item->value }}');"
                                                        class="btn btn-icon btn-indigo col" aria-label="Button">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="icon icon-tabler icon-tabler-zoom-scan" width="24"
                                                            height="24" viewBox="0 0 24 24" stroke-width="2"
                                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M4 8v-2a2 2 0 0 1 2 -2h2" />
                                                            <path d="M4 16v2a2 2 0 0 0 2 2h2" />
                                                            <path d="M16 4h2a2 2 0 0 1 2 2v2" />
                                                            <path d="M16 20h2a2 2 0 0 0 2 -2v-2" />
                                                            <path d="M8 11a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                                                            <path d="M16 16l-2.5 -2.5" />
                                                        </svg>
                                                    </a>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-10">
                                                    <input id="image-input-{{ $item->key }}" type="file"
                                                        name="{{ $item->key }}" class="form-control">
                                                </div>
                                                    <span onclick="showImage('{{ $item->key }}')"
                                                        class="btn btn-icon btn-indigo col" aria-label="Button"
                                                        id="image-button-{{ $item->key }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="icon icon-tabler icon-tabler-zoom-scan" width="24"
                                                            height="24" viewBox="0 0 24 24" stroke-width="2"
                                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M4 8v-2a2 2 0 0 1 2 -2h2" />
                                                            <path d="M4 16v2a2 2 0 0 0 2 2h2" />
                                                            <path d="M16 4h2a2 2 0 0 1 2 2v2" />
                                                            <path d="M16 20h2a2 2 0 0 0 2 -2v-2" />
                                                            <path d="M8 11a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                                                            <path d="M16 16l-2.5 -2.5" />
                                                        </svg>
                                                    </span>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <div class="row mb-3">
                                @foreach ($data as $item)
                                    @if ($item->key == 'banner')
                                        <div class="mb-3 col-12 col-md">
                                            <label class="form-label row">{{ $item->name }}</label>
                                            <div class="row">
                                                <a href="javascript:void(0);"
                                                    onclick="bannerEdit('');"
                                                    class="btn btn-icon btn-indigo" aria-label="Button">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-layers-intersect"
                                                        width="24" height="24" viewBox="0 0 24 24"
                                                        stroke-width="2" stroke="currentColor" fill="none"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path
                                                            d="M8 4m0 2a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2z" />
                                                        <path
                                                            d="M4 8m0 2a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2z" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-middle modal-l">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="imageModalLabel">Xem ảnh
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <img id="modalImage" src="" alt="Xem ảnh" style="width: 100%;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button id="btnSubmitAdd" type="button" class="btn btn-indigo">Lưu</button>
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
    <script src="{{ asset('admin/assets/js/vendors/clipboard-polyfill.window-var.promise.es5.js') }}"></script>
    <script src="{{ asset('admin/assets/libs/tom-select/dist/js/tom-select.base.min.js') }}" defer></script>
    <script>
        $(document).ready(function() {

            $('#btnSubmitAdd').click(function(e) {
                e.preventDefault();

                // lấy dữ liệu từ form
                var formData = new FormData(this.form);
                // thực hiện Ajax
                $.ajax({

                    url: "{{ route('settings') }}",
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
                                if(response) {
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
                            text: 'Đã xảy ra lỗi khi thực hiện cập nhật hệ thống',
                            icon: 'error'
                        });
                    }

                });
            });
        });
    </script>
    <!-- --------------------------------------------- !-->

    <script type="text/javascript">
        let viewImageShow = function(imageValue) {
            axios.get('/image/image-show', {
                    params: {
                        imageValue
                    }
                })
                .then(function(response) {
                    $('#modalContainer div.modal-content').html(response.data.html);
                    modalContainer.show();
                })
                .catch(function(error) {
                    bs5Utils.Snack.show('danger', 'Error', delay = 5000, dismissible = true);
                })
                .finally(function() {});
        };

        function showImage(identifier) {
            const fileInput = document.getElementById('image-input-' + identifier);
            const modalImage = document.getElementById('modalImage');
            const imageButton = document.getElementById('image-button-' + identifier);

            if (fileInput.files && fileInput.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    modalImage.src = e.target.result;
                    $('#imageModal').modal('show'); // Open the modal
                }

                reader.readAsDataURL(fileInput.files[0]);
            } else {
                // Display error message or indicate no image
                modalImage.src = ''; // Clear the modal image source
                modalImage.alt = 'No Image'; // Set alt text for no image indication
                $('#imageModal').modal('show'); // Open the modal
            }
        }

        let bannerEdit = function(banner_id) {
            let urlT = '/image/banner-edit?id=' + banner_id;
            console.log(urlT);
            axios.get(urlT)
                .then(function(response) {
                    $('#modalContainer div.modal-content').html(response.data.html);
                    modalContainer.show();
                    Fancybox.bind('[data-fancybox]');
                    $('.btn-copy-url').click(function() {
                        let _self = $(this);
                        let url = _self.attr('data-url');
                        clipboard.writeText(url).then(function() {
                            bs5Utils.Snack.show('success', 'Copy thành công', delay = 5000,
                                dismissible = true);
                        }, function(err) {
                            bs5Utils.Snack.show('danger', 'Không thể copy.', delay = 5000,
                                dismissible = true);
                        });
                    });
                    if(banner_id!=""){
                    bannerEdit("");
                    }
                })
                .catch(function(error) {
                    bs5Utils.Snack.show('danger', 'Error', delay = 5000, dismissible = true);
                })
                .finally(function(){});
        };
    </script>
@endSection
