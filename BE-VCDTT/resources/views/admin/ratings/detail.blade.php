<div class="modal-header">
    <h1 class="modal-title fs-4" id="exampleModalFullscreenMdLabel">Rating Details</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="card">
    <div class="row g-0">
        <div class="col d-flex flex-column">
            <div class="card-body">
                <h3 class="card-title">User name: {{ $item->user_name }}</h3>
                <div class="row g-3">
                <div class="row p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="ratings bg-secondary p-1 rounded-2">
                        @for ($i = 0; $i < $item->star; $i++)
                        <i class="fa-solid fa-star" style="color: #fffa75;"></i>
                        @endfor
                    </div>
                </div>
                <div  class="markdown col-md">
                    <h3 class="card-title">Content</h3>
                    {!! $item->content !!}
                </div>
            </div>
            <div class="row g-3 mt-4">
                <div  class="markdown col-md">
                <h3 class="card-title">Our answer</h3>
                {{ $item->admin_answer??"Null" }}
                </div>
            </div>
            <div class="row g-3 mt-4">
                <div class="col-md">
                    <div class="form-label">Create at</div>
                    {{ time_format($item->created_at) }}
                </div>
                <div class="col-md">
                    <div class="form-label">Last update</div>
                    {{ time_format($item->updated_at) }}
                </div>
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
