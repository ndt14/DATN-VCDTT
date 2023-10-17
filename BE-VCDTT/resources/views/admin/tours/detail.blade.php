<div class="modal-header">
    <h1 class="modal-title fs-4" id="exampleModalFullscreenMdLabel">Blog Details</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="card">
    <div class="row g-0">
        <div class="col d-flex flex-column">
            <div class="card-body">
                <h3 class="card-title">{{ $item['name'] }}</h3>

                <div class="row g-3">
                    <div class="col-md">    
                        <div class="form-label">Create at</div>
                        {{ time_format($item['created_at']) }}
                    </div>
                    <div class="col-md">
                        <div class="form-label">Last update</div>
                        {{ time_format($item['updated_at']) }}
                    </div>
                    <div class="col-md">
                        <div class="form-label">Active</div>
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
                        <div class="form-label">View count</div>
                        <span class="badge bg-blue me-1 text-light">{{ $item['view_count'] }}</span>
                    </div>
                    <div class="col-md">
                        <div class="form-label">Rating count</div>
                        <span class="badge bg-blue me-1 text-light">số đánh giá </span>
                        + link sang đánh giá
                    </div>
                    <div class="col-md">
                        <div class="form-label">Sold count</div>
                        <span class="badge bg-blue me-1 text-light">số đơn hàng</span>
                    </div>
                    <div class="col-md">
                        <div class="form-label">Duration</div>
                        <span class="">{{ $item['duration'] }}</span>
                    </div>

                </div>
                <hr>

                <h3 class="card-title">Location</h3>
                <div class="row g-3">
                    <div class="col-md-6">    
                        <div class="form-label">Location</div>
                        {{ $item['location'] }}
                    </div>
                    <div class="col-md-6">
                        <div class="form-label">Exact location</div>
                        {{ $item['exact_location'] }}
                    </div>
                    <div class="col-md-6">    
                        <div class="form-label">Start destination</div>
                        {{ $item['start_destination'] }}
                    </div>
                    <div class="col-md-6">
                        <div class="form-label">End destination</div>
                        {{ $item['end_destination'] }}
                    </div>
                </div>
                <hr>
                <h3 class="card-title mt-4">Price</h3>
                <div class="row g-3">
                    <div class="col-md">    
                        <div class="form-label">Child price</div>
                        {{ money_format($item['child_price']) }}
                    </div>
                    <div class="col-md">
                        <div class="form-label">Adult price</div>
                        {{ money_format($item['adult_price']) }}
                    </div>
                    <div class="col-md-1">
                        <div class="form-label">Sale</div>
                        <span class="badge bg-red me-1 text-light">{{ $item['sale_percentage'] }}%</span>
                        
                    </div>
                    <div class="col-md">
                        <div class="form-label">Final price</div>
                        {{ money_format(($item['adult_price']/100)*$item['sale_percentage']) }}
                    </div>
                </div>
                <hr>
                <h3 class="card-title mt-4">Main image</h3>
                <div class="row">
                    @if ($item['main_img'])
                        <img src="{{ $item['main_img'] }}" alt="Not found image" style="max-height: 350px">
                    @endif
                </div>

                <h3 class="card-title mt-4">Description</h3>
                <div class="markdown">
                    {!! $item['details'] !!}
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