@extends('admin.common.layout')
@section('meta_title')
    Danh sách danh mục
@endSection
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h1 class="text-indigo mb-4" style="font-size: 36px;">
                        Quản lý danh mục
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
                            <h3 class="card-title">Danh mục</h3>
                            @if (auth()->user()->is_admin == 1 ||
                                    auth()->user()->can('delete category'))
                                <a href="{{ route('cate.trash') }}" style="padding-left: 5px; text-decoration: none;"><span
                                        style="color: black;">|</span> Thùng rác</a>
                            @endif
                            @if (auth()->user()->can('add category') || auth()->user()->is_admin == 1)
                                <div class="col-auto ms-auto d-print-none">
                                    <div class="btn-list">
                                        <a href="{{ route('category.add') }}"
                                            class="btn btn-indigo d-none d-sm-inline-block">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <line x1="12" y1="5" x2="12" y2="19" />
                                                <line x1="5" y1="12" x2="19" y2="12" />
                                            </svg>
                                            Thêm mới
                                        </a>
                                        <a href="{{ route('category.add') }}" class="btn btn-indigo d-sm-none btn-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <line x1="12" y1="5" x2="12" y2="19" />
                                                <line x1="5" y1="12" x2="19" y2="12" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            @endif
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
                                        @php
                                            $tableCols = [
                                                'child' => 'Con',
                                                'name' => 'Tên',
                                                'created_at' => 'Ngày tạo',
                                                'updated_at' => 'Ngày sửa',
                                            ];
                                        @endphp
                                        <div class="col-auto">
                                            <label class="visually-hidden" for="autoSizingSelect">Trạng thái</label>
                                            <select class="form-select" name="searchCol">
                                                @if (!request()->query('searchCol'))
                                                    <option value="">Chọn cột</option>
                                                @else
                                                    <option value="">Mặc định</option>
                                                @endif
                                                <option value="id">ID</option>
                                                @foreach ($tableCols as $key => $value)
                                                    <option {{ request()->query('searchCol') == $key ? 'selected' : '' }}
                                                        value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-auto">
                                            <label class="visually-hidden" for="autoSizingInput">Từ khóa</label>
                                            <input type="text" name="keyword"
                                                value="{{ request()->query('keyword') }}" class="form-control"
                                                placeholder="Keyword">
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
                                        <th class="w-1">@sortablelink('id', 'ID')</th>
                                        @foreach ($tableCols as $key => $value)
                                            <th {{ $key == 'child' ? 'class=w-1' : '' }}>
                                                @if ($key != 'child')
                                                    @sortablelink($key, $value)
                                                @else
                                                    {{ $value }}
                                                @endif
                                            </th>
                                        @endforeach
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($data->items() == [])
                                        <tr>
                                            <td colspan="9">
                                                <div>Không có dữ liệu</div>
                                            </td>
                                        </tr>
                                    @elseif ($data)
                                        @foreach ($data as $item)
                                            <tr>
                                                <td><span class="text-muted">{{ $item->id }}</span></td>
                                                <td>{{ count($item->child) != 0 ? count($item->child) . ' con:' : '' }}</td>
                                                <td>
                                                    {{ string_truncate($item->name, 70) }}
                                                </td>
                                                <td>
                                                    {{ time_format($item->created_at) }}
                                                </td>
                                                <td>
                                                    {{ time_format($item->updated_at) }}
                                                </td>
                                                <td class="text-end">
                                                    @if (auth()->user()->can('edit category') || auth()->user()->is_admin == 1)
                                                        <a class="btn btn-icon btn-outline-green"
                                                            href="{{ route('category.edit', ['id' => $item->id]) }}">
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
                                                    @endif
                                                    @if (auth()->user()->can('delete category') || auth()->user()->is_admin == 1)
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
                                                    @endif
                                                </td>
                                            </tr>
                                            @if ($item->child)
                                                @foreach ($item->child as $child)
                                                    <tr>
                                                        <td><span class="text-muted">{{ $child->id }}</span></td>
                                                        <td class="bg-secondary-subtle text-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="icon icon-tabler icon-tabler-corner-down-right"
                                                                width="24" height="24" viewBox="0 0 24 24"
                                                                stroke-width="2" stroke="currentColor" fill="none"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none">
                                                                </path>
                                                                <path d="M6 6v6a3 3 0 0 0 3 3h10l-4 -4m0 8l4 -4"></path>
                                                            </svg>
                                                        </td>
                                                        <td>
                                                            {{ string_truncate($child->name, 70) }}
                                                        </td>
                                                        <td>
                                                            {{ time_format($child->created_at) }}
                                                        </td>
                                                        <td>
                                                            {{ time_format($child->updated_at) }}
                                                        </td>
                                                        <td class="text-end">
                                                            <a class="btn btn-icon btn-outline-green"
                                                                href="{{ route('category.edit', ['id' => $child->id]) }}">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="icon icon-tabler icon-tabler-edit"
                                                                    width="24" height="24" viewBox="0 0 24 24"
                                                                    stroke-width="2" stroke="currentColor" fill="none"
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
                                                                href="javascript: removeItem({{ $child->id }})">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="icon icon-tabler icon-tabler-trash"
                                                                    width="24" height="24" viewBox="0 0 24 24"
                                                                    stroke-width="2" stroke="currentColor" fill="none"
                                                                    stroke-linecap="round" stroke-linejoin="round">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none">
                                                                    </path>
                                                                    <path d="M4 7l16 0"></path>
                                                                    <path d="M10 11l0 6"></path>
                                                                    <path d="M14 11l0 6"></path>
                                                                    <path
                                                                        d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12">
                                                                    </path>
                                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3">
                                                                    </path>
                                                                </svg>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        @endforeach
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
        let removeItem = function(id) {
            $.confirm({
                theme: theme,
                title: 'Xác nhận',
                content: 'Di chuyển vào thùng rác?',
                columnClass: 'col-md-3 col-sm-6',
                buttons: {
                    removeButton: {
                        text: 'Được rồi!',
                        btnClass: 'btn-danger',
                        action: function() {
                            axios.delete(`/api/category-destroy/${id}`).then(function(response) {
                                Swal.fire({
                                        title: 'Thành công!',
                                        text: 'Di chuyển vào thùng thành công',
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
