@extends('admin.common.layout')
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
                <div class="alert alert-danger alert-dismissible fade show" role="alert" id="notiError">
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
                <h2 class="page-title">
                    Coupons management
                </h2>
            </div>
            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">


                        <a href="{{route('coupon.list')}}" class="btn btn-default d-none d-sm-inline-block">

                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-narrow-left" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M5 12l14 0"></path>
                                <path d="M5 12l4 4"></path>
                                <path d="M5 12l4 -4"></path>
                            </svg>
                            Back
                        </a>
                        <a href="{{url('/coupon')}}" class="btn btn-default d-sm-none btn-icon">
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
                <form id="frmAdd" class="card" action="/api/coupon-store" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter name" value="">
                            <span class="text-danger d-flex justify-content-start">
                                @error('name')
                                {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Code</label>
                            <input type="text" name="code" class="form-control" placeholder="Enter code" value="">
                            <span class="text-danger d-flex justify-content-start">
                                @error('code')
                                {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Percentage/Fixed</label>
                            <select class="form-select" name="type" id="">
                                <option value="1">Percentage</option>
                                <option value="2">Fixed</option>
                            </select>
                            <br>
                            <input type="text" name="price" class="form-control" placeholder="Enter number" value="">
                            <span class="text-danger d-flex justify-content-start">
                                @error('code')
                                {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Start active uses date</label>
                            <input type="date" name="start_date" class="form-control"
                                placeholder="Enter Start active uses date"
                                value="">
                            <span class="text-danger d-flex justify-content-start">
                                @error('start_date')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Expiration date</label>
                            <input type="date" name="expiration_date" class="form-control"
                                placeholder="Enter Expiration date"
                                value="">
                            <span class="text-danger d-flex justify-content-start">
                                @error('expiration_date')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="mb-3">
                            <div class="form-label">Status</div>
                            <div class="custom-controls-stacked">
                                <label class="custom-control custom-radio custom-control-inline me-2">
                                    <input type="radio" class="custom-control-input"
                                        @if (old('status') == '1') checked @endif name="status"
                                        checked="" value="1">
                                    <span class="custom-control-label">Active</span>
                                </label>
                                <label class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input"
                                        @if (old('status') == '0') checked @endif name="status"
                                        value="0">
                                    <span class="custom-control-label">Disable</span>
                                </label>

                                <span class="text-danger d-flex justify-content-start">
                                    @error('status')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                        </div>
                        {{-- Cho danh muc - tour --}}

                    </div>
                    <div class="card-footer text-right">
                        <button id="btnSubmitAdd" type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('page_js')
<script type="text/javascript">
    if ($('#frmAdd').length) {
        $('#frmAdd').submit(function() {
            let options = {
                beforeSubmit: function(formData, jqForm, options) {
                    $('#btnSubmitAdd').addClass('btn-loading');
                    $('#btnSubmitAdd').addClass("disabled");
                },
                success: function(response, statusText, xhr, $form) {
                    $('#btnSubmitAdd').removeClass('btn-loading');
                    if (response.status == 404) {
                        $('#btnSubmitAdd').removeClass("disabled");
                        bs5Utils.Snack.show('danger', response.message, delay = 5000, dismissible = true);
                    }
                    if (response.status == 200) {
                        $('#btnSubmitAdd').removeClass("disabled");
                        bs5Utils.Snack.show('success', response.message, delay = 6000, dismissible = true);
                    }
                },
                error: function() {
                    $('#btnSubmitAdd').removeClass('btn-loading');
                    $('#btnSubmitAdd').removeClass("disabled");
                    bs5Utils.Snack.show('danger', response.message, delay = 5000, dismissible = true);
                },
                dataType: 'json',
                clearForm: false,
                resetForm: false
            };
            $(this).ajaxSubmit(options);
            return false;
        });
    }
</script>
@endSection