@extends('admin.common.layout')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h1 class="text-indigo mb-4" style="font-size: 36px;">
                        Quản lý đánh giá cho tour: 
                        <a href="javascript: viewDetailT({{ $data->tour->id ?? 1}});" title="Show Detail">{{ $data->tour->name ?? 'test'}}</a>
                        
                    </h1>
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
            <div class="col-auto ms-auto d-print-none">
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
                            <h3 class="card-title">Trung bình đánh giá:
                                @php
                                $star = 0;
                                $t=0;
                                $count = $data->ratings;
                                foreach ($count as $c) {
                                    $star += $c->star;
                                    $t++;
                                }
                                @endphp
                                {{ round($star/($t==0?1:$t),1) }} <i class="fa-solid fa-star" style="color: #fffa75;"></i> (Tổng số đánh giá: {{ $t }} )
                            </h3>
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
                                        <input type="text" name="keyword" value="keyword" class="form-control" placeholder="Keyword">
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-indigo">Gửi</button>
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
                                    <th>Tên người dùng</th>
                                    <th>Số sao đánh giá</th>
                                    <th>Nội dung</th>
                                    <th>Trả lời của công ty</th>
                                    <th>Ngày tạo</th>
                                    <th>Ngày sửa</th>
                                    <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($data->ratings)
                                        @foreach ($data->ratings as $item)
                                            <tr>
                                                <td><span class="text-muted">{{ $item->id }}</span></td>
                                                <td>
                                                    <a href="javascript: viewDetailU({{$item->id}});" title="Show Detail">{{ $item->user_name }}</a>
                                                </td>
                                                <td>
                                                    {{ $item->star }}
                                                    <i class="fa-solid fa-star" style="color: #fffa75;"></i>
                                                </td>
                                                <td>
                                                <a href="javascript: viewDetail({{$item->id}});" title="Show Detail">{{ string_truncate($item->content, 70) }}</a>
                                                </td>
                                                <td>
                                                    {{ $item->admin_answer??'Null' }}
                                                </td>
                                                <td>
                                                    {{ time_format($item->created_at) }}
                                                </td>
                                                <td>
                                                    {{ time_format($item->updated_at) }}
                                                </td>
                                                <td class="text-end">
                                                    @if(auth()->user()->can('reply review') || auth()->user()->is_admin == 1)
                                                    <a class="btn btn-icon btn-outline-green" href="{{ route('rating.edit', ['id' => $item->id]) }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-message-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M8 9h8"></path>
                                                        <path d="M8 13h6"></path>
                                                        <path d="M12.01 18.594l-4.01 2.406v-3h-2a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v5.5"></path>
                                                        <path d="M16 19h6"></path>
                                                        <path d="M19 16v6"></path>
                                                        </svg>
                                                    </a>
                                                    @endif
                                                    @if(auth()->user()->can('delete review') || auth()->user()->is_admin == 1)
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
                                <option {{ $data->ratings->perPage() == $p?'selected':'' }} value="{{ $p }}">{{ $p }}</option>
                                @endforeach
                            </select>

                            <p class="m-0 text-secondary">Hiển thị <span>{{ $data->ratings->currentPage() }}</span> trên <span>{{ $data->ratings->lastPage() }}</span> của <span>{{ $data->ratings->total() }}</span>
                                bản ghi</p>

                            <ul class="pagination m-0 ms-auto">
                                <li class="page-item {{ $data->ratings->currentPage() != 1 ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $data->ratings->previousPageUrl()}}" tabindex="-1" aria-disabled="true">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M15 6l-6 6l6 6"></path>
                                        </svg>prev</a>
                                </li>
                                <li class="page-item {{ $data->ratings->currentPage() == 1 ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $data->ratings->url(1) }}">1</a>
                                </li>
                                @for ($page = max(2, $data->ratings->currentPage()-2); $page <= $data->ratings->currentPage()+2 && $page <= $data->ratings->lastPage()-1; $page++)

                                    <li class="page-item {{ $page == $data->ratings->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $data->ratings->url($page) }}">{{ $page }}</a>
                                    </li>

                                @endfor
                                @if($data->ratings->currentPage()+3 != $data->ratings->lastPage() && $data->ratings->lastPage() >3)
                                <li class="page-item">
                                        ...
                                </li>
                                @endif
                                <li class="page-item {{ $page == $data->ratings->currentPage() ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $data->ratings->url($data->ratings->lastPage()) }}">{{ $data->ratings->lastPage() }}</a>
                                </li>
                                <li class="page-item {{ $data->ratings->currentPage() != $data->ratings->lastPage() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $data->ratings->nextPageUrl()}}">Next
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
    let modalContainer;
    $(document).ready(function() {
        modalContainer = new bootstrap.Modal('#modalContainer', {
            keyboard: true,
            backdrop: 'static'
        });
    });

    let viewDetail = function(id) {
        axios.get(`/rating/detail/${id}`)
            .then(function(response) {
                $('#modalContainer div.modal-content').html(response.data.html);
                modalContainer.show();
            })
            .catch(function(error) {
                bs5Utils.Snack.show('danger', 'Error', delay = 5000, dismissible = true);
            })
            .finally(function() {});
    };

    let viewDetailT = function(id) {
        axios.get(`/tour/detail/${id}`)
            .then(function(response) {
                $('#modalContainer div.modal-content').html(response.data.html);
                modalContainer.show();
            })
            .catch(function(error) {
                bs5Utils.Snack.show('danger', 'Error', delay = 5000, dismissible = true);
            })
            .finally(function() {});
    };
    let viewDetailU = function(id) {
        axios.get(`/user/detail/${id}`)
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
            title: 'Confirm',
            content: 'Are you sure to remove?',
            columnClass: 'col-md-3 col-sm-6',
            buttons: {
                removeButton: {
                    text: 'Yes',
                    btnClass: 'btn-danger',
                    action: function() {
                        axios.delete(`/api/rating-destroy/${id}`).then(function(response) {
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
