@extends('admin.common.layout')
@section('meta_title')
Sửa thông tin người dùng
@endSection
@section('content')

<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
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
            <div class="col">
                <!-- Page pre-title -->
                <!-- <div class="page-pretitle">
                    Overview
                </div> -->
                <h1 class="text-indigo mb-4" style="font-size: 36px;">
                    Quản lý tài khoản
                </h1>
            </div>
            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="{{url('/user')}}" class="btn btn-default d-none d-sm-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-narrow-left" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M5 12l14 0"></path>
                            <path d="M5 12l4 4"></path>
                            <path d="M5 12l4 -4"></path>
                        </svg>
                        Back
                    </a>
                    <a href="{{url('/user')}}" class="btn btn-default d-sm-none btn-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-narrow-left" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M5 12l14 0"></path>
                            <path d="M5 12l4 4"></path>
                            <path d="M5 12l4 -4"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="row row-deck row-cards">
            <div class="col-sm-12 col-md-8 offset-md-2">
            <form id="frmAdd" class="card border-0 shadow-lg rounded-4 " action="{{route('user.edit', ['id' => $response->id])}}" method="POST">
            <div class="card-header">
                <h2 class="card-title">
                    Edit {{$response->name}}
                </h2>
            </div>
            @csrf

                <div class="card-body">
                    <div class="row">
                        <div class="mb-3 col-6">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Name" value="{{$response->name}}" >
                            <span class="text-danger d-flex justify-content-start">
                                @error('name')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="mb-3 col-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="" value="{{$response->email}}">
                            <span class="text-danger d-flex justify-content-start">
                                @error('email')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                    </div>
                    <div class="row">
                        <div class="mb-3 col-6">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Password" value="{{ $response->password }}">
                            <span class="text-danger d-flex justify-content-start">
                                @error('password')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="mb-3 col-6">
                            <label class="form-label">Image</label>
                            <input type="text" name="image" class="form-control" placeholder="Image" value="{{$response->image}}">
                            <span class="text-danger d-flex justify-content-start">
                                @error('image')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-6">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone_number" class="form-control" placeholder="Phone" value="{{$response->phone_number}}">
                            <span class="text-danger d-flex justify-content-start">
                                @error('phone_number')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="mb-3 col-6">
                            <label class="form-label">Ngày sinh</label>
                            <input type="date" name="date_of_birth" class="form-control" placeholder="Date of birth" value="{{$response->date_of_birth}}">
                            <span class="text-danger d-flex justify-content-start">
                                @error('date_of_birth')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-6">
                            <label class="form-label">Address</label>
                            <input type="text" name="address" class="form-control" placeholder="address" value="{{$response->address}}">
                            <span class="text-danger d-flex justify-content-start">
                                @error('address')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="mb-3 col-6">
                            <label class="form-label">Gender</label>
                            <select name="gender" id="" class="form-control">
                                <option value="">Chọn</option>
                                <option value="1" @if($response->gender == 1) selected @endif>Nam</option>
                                <option value="2" @if($response->gender == 2) selected @endif>Nữ</option>
                            </select>
                            <span class="text-danger d-flex justify-content-start">
                                @error('gender')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-6">
                            <div class="form-label">Status</div>
                            <div class="custom-controls-stacked">
                                <label class="custom-control custom-radio custom-control-inline me-2">
                                    <input type="radio" class="custom-control-input"  @if($response->status == 1) checked @endif  name="status" checked="" value="1" >
                                    <span class="custom-control-label">Yes</span>
                                </label>
                                <label class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" @if($response->status == 0) checked @endif name="status" value="0" >
                                    <span class="custom-control-label">No</span>
                                </label>

                                <span class="text-danger d-flex justify-content-start">
                                @error('status')
                                    {{ $message }}
                                @enderror
                            </span>
                            </div>
                        </div>

                        <div class="mb-3 col-6">
                            <div class="form-label">Is Admin</div>
                            <div class="custom-controls-stacked">
                                <label class="custom-control custom-radio custom-control-inline me-2">
                                    <input type="radio" class="custom-control-input" @if($response->is_admin == 1) checked @endif name="is_admin" checked="" value="1" >
                                    <span class="custom-control-label">Yes</span>
                                </label>
                                <label class="custom-control custom-radio custom-control-inline me-2">
                                    <input type="radio" class="custom-control-input" @if($response->is_admin == 2) checked @endif name="is_admin" checked="" value="2" >
                                    <span class="custom-control-label">No</span>
                                </label>
                                <label class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" @if($response->is_admin == 3) checked @endif name="is_admin" value="3" >
                                    <span class="custom-control-label">Khác. Cho phép truy cập dashboard</span>
                                </label>
                                <span class="text-danger d-flex justify-content-start">
                                @error('is_admin')
                                    {{ $message }}
                                @enderror
                            </span>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="card-footer text-right">
                        <button id="btnSubmitAdd" type="submit" class="btn btn-indigo">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('page_js')
{{-- <script type="text/javascript">
        if ($('#frmAdd').length) {
            $('#frmAdd').submit(function() {
                let options = {
                    beforeSubmit: function(formData, jqForm, options) {
                        $('#btnSubmitAdd').addClass('btn-loading');
                        $('#btnSubmitAdd').addClass("disabled");
                    },
                    success: function(response, statusText, xhr, $form) {
                        $('#btnSubmitAdd').removeClass('btn-loading');
                        if(response.status == 500){
                            $('#btnSubmitAdd').removeClass("disabled");
                            bs5Utils.Snack.show('danger', response.message, delay = 5000, dismissible = true);
                        }
                        if(response.status == 200){
                            $('#btnSubmitAdd').removeClass("disabled");
                            bs5Utils.Snack.show('success', response.message, delay = 6000, dismissible = true);
                        }
                    },
                    error: function() {
                        $('#btnSubmitAdd').removeClass('btn-loading');
                        $('#btnSubmitAdd').removeClass("disabled");
                        bs5Utils.Snack.show('danger', 'Error, please check your input', delay = 5000, dismissible = true);
                    },
                    dataType: 'json',
                    clearForm: false,
                    resetForm: false
                };
                $(this).ajaxSubmit(options);
                return false;
            });
    }
</script> --}}
@endSection
