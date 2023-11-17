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
                <h1 class="text-indigo mb-4" style="font-size: 36px;">
                    Hệ thống
                </h2>
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
            <form id="frmEdit" class="card border-0 shadow-lg rounded-4 " action="{{ route('settings',)}}" method="POST">
            <div class="card-header">
            </div>
            @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="mb-3 col-6">
                            <label class="form-label">Ảnh logo chính</label>
                            <input type="file" name="main_img" class="form-control" placeholder="Image" value="">
                            <br>
                            <img src="https://tse3.mm.bing.net/th?id=OIP.JJ4ZxNkVDMO5U1c5-m2rzAHaFd&pid=Api&P=0&h=220" width="200px" alt="">
                        </div>
                        <div class="mb-3 col-6">
                            <label class="form-label">Ảnh logo favicon</label>
                            <input type="file" name="m" class="form-control" placeholder="Image" value="">
                            <br>
                            <img src="https://tse3.mm.bing.net/th?id=OIP.JJ4ZxNkVDMO5U1c5-m2rzAHaFd&pid=Api&P=0&h=220" width="200px" alt="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-4">
                            <label class="form-label">Tên website</label>
                            <input type="text" name="webTitle" class="form-control" placeholder="VCDTT" value="" >
                        </div>
                        <div class="mb-3 col-4">
                            <label class="form-label">Email đại diện/liên hệ</label>
                            <input type="text" name="email" class="form-control" placeholder="vidu@gmail.com" value="">
                        </div>
                        <div class="mb-3 col-4">
                            <div class="form-label">Địa chỉ trụ sở</div>
                            <input type="text" name="adress" class="form-control" placeholder="Thành phố/Tỉnh, huyện, đường,..." value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-6">
                            <div class="form-label">Số điện thoại liên hệ</div>
                            <input type="text" name="webPhoneNumber1" class="form-control" placeholder="Số điện thoại để khách liên hệ" value="">
                        </div>
                        <div class="mb-3 col-6">
                            <div class="form-label">Số điện thoại liên hệ khác</div>
                            <input type="text" name="webPhoneNumber2" class="form-control" placeholder="Số điện thoại để khách liên hệ" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-4">
                            <div class="form-label">Tên ngân hàng sử dụng</div>
                            <input type="text" name="bankName" class="form-control" placeholder="MBBank, Viettel Pay,..." value="">
                        </div>
                        <div class="mb-3 col-4">
                            <div class="form-label">Tên tài khoản ngân hàng</div>
                            <input type="text" name="bankAccountName" class="form-control" placeholder="Tên tài khoản. Ví dụ:NGUYEN VAN A" value="">
                        </div>
                        <div class="mb-3 col-4">
                            <div class="form-label">Số tài khoản ngân hàng</div>
                            <input type="text" name="bankAccountNumber" class="form-control" placeholder="Số tài khoản" value="">
                        </div>
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
