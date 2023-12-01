@extends('admin.common.layout')
@section('meta_title')
Thêm mới ảnh
@endSection
@section('content')

<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col-auto">
                <!-- Page pre-title -->
                <!-- <div class="page-pretitle">
                    Overview
                </div> -->
                <h1 class="text-indigo mb-4" style="font-size: 36px;">
                    Quản lý thư viện ảnh
                </h1>
            </div>
            <div class="top-0" style="z-index: 100; position: fixed;">
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
            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">


                        <a href="{{route('image.list')}}" class="btn btn-default d-none d-sm-inline-block">

                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-narrow-left" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M5 12l14 0"></path>
                                <path d="M5 12l4 4"></path>
                                <path d="M5 12l4 -4"></path>
                            </svg>
                            Quay lại
                        </a>
                        <a href="{{url('/image')}}" class="btn btn-default d-sm-none btn-icon">
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
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Files upload</h3>
                    <div class="mb-3 col-4">
                        <select id="tour_select" class="form-select">
                                <option value="" >Ảnh tự do</option>
                            @foreach($tours as $item):
                                <option value="{{$item->id }}" >{{$item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <form class="dropzone" id="dropzone-files" action="/file-upload" autocomplete="off" novalidate>
                    @csrf
                        <input type="hidden" id="tour_id" name="tour_id" value="">
                        <div class="fallback">
                            <input name="files[]" type="file"/>
                        </div>
                        <div class="dz-message">
                            <h3 class="dropzone-msg-title">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-upload" style="width: 50px; height: 50px;" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path>
                                <path d="M7 9l5 -5l5 5"></path>
                                <path d="M12 4l0 12"></path>
                                </svg>
                            </h3>
                            <span class="dropzone-msg-desc" id="dropzone_text"></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('page_css')
<link href="{{ asset('admin/assets/libs/dropzone/dist/dropzone.css')}}" rel="stylesheet"/>
@endsection

@section('page_js')
<script src="{{ asset('admin/assets/libs/dropzone/dist/dropzone-min.js')}}" rel="stylesheet"></script>
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function() {
        new Dropzone("#dropzone-files", {
            paramName: "files", // The name that will be used to transfer the file
            maxFilesize:  30, // MB
            uploadMultiple: true,
            accept: function (file, done) {
                done();
            },
            success: function (response) {
            }
        });
    });
$('#tour_select').change(function() {
    let selectedTourId = $(this).val();
    $('#tour_id').val(selectedTourId);
    $('#dropzone-text').html('Kéo thả Hoặc ấn vào để chọn nhiều ảnh cho Tour '+selectedTourId);

});
</script>
@endSection
