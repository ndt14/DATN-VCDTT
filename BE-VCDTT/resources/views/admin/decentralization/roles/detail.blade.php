<div class="modal-header">
    <h1 class="modal-title fs-4" id="exampleModalFullscreenMdLabel">Chi tiết Faq</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="card">
    <div class="row g-0">
        <div class="col d-flex flex-column">
            <div class="card-body">
                <h3 class="card-title">{{ $item->question }}</h3>

                <div class="row g-3">
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
                <h3 class="card-title mt-4">Câu hỏi</h3>   
                <span class="">
                    {{ $item->question }}
                </span>
                <h3 class="card-title mt-4">Câu trả lời</h3>
                <div class="markdown">
                    {!! $item->answer !!}
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