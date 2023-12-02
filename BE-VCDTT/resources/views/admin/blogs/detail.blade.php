<div class="modal-header">
    <h1 class="modal-title fs-4" id="exampleModalFullscreenMdLabel">Chi tiết của blog</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="card border-0 shadow-lg rounded-4 ">
    <div class="row g-0">
        <div class="col d-flex flex-column">
            <div class="card-body">
                <h3 class="card-title">{{ $item['title'] }}</h3>

                <div class="row g-3">
                    <div class="col-md">
                        <div class="form-label">Số lượt xem</div>
                        <span class="badge bg-blue me-1 text-light">{{ $item['view_count'] }}</span>
                    </div>
                    <div class="col-md">
                        <div class="form-label">Trang thái</div>
                        @if($item['status'] == 0)
                            <span class="badge bg-muted me-1 text-light">Không hoạt động</span>
                        @elseif ($item['status'] == 1)
                            <span class="badge bg-success me-1 text-light">Đang hoạt động</span>
                        @endif
                    </div>
                    <div class="col-md">
                        <div class="form-label">Ngày tạo</div>
                        {{ time_format($item['created_at']) }}
                    </div>
                    <div class="col-md">
                        <div class="form-label">Ngày sửa</div>
                        {{ time_format($item['updated_at']) }}
                    </div>
                </div>
                <h3 class="card-title mt-4">Ảnh chính</h3>
                <div class="row">
                    @if ($item['main_img'])
                        <img src="{{ $item['main_img'] }}" alt="Not found image" style="max-height: 350px">
                    @endif
                </div>
                <h3 class="card-title mt-4">Mô tả ngắn</h3>
                <div>
                    {!! $item['short_desc'] !!}
                </div>
                <h3 class="card-title mt-4">Mô tả</h3>
                <div class="markdown">
                    {!! $item['description'] !!}
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
