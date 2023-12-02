@extends('admin.common.layout')
@section('meta_title')
    Danh sách đơn đặt
@endSection
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h1 class="text-indigo mb-4" style="font-size: 36px;">
                        Quản lý đơn đặt
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
                            @if (auth()->user()->is_admin == 1 ||
                                    auth()->user()->can('delete bill'))
                                <a href="{{ route('purchase_histories.trash') }}"
                                    style="padding-left: 5px; text-decoration: none; color: black;"><span
                                        style="color: black;">|</span> Thùng rác</a>
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
                                        <div class="col-auto">
                                            <label class="visually-hidden" for="autoSizingSelect">Trạng thái</label>
                                            <select class="form-select" name="payment_status">
                                                @if (!request()->query('payment_status'))
                                                    <option value="">Chọn trạng thái thanh toán</option>
                                                @else
                                                    <option value="">Mặc định</option>
                                                @endif
                                                <option {{ request()->query('payment_status') == 1 ? 'selected' : '' }}
                                                    value="1">Chưa thanh toán</option>
                                                <option {{ request()->query('payment_status') == 2 ? 'selected' : '' }}
                                                    value="2">Đã thanh toán</option>
                                            </select>
                                        </div>
                                        <div class="col-auto">
                                            <label class="visually-hidden" for="autoSizingSelect">Trạng thái</label>
                                            @php
                                                $purchaseStatus = [
                                                    1 => 'Tự động hủy do quá hạn',
                                                    2 => 'Chưa phê duyệt thanh toán',
                                                    3 => 'Đã phê duyệt thanh toán',
                                                    4 => 'Đang muốn hủy tour',
                                                    5 => 'Đã phê duyệt hủy tour',
                                                    6 => 'Đã hủy thành công',
                                                    7 => 'Chuyển khoản thiếu',
                                                    8 => 'Chuyển khoản thừa',
                                                ];
                                                $tourStatus = [
                                                    1 => 'Chưa tới ngày đi',
                                                    2 => 'Đang diễn ra',
                                                    3 => 'Đã kết thúc',
                                                    4 => 'Còn 1 ngày tới ngày đi tour',
                                                ];
                                            @endphp
                                            <select class="form-select" name="purchase_status">
                                                @if (!request()->query('purchase_status'))
                                                    <option value="">Chọn trạng thái đơn</option>
                                                @else
                                                    <option value="">Mặc định</option>
                                                @endif
                                                @foreach ($purchaseStatus as $key => $value)
                                                    <option
                                                        {{ request()->query('purchase_status') === "$key" ? 'selected' : '' }}
                                                        value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-auto">
                                            <select class="form-select" name="tour_status">
                                                @if (!request()->query('tour_status'))
                                                    <option value="">Chọn trạng thái tour</option>
                                                @else
                                                    <option value="">Mặc định</option>
                                                @endif
                                                @foreach ($tourStatus as $key => $value)
                                                    <option
                                                        {{ request()->query('tour_status') === "$key" ? 'selected' : '' }}
                                                        value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @php
                                            $tableCols = [
                                                'name' => 'Tên',
                                                'email' => 'Email',
                                                'transaction_id' => 'Mã giao dịch',
                                                'tour_name' => 'Tên Tour',
                                                'created_at' => 'Ngày tạo',
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
                                                <option {{ request()->query('searchCol') == 'id' ? 'selected' : '' }}
                                                    value="id">ID</option>
                                                @foreach ($tableCols as $key => $value)
                                                    <option {{ request()->query('searchCol') == $key ? 'selected' : '' }}
                                                        value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-auto">
                                            <label class="visually-hidden" for="autoSizingInput">Từ khóa</label>
                                            <input type="text" name="keyword" value="{{ request()->query('keyword') }}"
                                                class="form-control" placeholder="Keyword">
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
                                            <th>@sortablelink($key, $value)</th>
                                        @endforeach
                                        <th class="text-center">Trạng thái thanh toán</th>
                                        <th class="text-center">Trạng thái đơn</th>
                                        <th class="text-center">Trạng thái tour</th>
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
                                                <td>
                                                    <a href="javascript: viewPurchaseHistoryDetail({{ $item->id }});"
                                                        title="Show Detail">{{ $item->name }}</a>
                                                </td>
                                                <td class="text-wrap text-break">
                                                    {{ string_truncate($item->email, 15) }}
                                                </td>
                                                <td>
                                                    @if ($item->purchase_method == 1)
                                                        Chuyển khoản online
                                                    @else
                                                        Mã giao dịch:{{ $item->transaction_id }}
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ string_truncate($item->tour_name, 25) }}
                                                </td>
                                                <td>
                                                    {{ time_format($item->created_at) }}
                                                </td>
                                                <td class="text-center">
                                                    @if ($item->payment_status == 2)
                                                        <span class="badge bg-green rounded-circle p-1 text-green-fg"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            data-bs-title="Đã thanh toán">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="icon icon-tabler icon-tabler-check m-0"
                                                                width="24" height="24" viewBox="0 0 24 24"
                                                                stroke-width="2" stroke="currentColor" fill="none"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none">
                                                                </path>
                                                                <path d="M5 12l5 5l10 -10"></path>
                                                            </svg>
                                                        </span>
                                                    @elseif ($item->payment_status == 1)
                                                        <span class="badge bg-danger rounded-circle p-1 text-danger-fg"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            data-bs-title="Chưa thanh toán">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="icon icon-tabler icon-tabler-x m-0" width="24"
                                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                                stroke="currentColor" fill="none"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none">
                                                                </path>
                                                                <path d="M18 6l-12 12"></path>
                                                                <path d="M6 6l12 12"></path>
                                                            </svg>
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @switch($item->purchase_status)
                                                        @case(1)
                                                            <span class="badge bg-muted-lt">Tự động hủy do quá hạn</span>
                                                        @break

                                                        @case(2)
                                                            <span class="badge bg-orange-lt">Chưa phê duyệt thanh toán</span>
                                                        @break

                                                        @case(3)
                                                            <span class="badge bg-green-lt">Đã phê duyệt thanh toán</span>
                                                        @break

                                                        @case(4)
                                                            <span class="badge bg-orange-lt">Đang muốn hủy tour</span>
                                                        @break

                                                        @case(5)
                                                            <span class="badge bg-red-lt">Đã phê duyệt hủy tour, chưa hoàn
                                                                tiền</span>
                                                        @break

                                                        @case(6)
                                                            <span class="badge bg-green-lt">Đã hủy thành công @if ($item->payment_status == 1)
                                                                    (đã hoàn tiền)
                                                                @endif </span>
                                                        @break

                                                        @case(7)
                                                            <span class="badge bg-orange-lt">Chuyển khoản thiếu</span>
                                                        @break

                                                        @case(8)
                                                            <span class="badge bg-orange-lt">Chuyển khoản thừa</span>
                                                        @break

                                                        @default
                                                        @break
                                                    @endswitch
                                                </td>
                                                <td class="text-center">
                                                    @switch($item->tour_status)
                                                        @case(1)
                                                            <span class="badge bg-muted-lt">Chưa tới ngày đi</span>
                                                        @break

                                                        @case(2)
                                                            <span class="badge bg-green-lt">Đang diễn ra</span>
                                                        @break

                                                        @case(3)
                                                            <span class="badge bg-red-lt">Đã kết thúc</span>
                                                        @break

                                                        @case(4)
                                                            <span class="badge bg-orange-lt">Còn 1 ngày tới ngày đi tour</span>
                                                        @break

                                                        @default
                                                        @break
                                                    @endswitch
                                                </td>
                                                <td class="text-end">
                                                    @if (auth()->user()->can('edit bill') || auth()->user()->is_admin == 1)
                                                        <a class="btn btn-icon btn-outline-green"
                                                            href=" {{ route('purchase_histories.edit', ['id' => $item->id]) }}">
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
                                                    <a class="btn btn-icon btn-outline-red"
                                                        href="{{ route('printInvoice', ['id' => $item->id]) }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="icon icon-tabler icon-tabler-printer" width="24"
                                                            height="24" viewBox="0 0 24 24" stroke-width="2"
                                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path
                                                                d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" />
                                                            <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" />
                                                            <path
                                                                d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" />
                                                        </svg>
                                                    </a>
                                                    {{-- @if (auth()->user()->can('delete bill') ||
    auth()->user()->is_admin == 1)
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
                                                    @endif --}}
                                                </td>
                                            </tr>
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
                content: 'Di chuyển vào thùng?',
                columnClass: 'col-md-3 col-sm-6',
                buttons: {
                    removeButton: {
                        text: 'Ok!',
                        btnClass: 'btn-danger',
                        action: function() {
                            axios.delete(`/api/purchase-history-destroy/${id}`).then(function(response) {
                                Swal.fire({
                                        position: "top-center",
                                        icon: "success",
                                        title: "Di chuyển vào thùng thành công",
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
