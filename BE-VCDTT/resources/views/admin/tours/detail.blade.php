<div class="modal-header">
    <h1 class="modal-title fs-4" id="exampleModalFullscreenMdLabel">Chi tiết Tour</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="card border-0 shadow-lg rounded-4 ">
    <div class="row g-0">
        <div class="col d-flex flex-column">
            <div class="card-body">
                <h3 class="card-title">{{ $item['name'] }}</h3>

                <div class="row g-3">
                    <div class="col-md">
                        <div class="form-label">Ngày tạo</div>
                        {{ time_format($item['created_at']) }}
                    </div>
                    <div class="col-md">
                        <div class="form-label">Ngày sửa</div>
                        {{ time_format($item['updated_at']) }}
                    </div>
                    <div class="col-md d-none">
                        <div class="form-label">Hoạt động</div>
                        @if($item['status'] == 0)
                            <span class="badge bg-muted me-1 text-light">Not active</span>
                        @elseif ($item['status'] == 1)
                            <span class="badge bg-success me-1 text-light">Activated</span>
                        @endif
                    </div>
                </div>
                <hr>
                <div class="row g-3">
                    <div class="col-md">
                        <div class="form-label">Lượt xem</div>
                        <span class="badge bg-blue me-1 text-light">{{ $item['view_count'] }}</span>
                    </div>
                    <div class="col-md">
                        <div class="form-label">Đánh giá (số lượt)</div>
                        <span class="badge bg-blue me-1 text-light">{{ $item['star'] }} <i class="fa-solid fa-star" style="color: #fffa75;"></i> ({{ $item['rcount'] }})</span>
                            <a class="badge bg-yellow me-1 text-light" href="{{ route('rating.list', ['id' => $item['id']]) }}">
                                Xem
                            </a>
                    </div>
                    <div class="col-md">
                        <div class="form-label">Số lượng bán được</div>
                        <span class="badge bg-blue me-1 text-light">số đơn hàng</span>
                    </div>
                    <div class="col-md">
                        <div class="form-label">Khoảng thời gian</div>
                        <span class="">{{ $item['duration'] }}</span>
                    </div>

                </div>
                <hr>

                <h3 class="card-title">Vị trí</h3>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-label">Vị trí</div>
                        {{ $item['location'] }}
                    </div>
                    <div class="col-md-6">
                        <div class="form-label">Vị trí chính xác</div>
                        {{ $item['exact_location'] }}
                    </div>
                    <div class="col-md-6">
                        <div class="form-label">Ngày khởi hành</div>
                        {{ $item['start_destination'] }}
                    </div>
                    <div class="col-md-6">
                        <div class="form-label">Ngày kết thúc</div>
                        {{ $item['end_destination'] }}
                    </div>
                </div>
                <hr>
                <h3 class="card-title mt-4">Giá</h3>
                <div class="row g-3">
                    <div class="col-md">
                        <div class="form-label">Giá trẻ nhỏ</div>
                        {{ money_format($item['child_price']) }}
                    </div>
                    <div class="col-md">
                        <div class="form-label">Giá người lớn</div>
                        {{ money_format($item['adult_price']) }}
                    </div>
                    <div class="col-md-1">
                        <div class="form-label">Sale</div>
                        <span class="badge bg-red me-1 text-light">{{ $item['sale_percentage'] }}%</span>

                    </div>
                    <div class="col-md">
                        <div class="form-label">Tổng giá</div>
                        {{ money_format(($item['adult_price']/100)*$item['sale_percentage']) }}
                    </div>
                </div>
                <hr>
                <h3 class="card-title mt-4">Ảnh chính</h3>
                <div class="row">
                    @if ($item['main_img'])
                        <img src="{{ $item['main_img'] }}" alt="Not found image" style="max-height: 350px">
                    @endif
                </div>

                <h3 class="card-title mt-4">Mô tả</h3>
                <div class="markdown">
                    {!! $item['details'] !!}
                </div>
                <h3 class="card-title mt-4">Giá bao gồm</h3>
                <div class="markdown">
                    {!! $item['includes'] !!}
                </div>
                <h3 class="card-title mt-4">Người tạo</h3>
                <div class="markdown">
                    {!! $item['creator'] !!}
                </div>
            </div>
            <div class="card-footer bg-transparent mt-auto">
                <div class="btn-list justify-content-end">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
</div>
