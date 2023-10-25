@extends('admin.common.layout')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Quản lý danh mục
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
                        <a href="{{ route('category.add') }}" class="btn btn-primary d-none d-sm-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <line x1="12" y1="5" x2="12" y2="19" />
                                <line x1="5" y1="12" x2="19" y2="12" />
                            </svg>
                           Thêm mới
                        </a>
                        <a href="{{ route('category.add') }}" class="btn btn-primary d-sm-none btn-icon">
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
                            <h3 class="card-title">Danh mục</h3>
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
                                            <input type="text" name="keyword" value="" class="form-control" placeholder="Keyword">
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-primary">Tìm</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="table table-responsive">
                            <table class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                    <tr>
                                        <th class="w-1">Số trẻ nhỏ</th>
                                        <th class="w-1">ID</th>
                                        <th>Tên</th>
                                        <th>Ngày tạo</th>
                                        <th>Ngày sửa</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($data)
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{ count($item->child) != 0 ? count($item->child)." child" : "" }}</td>
                                                <td><span class="text-muted">{{ $item->id }}</span></td>
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
                                                    <span class="dropdown">
                                                        <button class="btn dropdown-toggle align-text-top"
                                                            data-bs-boundary="viewport"
                                                            data-bs-toggle="dropdown">Hành động</button>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a class="dropdown-item" href="{{ route('category.edit', ['id' => $item->id]) }}">Sửa</a>
                                                            <a class="dropdown-item" href="javascript: removeItem({{ $item->id}})">Xóa</a>
                                                        </div>
                                                    </span>
                                                </td>
                                            </tr>
                                            @if($item->child)
                                                @foreach ($item->child as $child)
                                                <tr>
                                                <td class="bg-secondary-subtle text-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-corner-down-right" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M6 6v6a3 3 0 0 0 3 3h10l-4 -4m0 8l4 -4"></path>
                                                    </svg>
                                                </td>
                                                <td>
                                                    <span class="text-muted">{{ $child->id }}</span></td>
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
                                                        <span class="dropdown">
                                                            <button class="btn dropdown-toggle align-text-top"
                                                                data-bs-boundary="viewport"
                                                                data-bs-toggle="dropdown">Hành động</button>
                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                <a class="dropdown-item" href="{{ route('category.edit', ['id' => $child->id]) }}">Sửa</a>
                                                                <a class="dropdown-item" href="javascript: removeItem({{ $child->id}})">Xóa</a>
                                                            </div>
                                                        </span>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            @endif
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
                            <select id="rpp" class="form-select me-2" style="max-width: 75px;">
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="250">250</option>
                                <option value="500">500</option>
                            </select>

                            <!-- <p class="m-0 text-secondary">Hiển thị <span>1</span> trên <span>1</span> của <span>16</span>
                                bản ghi</p> -->
                                
                            <!-- {{-- <ul class="pagination m-0 ms-auto">
                                <li class="page-item {{ $data->currentPage() != 1 ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $data->previousPageUrl()}}" tabindex="-1" aria-disabled="true">
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
                                @for ($page = max(2, $data->currentPage()-2); $page <= $data->currentPage()+2 && $page <= $data->lastPage()-1; $page++)

                                    <li class="page-item {{ $page == $data->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $data->url($page) }}">{{ $page }}</a>
                                    </li>

                                @endfor
                                @if($data->currentPage()+3 != $data->lastPage() && $data->lastPage() >3)
                                <li class="page-item">
                                        ...
                                </li>
                                @endif
                                <li class="page-item {{ $page == $data->currentPage() ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $data->url($data->lastPage()) }}">{{ $data->lastPage() }}</a>
                                </li>
                                <li class="page-item {{ $data->currentPage() != $data->lastPage() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $data->nextPageUrl()}}">Next
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M9 6l6 6l-6 6"></path>
                                        </svg>
                                    </a>
                                </li>
                            </ul> --}} -->

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
        let modalContainer;
        $(document).ready(function() {
            modalContainer = new bootstrap.Modal('#modalContainer', {
                keyboard: true,
                backdrop: 'static'
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
            .finally(function() {
            });
        };

        let removeItem = function(id) {
        $.confirm({
            theme: theme,
            title: 'Confirm',
            content: 'Are you sure to remove?',
            columnClass: 'col-md-3 col-sm-6',
            buttons: {
                removeButton: {
                    text: 'Yes',
                    btnClass: 'btn-danger',
                    action: function() {
                        axios.delete(`/api/category-destroy/${id}`).then(function(response) {
                            bs5Utils.Snack.show('success', 'Success', delay = 5000, dismissible = true);
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        });
                    }
                },
                close: function() {}
            }
        });
    };
    </script>
@endSection
