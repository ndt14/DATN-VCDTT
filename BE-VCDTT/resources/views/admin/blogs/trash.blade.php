@extends('admin.common.layout')
@section('meta_title')
Bài viết bị xoá
@endSection
@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h1 class="text-primary mb-4" style="font-size: 36px;">
                    Quản lý Blog
                </h2>
            </div>
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
                        <h3 class="card-title">Blog</h3> <a href="{{route('blog.trash')}}" style="padding-left: 5px; text-decoration: none; color: black; font-weight: 700;"><span style="color: black;">|</span> Thùng rác</a>
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
                                    <th class="w-1">ID</th>
                                    <th>Tiêu đề</th>
                                    <th>Tác giả</th>
                                    <th>Mô tả ngắn</th>
                                    <th>Số lượt xem</th>
                                    <th>Ngày tạo</th>
                                    <th>Ngày sửa</th>
                                    <th class="text-center">Trạng thái</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($data)
                                    @foreach($data as $item)
                                        <tr>
                                        <td><span class="text-muted">{{$item->id}}</span></td>
                                        <td>
                                            <a href="javascript: viewDetail({{$item->id}});" title="Show Detail">{{string_truncate($item->title)}}</a>
                                        </td>
                                        <td>
                                            {{$item->author}}
                                        </td>
                                        <td>
                                            {{string_truncate($item->short_desc, 50)}}
                                        </td>
                                        <td>
                                            {{$item->view_count}}
                                        </td>
                                        <td>
                                            {{time_format($item->created_at)}}
                                        </td>
                                        <td>
                                            {{time_format($item->updated_at)}}
                                        </td>
                                        <td class="text-center">
                                            @if($item->status == 1)
                                            <span class="badge bg-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Activated"></span>
                                            @else
                                            <span class="badge bg-secondary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Unactivated"></span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            @if(auth()->user()->can('delete post') || auth()->user()->is_admin == 1)
                                            <a class="btn btn-icon btn-outline-green" href="{{route('blog.restore', ['id'=>$item->id])}}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clock-up" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M20.983 12.548a9 9 0 1 0 -8.45 8.436"></path>
                                                    <path d="M19 22v-6"></path>
                                                    <path d="M22 19l-3 -3l-3 3"></path>
                                                    <path d="M12 7v5l2.5 2.5"></path>
                                                 </svg>
                                            </a>
                                            @endif

                                            @if(auth()->user()->can('delete post') || auth()->user()->is_admin == 1)
                                            <a class="btn btn-icon btn-outline-red" href="javascript: removeItem({{ $item->id}})">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M4 7l16 0"></path>
                                                <path d="M10 11l0 6"></path>
                                                <path d="M14 11l0 6"></path>
                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                                </svg>
                                            </a>
                                            @endif
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
                        $pageLimits = [5,10,20,50,100,250,300];
                    @endphp
                    <select id="rpp" class="form-select me-2" style="max-width: 75px;">
                        @foreach ($pageLimits as $p)
                        <option {{ $data->perPage() == $p?'selected':'' }} value="{{ $p }}">{{ $p }}</option>
                        @endforeach
                    </select>

                    <p class="m-0 text-secondary">Hiển thị <span>{{ $data->currentPage() }}</span> trên <span>{{ $data->lastPage() }}</span> của <span>{{ $data->total() }}</span>
                        bản ghi</p>

                    <ul class="pagination m-0 ms-auto">
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
                    </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal modal-blur fade" id="modalContainer" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content" >
        </div>
    </div>
</div>
@endSection
@section('page_css')
<style>

</style>
@endSection
@section('page_js')
<script type="text/javascript">
    let viewDetail = function(id) {
        axios.get(`/blog/detail/${id}`)
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
            title: 'Xác nhận',
            content: 'Xóa vĩnh viễn bài viết?',
            columnClass: 'col-md-3 col-sm-6',
            buttons: {
                removeButton: {
                    text: 'Ok!',
                    btnClass: 'btn-danger',
                    action: function() {
                        axios.delete(`/api/blog-destroy-forever/${id}`).then(function(response) {
                            Swal.fire({
                            position: "top-center",
                            icon: "success",
                            title: "Xóa thành công",
                            showConfirmButton: false,
                            timer: 1500
                            })
                            .then((response) => {
                            if (response) {
                                location.reload();
                            }
                        });
                        });
                    }
                },
                close: function() {}
            }
        });
    };

</script>
@endSection
