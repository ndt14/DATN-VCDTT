@extends('admin.common.layout')
@section('meta_title')
Chỉnh sửa câu hỏi & trả lời
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
                <h1 class="text-indigo mb-4" style="font-size: 36px;">
                   Quản lý Faqs
                </h2>
            </div>
            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="{{url('/faq')}}" class="btn btn-default d-none d-sm-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-narrow-left" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M5 12l14 0"></path>
                            <path d="M5 12l4 4"></path>
                            <path d="M5 12l4 -4"></path>
                        </svg>
                        Quay lại
                    </a>
                    <a href="{{url('/faq')}}" class="btn btn-default d-sm-none btn-icon">
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
                <form id="frmEdit" class="card border-0 shadow-lg rounded-4 " action="{{ route('faq.edit', ['id' => $response->id])}}" method="POST">
                    @csrf

                    <input type="hidden" name="id" value="{{$response->id}}">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Câu hỏi</label>
                            <input type="text" name="question" class="form-control" placeholder="Nhập câu hỏi" value="{{$response->question}}">
                            <span class="text-danger d-flex justify-content-start">
                                @error('question')
                                {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Câu trả lời</label>
                            <textarea name="answer" class="form-control ckeditor" placeholder="" id="" cols="30" rows="10">{{$response->answer}}</textarea>
                            <span class="text-danger d-flex justify-content-start">
                                @error('answer')
                                {{ $message }}
                                @enderror
                            </span>
                        </div>

                    </div>
                    <div class="card-footer text-right">
                        <button id="btnSubmitEdit" type="submit" class="btn btn-indigo">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('page_js')
{{-- <script type="text/javascript">
    if ($('#frmEdit').length) {
        $('#frmEdit').submit(function() {
            let options = {
                beforeSubmit: function(formData, jqForm, options) {
                    $('#btnSubmitEdit').addClass('btn-loading');
                    $('#btnSubmitEdit').addClass("disabled");
                },
                success: function(response, statusText, xhr, $form) {
                    $('#btnSubmitEdit').removeClass('btn-loading');
                    if (response.status == 404) {
                        $('#btnSubmitEdit').removeClass("disabled");
                        bs5Utils.Snack.show('danger', response.message, delay = 5000, dismissible = true);
                    }
                    if (response.status == 200) {
                        $('#btnSubmitEdit').removeClass("disabled");
                        bs5Utils.Snack.show('success', response.message, delay = 6000, dismissible = true);
                    }
                },
                error: function() {
                    $('#btnSubmitEdit').removeClass('btn-loading');
                    $('#btnSubmitEdit').removeClass("disabled");
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
