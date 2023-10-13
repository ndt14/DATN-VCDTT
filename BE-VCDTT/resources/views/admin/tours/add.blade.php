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
                <h2 class="page-title">
                    Tours management
                </h2>
            </div>
            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="{{url('/tour')}}" class="btn btn-default d-none d-sm-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-narrow-left" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M5 12l14 0"></path>
                            <path d="M5 12l4 4"></path>
                            <path d="M5 12l4 -4"></path>
                        </svg>
                        Back
                    </a>
                    <a href="{{url('/tour')}}" class="btn btn-default d-sm-none btn-icon">
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
            <form  class="card" action="{{ route('tour.add.new') }}" method="POST">
            @csrf
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="name" class="form-control" placeholder="Title" value="" >
                        <span class="text-danger d-flex justify-content-start">
                            @error('name')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Image</label>
                        <input type="text" name="main_img" class="form-control" placeholder="Image" value="">
                        <span class="text-danger d-flex justify-content-start">
                            @error('main_img')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Duration</label>
                        <input type="text" name="duration" class="form-control" placeholder="Duration" value="">
                        <span class="text-danger d-flex justify-content-start">
                            @error('duration')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-6">
                            <div class="form-label">Adult price</div>
                            <input name="adult_price" type="text" class="form-control" >
                            <span class="text-danger d-flex justify-content-start">
                            @error('adult_price')
                                {{ $message }}
                            @enderror
                        </span>
                        </div>
                        <div class="mb-3 col-6">
                            <div class="form-label">Child price</div>
                            <input name="child_price" type="text" class="form-control" >
                            <span class="text-danger d-flex justify-content-start">
                            @error('child_price')
                                {{ $message }}
                            @enderror
                        </span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-label">Location</div>
                        <input name="location" type="text" class="form-control" >
                        <span class="text-danger d-flex justify-content-start">
                            @error('location')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="mb-3">
                        <div class="form-label">Extract Location</div>
                        <input name="exact_location" type="text" class="form-control" >
                        <span class="text-danger d-flex justify-content-start">
                            @error('exact_location')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="mb-3">
                        <div class="form-label">Pathway</div>
                        <input name="pathway" type="text" class="form-control" >
                        <span class="text-danger d-flex justify-content-start">
                            @error('exact_location')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="mb-3">
                        <div class="form-label">View Count</div>
                        <input name="view_count" type="text" class="form-control" >
                        <span class="text-danger d-flex justify-content-start">
                            @error('view_count')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="mb-3">
                        <div class="form-label">Sale percentage</div>
                        <input name="sale_percentage" type="text" class="form-control" >
                        <span class="text-danger d-flex justify-content-start">
                            @error('sale_percentage')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    @if($categories)

                    <div class="row">
                        <div class="mb-3 ">
                            <div class="form-label">Choose Category</div>
                            <select name="category" id="" class="form-select">
                                <option value="">Select tours category...</option>
                                @foreach($categories as $category)
                                <option value="{{$category['id']}}">{{$category['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @endif
                    <div class="mb-3">
                        <div class="form-label">Content</div>
                        <textarea id="editor" rows="6" class="form-control text-editor" name="details" placeholder="Content"></textarea>
                        <span class="text-danger d-flex justify-content-start">
                            @error('details')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="mb-3">
                        <div class="form-label">Status</div>
                        <div class="custom-controls-stacked">
                            <label class="custom-control custom-radio custom-control-inline me-2">
                                <input type="radio" class="custom-control-input" name="status" checked="" value="1" >
                                <span class="custom-control-label">Yes</span>
                            </label>
                            <label class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" name="status" value="0" >
                                <span class="custom-control-label">No</span>
                            </label>

                            <span class="text-danger d-flex justify-content-start">
                            @error('status')
                                {{ $message }}
                            @enderror
                        </span>
                        </div>
                    </div>
                    </div>
                    <div class="card-footer text-right">
                        <!-- {{-- <button id="" type="submit" class="btn btn-primary">Submit</button> --}} -->
                        <input type="submit" value="Submit" name="btnSubmit" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('page_js')
<!-- {{-- <script type="text/javascript">
        if ($('#frmAdd').length) {
            $('#frmAdd').submit(function() {
                let options = {
                    beforeSubmit: function(formData, jqForm, options) {
                        $('#btnSubmitAdd').addClass('btn-loading');
                        $('#btnSubmitAdd').addClass("disabled");
                    },
                    success: function(response, statusText, xhr, $form) {
                        $('#btnSubmitAdd').removeClass('btn-loading');
                        if(response.status == 404){
                            $('#btnSubmitAdd').removeClass("disabled");
                            bs5Utils.Snack.show('danger', response.errors, delay = 5000, dismissible = true);
                        }
                        if(response.status == 200){
                            $('#btnSubmitAdd').removeClass("disabled");
                            bs5Utils.Snack.show('success', response.errors, delay = 6000, dismissible = true);
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
</script> --}} -->
@endSection
