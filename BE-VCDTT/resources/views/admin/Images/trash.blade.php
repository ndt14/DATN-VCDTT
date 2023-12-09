@extends('admin.common.layout')
@section('meta_title')
    Thư viện ảnh
@endSection
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h1 class="text-indigo mb-4" style="font-size: 36px;">
                        Quản lý thư viện ảnh
                    </h1>
                </div>
                <!-- <div class="col-12 ">
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
                    </div> -->
                
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card border-0 shadow-lg rounded-4 ">
                        <div class="card-header">
                            <h3 class="card-title">Ảnh</h3> <a href=""
                                style="padding-left: 5px; text-decoration: none; color: black; font-weight: 700;"><span
                                    style="color: black;">|</span> Thùng rác</a>

                                    <div class="col-auto ms-auto d-print-none">
                                        <div class="btn-list">
                    
                    
                                            <a href="{{ route('image.list') }}" class="btn btn-default d-none d-sm-inline-block">
                    
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
                                            <a href="{{ url('/image') }}" class="btn btn-default d-sm-none btn-icon">
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
                        <div class="card-body border-bottom py-3">
                            <div class="d-flex">
                                <!--<div class="text-muted">
                                        Show
                                        <div class="mx-2 d-inline-block">
                                            <input type="text" class="form-control form-control-sm" value="8" size="3" aria-label="Invoices count">
                                        </div>
                                        entries
                                    </div>-->
                                <div class="ms-auto text-muted">
                                    <form method="get" action="" class="row gy-2 gx-3 align-items-center">
                                        <div class="col-auto">
                                            <label class="visually-hidden" for="autoSizingSelect">Trạng thái</label>
                                            <select class="form-select" name="lang_code">
                                                <option value="">Chọn trạng thái</option>
                                                <option value="ja">Đang hoạt động</option>
                                                <option value="en">Không hoạt động</option>
                                            </select>
                                        </div>
                                        <div class="col-auto">
                                            <label class="visually-hidden" for="autoSizingInput">Từ khóa</label>
                                            <input type="text" name="keyword" value="" class="form-control"
                                                placeholder="Từ khóa">
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-indigo">Tìm</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="table table-responsive">
                            <table class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                    <tr>
                                        <th class="">Ảnh</th>
                                        <th class="w-1">Áp dụng cho</th>
                                        <th>Tên Ảnh</th>
                                        <th>Định dạng</th>
                                        <th>Đường dẫn</th>
                                        <th>Ngày thêm</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($data)
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>
                                                    <a data-fancybox data-src="{{ $item->url }}"
                                                        href="javascript:void(0);">
                                                        <img style="width: 150px; height: 90px; object-fit: cover;"
                                                            src="{{ $item->url }}" alt="{{ $item->name }}">
                                                    </a>
                                                </td>
                                                <td><span
                                                        class="text-muted">{{ string_truncate($item->tour_name, 70) }}</span>
                                                </td>
                                                <td>
                                                    {{ string_truncate($item->name, 70) }}
                                                </td>
                                                <td>
                                                    {{ $item->type }}
                                                </td>
                                                <td>
                                                    {{ $item->url }}
                                                </td>
                                                <td>
                                                    {{ time_format($item->created_at) }}
                                                </td>
                                                <td class="text-end">
                                                    <button class="btn btn-icon btn-outline-green"
                                                        onclick="restoreImage({{ $item->id }})">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="icon icon-tabler icon-tabler-clock-up" width="24"
                                                            height="24" viewBox="0 0 24 24" stroke-width="2"
                                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none">
                                                            </path>
                                                            <path d="M20.983 12.548a9 9 0 1 0 -8.45 8.436"></path>
                                                            <path d="M19 22v-6"></path>
                                                            <path d="M22 19l-3 -3l-3 3"></path>
                                                            <path d="M12 7v5l2.5 2.5"></path>
                                                        </svg>
                                                    </button>
                                                    <a class="btn btn-icon btn-outline-red"
                                                        href="javascript: removeItem({{ $item->id }})"
                                                        title="Xoá">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="icon icon-tabler icon-tabler-trash" width="24"
                                                            height="24" viewBox="0 0 24 24" stroke-width="2"
                                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <path d="M4 7l16 0"></path>
                                                            <path d="M10 11l0 6"></path>
                                                            <path d="M14 11l0 6"></path>
                                                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                                        </svg>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="9">
                                                <div>Không có dữ liệu</div>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer d-flex align-items-center">
                            @php
                                $pageLimits = [5, 10, 20, 50, 100, 250, 300];
                            @endphp
                            <select id="rpp" class="form-select me-2" style="max-width: 75px;">
                                @foreach ($pageLimits as $p)
                                    <option {{ $data->perPage() == $p ? 'selected' : '' }} value="{{ $p }}">
                                        {{ $p }}</option>
                                @endforeach
                            </select>

                            <p class="m-0 text-secondary">Hiển thị <span>{{ $data->currentPage() }}</span> trên
                                <span>{{ $data->lastPage() }}</span> của <span>{{ $data->total() }}</span>
                                bản ghi</p>

                            <ul class="pagination m-0 ms-auto">
                                <li class="page-item {{ $data->currentPage() != 1 ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $data->previousPageUrl() }}" tabindex="-1"
                                        aria-disabled="true">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M15 6l-6 6l6 6"></path>
                                        </svg>prev</a>
                                </li>
                                <li class="page-item {{ $data->currentPage() == 1 ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $data->url(1) }}">1</a>
                                </li>
                                @if (1 + 2 != $data->currentPage() && $data->currentPage() > 4)
                                    <li class="page-item">
                                        ...
                                    </li>
                                @endif
                                @for ($page = max(2, $data->currentPage() - 2); $page <= $data->currentPage() + 2 && $page <= $data->lastPage(); $page++)
                                    <li class="page-item {{ $page == $data->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $data->url($page) }}">{{ $page }}</a>
                                    </li>
                                @endfor
                                @if ($data->currentPage() < $data->lastPage() - 3)
                                    <li class="page-item">
                                        ...
                                    </li>
                                @endif
                                @if ($data->lastPage() != 1 && $data->currentPage() < $data->lastPage() - 2)
                                    <li class="page-item {{ $page == $data->currentPage() ? 'active' : '' }}">
                                        <a class="page-link"
                                            href="{{ $data->url($data->lastPage()) }}">{{ $data->lastPage() }}</a>
                                    </li>
                                @endif
                                <li class="page-item {{ $data->currentPage() != $data->lastPage() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $data->nextPageUrl() }}">Next
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M9 6l6 6l-6 6"></path>
                                        </svg>
                                    </a>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-blur fade" id="modalContainer" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            </div>
        </div>
    </div>
@endSection
@section('page_css')
    <link rel="stylesheet" href="{{ asset('admin/assets/css/fancybox.css') }}" />
@endSection
@section('page_js')
    <script src="{{ asset('admin/assets/js/vendors/clipboard-polyfill.window-var.promise.es5.js') }}"></script>
    <script src="{{ asset('admin/assets/js/vendors/fancybox.umd.js') }}"></script>
    <script>
        // Đặt mã JS vào đây hoặc tải từ file JS riêng

        function restoreImage(id) {
            // Gọi Ajax để khôi phục danh mục
            $.ajax({
                url: '/image/restore/' + id, // Thay đổi đúng route của bạn
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    console.log(response.data);
                    if (response.success) {
                        // Hiển thị modal thành công bằng SweetAlert2
                        Swal.fire({
                                title: 'Thành công!',
                                text: 'Khôi phục ảnh thành công',
                                icon: 'success'
                            })
                            .then(() => {
                                // Chuyển hướng sau khi hiển thị modal
                                window.location.href = '/image/trash'; // Thay đổi đúng route của bạn
                            });
                    } else {
                        // Xử lý trường hợp lỗi (nếu cần)
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Đã xảy ra lỗi khi khôi phục ảnh!'
                        });
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            modalContainer = new bootstrap.Modal('#modalContainer', {
                keyboard: true,
                backdrop: 'static'
            });

            Fancybox.bind('[data-fancybox]');
            $('.btn-copy-url').click(function() {
                let _self = $(this);
                let url = _self.attr('data-url');
                clipboard.writeText(url).then(function() {
                    bs5Utils.Snack.show('success', 'Đã copy đường dẫn thành công!', delay = 5000,
                        dismissible = true);
                }, function(err) {
                    bs5Utils.Snack.show('danger', 'Lỗi.', delay = 5000, dismissible = true);
                });
            });
        });

        let viewDetail = function(id) {
            axios.get(`/faq/detail/${id}`)
                .then(function(response) {
                    $('#modalContainer div.modal-content').html(response.data.html);
                    modalContainer.show();
                })
                .catch(function(error) {
                    bs5Utils.Snack.show('danger', 'Error', delay = 5000, dismissible = true);
                })
                .finally(function() {});
        };

        let removeItem = function(id) {
            $.confirm({
                theme: theme,
                title: 'Xác nhận',
                content: 'Xóa vĩnh viễn ảnh?',
                columnClass: 'col-md-3 col-sm-6',
                buttons: {
                    removeButton: {
                        text: 'Được rồi!',
                        btnClass: 'btn-danger',
                        action: function() {
                            axios.delete(`/image/destroy-forever/${id}`).then(function(response) {
                                Swal.fire({
                                        title: 'Thành công!',
                                        text: 'Xóa ảnh thành công',
                                        icon: 'success'
                                    })
                                    .then((response) => {
                                        if (response) {
                                            location.reload();
                                        }
                                    });
                            });
                        }
                    },
                    close: {
                        text: 'Không',
                        function() {}
                    }
                }
            });
        };
    </script>
@endSection
