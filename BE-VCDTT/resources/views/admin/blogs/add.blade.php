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
                        Blogs management
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ url('/blog') }}" class="btn btn-default d-none d-sm-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-narrow-left"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M5 12l14 0"></path>
                                <path d="M5 12l4 4"></path>
                                <path d="M5 12l4 -4"></path>
                            </svg>
                            Back
                        </a>
                        <a href="{{ url('/blog') }}" class="btn btn-default d-sm-none btn-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-narrow-left"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
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
                    <form id="frmAdd" class="card" action="{{ route('blog.add') }}" method="POST">
                        <div class="card-header">
                            <h2 class="card-title">
                                Add new blog
                            </h2>
                        </div>
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3 col-6">
                                    <label class="form-label">Title</label>
                                    <input type="text" name="title" class="form-control" placeholder="Title"
                                        value="">
                                    <span class="text-danger d-flex justify-content-start">
                                        @error('title')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="mb-3 col-6">
                                    <label class="form-label">Author</label>
                                    <input type="text" name="author" class="form-control" placeholder="" value="">
                                    <span class="text-danger d-flex justify-content-start">
                                        @error('author')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>

                            </div>
                            <div class="mb-3 col-8">
                                <label class="form-label">Image</label>
                                <input type="text" name="main_img" class="form-control" placeholder="Image"
                                    value="">
                                <span class="text-danger d-flex justify-content-start">
                                    @error('main_img')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="mb-3 col-10">
                                <div class="form-label">Short description</div>
                                <textarea name="short_desc" rows="5" type="text" class="form-control"></textarea>
                                <span class="text-danger d-flex justify-content-start">
                                    @error('short_desc')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="mb-3">
                                <div class="form-label">Description</div>
                                <textarea id="editor" rows="6" class="form-control text-editor ckeditor" name="description"></textarea>
                                <span class="text-danger d-flex justify-content-start">
                                    @error('description')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="mb-3">
                                <div class="form-label">Status</div>
                                <div class="custom-controls-stacked">
                                    <label class="custom-control custom-radio custom-control-inline me-2">
                                        <input type="radio" class="custom-control-input" name="status" checked=""
                                            value="1">
                                        <span class="custom-control-label">Active</span>
                                    </label>
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="custom-control-input" name="status"
                                            value="0">
                                        <span class="custom-control-label">Unactive</span>
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
        //     if ($('#frmAdd').length) {
        //         $('#frmAdd').submit(function() {
        //             let options = {
        //                 beforeSubmit: function(formData, jqForm, options) {
        //                     $('#btnSubmitAdd').addClass('btn-loading');
        //                     $('#btnSubmitAdd').addClass("disabled");
        //                 },
        //                 success: function(response, statusText, xhr, $form) {
        //                     $('#btnSubmitAdd').removeClass('btn-loading');
        //                     if(response.status == 500){
        //                         $('#btnSubmitAdd').removeClass("disabled");
        //                         bs5Utils.Snack.show('danger', response.message, delay = 5000, dismissible = true);
        //                     }
        //                     if(response.status == 200){
        //                         $('#btnSubmitAdd').removeClass("disabled");
        //                         bs5Utils.Snack.show('success', response.message, delay = 6000, dismissible = true);
        //                     }
        //                 },
        //                 error: function() {
        //                     $('#btnSubmitAdd').removeClass('btn-loading');
        //                     $('#btnSubmitAdd').removeClass("disabled");
        //                     bs5Utils.Snack.show('danger', 'Error, please check your input', delay = 5000, dismissible = true);
        //                 },
        //                 dataType: 'json',
        //                 clearForm: false,
        //                 resetForm: false
        //             };
        //             $(this).ajaxSubmit(options);
        //             return false;
        //         });
        // }
    </script>
@endSection
