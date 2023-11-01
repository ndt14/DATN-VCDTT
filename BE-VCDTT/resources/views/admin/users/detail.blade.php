<div class="modal-header">
    <h1 class="modal-title fs-4" id="exampleModalFullscreenMdLabel">User Details</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="card border-0 shadow-lg rounded-4 ">
    <div class="row g-0">
        <div class="col d-flex flex-column">
            <div class="card-body">
                <h3 class="card-title">{{ $item['name'] }}</h3>

                <div class="row g-3">
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
                    @if ($item['image'])
                        <img src="{{ $item['image'] }}" alt="Not found image" style="max-height: 350px">
                    @endif
                </div>

                <div class="row">
                    <div class="mb-3 col-6">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" disabled class="form-control" placeholder="Name" value="{{$item['name']}}" >
                        <span class="text-danger d-flex justify-content-start">
                            @error('title')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="mb-3 col-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" disabled class="form-control" placeholder="" value="{{$item['email']}}">
                        <span class="text-danger d-flex justify-content-start">
                            @error('author')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>

                </div>
                <div class="row">
                    <div class="mb-3 col-6">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone_number" disabled class="form-control" placeholder="Phone" value="{{$item['phone_number']}}">
                        <span class="text-danger d-flex justify-content-start">
                            @error('phone_number')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="mb-3 col-6">
                        <label class="form-label">Image</label>
                        <input type="text" name="image" disabled class="form-control" placeholder="Image" value="{{$item['image']}}">
                        <span class="text-danger d-flex justify-content-start">
                            @error('image')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-6">
                        <label class="form-label">Address</label>
                        <input type="text" name="address" disabled disabled class="form-control" placeholder="address" value="{{$item['address']}}">
                        <span class="text-danger d-flex justify-content-start">
                            @error('address')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="mb-3 col-6">
                        <label class="form-label">Ngày sinh</label>
                        <input type="date" name="date_of_birth" disabled class="form-control" placeholder="Date of birth" value="{{$item['date_of_birth']}}">
                        <span class="text-danger d-flex justify-content-start">
                            @error('date_of_birth')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-6">
                        <div class="form-label">Is Admin</div>
                        <div class="custom-controls-stacked">
                            <label class="custom-control custom-radio custom-control-inline me-2">
                                <input type="radio" class="custom-control-input" @if($item['is_admin'] == 1) checked @endif name="is_admin" checked="" value="1" >
                                <span class="custom-control-label">Yes</span>
                            </label>
                            <label class="custom-control custom-radio custom-control-inline me-2">
                                <input type="radio" class="custom-control-input" @if($item['is_admin'] == 2) checked @endif name="is_admin" checked="" value="2" >
                                <span class="custom-control-label">No</span>
                            </label>
                            <label class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" name="is_admin" @if($item['is_admin'] == 3) checked @endif value="3" >
                                <span class="custom-control-label">Khác. Cho phép truy cập dashboard</span>
                            </label>

                            <span class="text-danger d-flex justify-content-start">
                            @error('status')
                                {{ $message }}
                            @enderror
                        </span>
                        </div>
                    </div>
                    <div class="mb-3 col-6">
                        <label class="form-label">Gender</label>
                        <select name="gender" id="" class="form-control">
                            <option value="">Chọn</option>
                            <option value="1" @if($item['gender'] == 1) selected @endif>Nam</option>
                            <option value="2" @if($item['gender'] == 2) selected @endif>Nữ</option>
                        </select>
                        <span class="text-danger d-flex justify-content-start">
                            @error('date_of_birth')
                                {{ $message }}
                            @enderror
                        </span>
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