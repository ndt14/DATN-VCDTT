<div class="modal-header">
    <h1 class="modal-title fs-4" id="exampleModalFullscreenMdLabel">Blog Details</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="card">
    <div class="row g-0">
        <div class="col d-flex flex-column">
            <div class="card-body">
                <h3 class="card-title">{{ $item['title'] }}</h3>

                <div class="row g-3">
                    <div class="col-md">
                        <div class="form-label">View count</div>
                        <span class="badge bg-blue me-1 text-light">{{ $item['view_count'] }}</span>
                    </div>
                    <div class="col-md">
                        <div class="form-label">Active</div>
                        @if($item['status'] == 0)
                            <span class="badge bg-muted me-1 text-light">Not active</span>
                        @elseif ($item['status'] == 1)
                            <span class="badge bg-success me-1 text-light">Activated</span>
                        @endif
                    </div>
                    <div class="col-md">
                        <div class="form-label">Create at</div>
                        {{ time_format($item['created_at']) }}
                    </div>
                    <div class="col-md">
                        <div class="form-label">Last update</div>
                        {{ time_format($item['updated_at']) }}
                    </div>
                </div>
                <h3 class="card-title mt-4">Main image</h3>
                <div class="row">
                    @if ($item['main_img'])
                    <a data-fancybox data-src="{{ $item['main_img'] }}" href="javascript:void(0);" class="mx-auto col-6">
                        <img src="{{ $item['main_img'] }}" alt="Not found image" style="max-height: 350px">
                    </a>
                    @endif
                </div>
                <h3 class="card-title mt-4">Short description</h3>
                <div>
                    {{ $item['short_desc'] }}
                </div>
                <h3 class="card-title mt-4">Description</h3>
                <div>
                    {{ $item['description'] }}
                </div>
            </div>
            <div class="card-footer bg-transparent mt-auto">
                <div class="btn-list justify-content-end">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>