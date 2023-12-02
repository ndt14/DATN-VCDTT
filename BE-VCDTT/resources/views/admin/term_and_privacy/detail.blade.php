<div class="modal-header">
    <h1 class="modal-title fs-4" id="exampleModalFullscreenMdLabel">Chi tiết điều khoản</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="card border-0 shadow-lg rounded-4 ">
    <div class="row g-0">
        <div class="col d-flex flex-column">
            <div class="card-body card-body-scrollable" style="height: 35rem;">
                <div class="markdown">
                    {!! $item->content !!}
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