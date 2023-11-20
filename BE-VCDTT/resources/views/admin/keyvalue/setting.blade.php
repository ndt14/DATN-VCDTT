@extends('admin.common.layout')
@section('meta_title')
Hệ thống
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
                    Hệ thống
                </h1>
            </div>
            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="row row-deck row-cards">
            <div class="col-sm-12">
            <form id="frmEdit" class="card border-0 shadow-lg rounded-4 " action="{{ route('settings',)}}" method="POST" enctype="multipart/form-data">
            <div class="card-header">
            </div>
            @csrf
                <div class="card-body">
                    <div class="row">
                        @foreach ($data as $item)
                        @if($item->key=='logo' || $item->key=='favicon' )
                        <div class="mb-3 col-6">
                            <label class="form-label">{{ $item->name }}</label>
                            <input type="file" name="{{ $item->key }}" class="form-control" value="{{ $item->value }}">
                            <br>
                            <img src="{{ $item->value?''.Storage::url($item->value):'null'}}" width="200px" alt="{{ $item->value }}">
                        </div>
                        @endif
                        @endforeach
                    </div>
                    <div class="row">
                        @foreach ($data as $item)
                        @if($item->key=='webTitle' || $item->key=='email' || $item->key=='address' )
                        <div class="mb-3 col-4">
                            <label class="form-label">{{ $item->name }}</label>
                            <input type="text" name="{{ $item->key }}" class="form-control"  value="{{ $item->value }}" >
                        </div>
                        @endif
                        @endforeach
                    </div>
                    <div class="row">
                        @foreach ($data as $item)
                        @if($item->key=='webPhoneNumber1' || $item->key=='webPhoneNumber2' )
                        <div class="mb-3 col-6">
                            <label class="form-label">{{ $item->name }}</label>
                            <input type="text" name="{{ $item->key }}" class="form-control"  value="{{ $item->value }}" >
                        </div>
                        @endif
                        @endforeach
                    </div>
                    <div class="row">
                        @foreach ($data as $item)
                        @if($item->key=='bankName' || $item->key=='bankAccountName' || $item->key=='bankAccountNumber' )
                        <div class="mb-3 col-4">
                            <label class="form-label">{{ $item->name }}</label>
                            <input type="text" name="{{ $item->key }}" class="form-control"  value="{{ $item->value }}" >
                        </div>
                        @endif
                        @endforeach
                    </div>
                    <div class="row">
                        @foreach ($data as $item)
                        @if($item->key=='banner' )
                        <div class="mb-3 row">
                            <label class="form-label">{{ $item->name }}</label>
                            <input type="file" name="{{ $item->key }}" class="form-control" value="{{ $item->value }}">
                            <div class="row mt-1"><img src="{{ $item->value?''.Storage::url($item->value):'null'}}" width="100%" alt="{{ $item->value }}"></div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
                    <div class="card-footer text-right">
                        <button id="btnSubmitEdit" type="submit" class="btn btn-indigo">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('page_js')
<script type="text/javascript">
</script>
@endSection
