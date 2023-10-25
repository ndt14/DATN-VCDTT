<div class="modal-header">
    <h1 class="modal-title fs-4" id="exampleModalFullscreenMdLabel">Coupon Details</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="card">
    <div class="row g-0">
        <div class="col d-flex flex-column">
            <div class="card-body">
                <h3 class="card-title">Tên/mô tả: {{ $item->name }}</h3>
                <div class="row g-3">
                <div  class="markdown col-md">
                <h3 class="card-title ">{{ $item->percentage_price!=null?'Giá giảm %':'Giá trừ'}}</h3>
                    {{ $item->percentage_price??$item->fixed_price }}
                </div>
                <div  class="markdown col-md">
                    <h3 class="card-title">Mã</h3>
                    {!! $item->code !!}
                </div>
            </div>
            <div class="row g-3 mt-4">
                <div class="col-md">
                    <div class="form-label">Ngày hoạt động</div>
                    {{ time_format($item->start_date) }}
                </div>
                <div class="col-md">
                    <div class="form-label">Ngày hết hạn</div>
                    {{ time_format($item->expiration_date) }}
                </div>
            </div>
            <div class="row g-3 mt-4">
                <!--{{-- <div class="col-md">
                    <div class="form-label">Active</div>
                    @if($item->status == 0)
                        <span class="badge bg-muted me-1 text-light">Not active</span>
                    @elseif ($item->status == 1)
                        <span class="badge bg-success me-1 text-light">Activated</span>
                    @endif
                </div> --}}-->
                <div class="col-md">
                    <div class="form-label">Ngày tạo</div>
                    {{ time_format($item->created_at) }}
                </div>
                <div class="col-md">
                    <div class="form-label">Ngày sửa</div>
                    {{ time_format($item->updated_at) }}
                </div>
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
