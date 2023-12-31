@extends('admin.common.layout')
@section('meta_title')
    Danh sách vai trò
@endSection
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Quản lý Vai trò
                    </h2>
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
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('role.add') }}" class="btn btn-indigo d-none d-sm-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <line x1="12" y1="5" x2="12" y2="19" />
                                <line x1="5" y1="12" x2="19" y2="12" />
                            </svg>
                            Thêm mới
                        </a>
                        <a href="{{ url('/role/add') }}" class="btn btn-indigo d-sm-none btn-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <line x1="12" y1="5" x2="12" y2="19" />
                                <line x1="5" y1="12" x2="19" y2="12" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Vai trò</h3>
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
                                            <label class="visually-hidden" for="autoSizingInput">Từ khóa</label>
                                            <input type="text" name="keyword" class="form-control"
                                                placeholder="tên vai trò">
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-indigo">Tìm kiếm</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="table table-responsive">
                            <table class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                    <tr>
                                        <th class="w-1">ID</th>
                                        <th>Tên vai trò</th>
                                        <th>Mô tả</th>
                                        <th>Ngày tạo</th>
                                        <th>Ngày sửa</th>
                                        <th></th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($data))
                                        @foreach ($data as $item)
                                            <tr>
                                                <td><span class="text-muted">{{ $item->id }}</span></td>
                                                <td>
                                                    <a href="javascript: viewDetail({{ $item->id }});"
                                                        title="Show Detail">{{ string_truncate($item->name, 70) }}</a>
                                                </td>
                                                <td>
                                                    {{ string_truncate($item->desc_role, 70) }}
                                                </td>
                                                <td>
                                                    {{ time_format($item->created_at) }}
                                                </td>
                                                <td>
                                                    {{ time_format($item->updated_at) }}
                                                </td>
                                                @if (!($item->name == 'Admin'))
                                                    <td class="text-end">
                                                        <a class="btn btn-icon btn-outline-green"
                                                            href="{{ route('role.edit', ['id' => $item->id]) }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="icon icon-tabler icon-tabler-edit" width="24"
                                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                                stroke="currentColor" fill="none"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none">
                                                                </path>
                                                                <path
                                                                    d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1">
                                                                </path>
                                                                <path
                                                                    d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z">
                                                                </path>
                                                                <path d="M16 5l3 3"></path>
                                                            </svg>
                                                        </a>
                                                        <a class="btn btn-icon btn-outline-red"
                                                            href="javascript: removeItem({{ $item->id }})">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="icon icon-tabler icon-tabler-trash" width="24"
                                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                                stroke="currentColor" fill="none"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none">
                                                                </path>
                                                                <path d="M4 7l16 0"></path>
                                                                <path d="M10 11l0 6"></path>
                                                                <path d="M14 11l0 6"></path>
                                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12">
                                                                </path>
                                                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                                            </svg>
                                                        </a>
                                                    </td>
                                                @endif
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
                                bản ghi
                            </p>

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
                                    @if ( $data->currentPage() < $data->lastPage() - 3)
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
@section('page_js')
    <script type="text/javascript">
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
                content: 'Bạn có chắc muốn xóa?',
                columnClass: 'col-md-3 col-sm-6',
                buttons: {
                    removeButton: {
                        text: 'Được rồi!',
                        btnClass: 'btn-danger',
                        action: function() {
                            axios.delete(`/api/role-destroy/${id}`).then(function(response) {
                                Swal.fire({
                                        title: 'Thành công!',
                                        text: 'Xóa vai trò thành công',
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
