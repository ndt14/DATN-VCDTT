@extends('admin.common.layout')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h1 class="text-primary mb-4" style="font-size: 36px;">
                        Quản lý hóa đơn
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
                {{-- <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('') }}" class="btn btn-primary d-none d-sm-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <line x1="12" y1="5" x2="12" y2="19" />
                                <line x1="5" y1="12" x2="19" y2="12" />
                            </svg>
                            Add new
                        </a>
                        <a href="{{ url('/tour-add') }}" class="btn btn-primary d-sm-none btn-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <line x1="12" y1="5" x2="12" y2="19" />
                                <line x1="5" y1="12" x2="19" y2="12" />
                            </svg>
                        </a>
                    </div>
                </div> --}}
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
                            <h3 class="card-title">Hóa đơn</h3>
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
                                            <label class="visually-hidden" for="autoSizingSelect">Status</label>
                                            <select class="form-select" name="lang_code">
                                                <option value="">Select status...</option>
                                                <option value="ja">Active</option>
                                                <option value="en">Unactive</option>
                                            </select>
                                        </div>
                                        <div class="col-auto">
                                            <label class="visually-hidden" for="autoSizingInput">Keyword</label>
                                            <input type="text" name="keyword" class="form-control" placeholder="Keyword">
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-primary">Submit</button>
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
                                        <th>User Name</th>
                                        <th>Email</th>
                                        <th>Transaction id</th>
                                        <th>Tour name</th>
                                        <th>Created at</th>
                                        <th class="text-center">Payment status</th>
                                        <th class="text-center">Purchase status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($data)
                                        @foreach ($data as $item)
                                            <tr>
                                                <td><span class="text-muted">{{ $item->id }}</span></td>
                                                <td>
                                                    <a href="javascript: viewPurchaseHistoryDetail({{ $item->id }});"
                                                        title="Show Detail">{{ $item->name }}</a>
                                                </td>
                                                <td class="text-wrap text-break">
                                                    {{ string_truncate($item->email, 15) }}
                                                </td>
                                                <td>
                                                    {{ $item->transaction_id }}
                                                </td>
                                                <td>
                                                    {{ string_truncate($item->tour_name, 25) }}
                                                </td>
                                                <td>
                                                    {{ time_format($item->created_at) }}
                                                </td>
                                                <td class="text-center">
                                                    @if ($item->payment_status == 1)
                                                        <span class="badge bg-green rounded-circle p-1 text-green-fg">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check m-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <path d="M5 12l5 5l10 -10"></path>
                                                            </svg>
                                                        </span>
                                                    @else
                                                        <span class="badge bg-danger rounded-circle p-1 text-danger-fg">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x m-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <path d="M18 6l-12 12"></path>
                                                            <path d="M6 6l12 12"></path>
                                                            </svg>
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @switch($item->purchase_status)
                                                        @case(0)
                                                            <span class="badge bg-red-lt">Chưa thanh toán</span>
                                                            @break
                                                        @case(1)
                                                            <span class="badge bg-orange-lt">Đang đợi xác nhận</span>
                                                            @break
                                                        @case(2)
                                                            <span class="badge bg-green-lt">Chưa tới ngày đi</span>
                                                            @break
                                                        @case(3)
                                                            <span class="badge bg-green-lt">Tour đang diễn ra</span>
                                                            @break
                                                        @case(4)
                                                            <span class="badge bg-muted-lt">Người dùng đã hủy</span>
                                                            @break
                                                        @case(5)
                                                            <span class="badge bg-muted-lt">Admin đã hủy tour</span>
                                                            @break
                                                        @case(6)
                                                            <span class="badge bg-muted-lt">Tự động hủy do quá hạn</span>
                                                            @break
                                                        @default
                                                            @break
                                                    @endswitch
                                                </td>
                                                <td class="text-end">
                                                    @if(auth()->user()->can('edit bill') || auth()->user()->is_admin == 1)
                                                    <a class="btn btn-icon btn-outline-green" href=" {{ route('purchase_histories.edit', ['id' => $item->id]) }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                                        <path d="M16 5l3 3"></path>
                                                        </svg>
                                                    </a>
                                                    @endif
                                                    @if(auth()->user()->can('delete bill') || auth()->user()->is_admin == 1)
                                                    <a class="btn btn-icon btn-outline-red" href="javascript: removeItem({{ $item->id }})">
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
                                                <div>No data</div>
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
                            axios.delete(`/api/purchase-history/${id}`).then(function(response) {
                                bs5Utils.Snack.show('success', 'Success', delay = 5000,
                                    dismissible = true);
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
