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
                    Roles Management
                </h2>
            </div>
            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="{{url('/role')}}" class="btn btn-default d-none d-sm-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-narrow-left" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M5 12l14 0"></path>
                            <path d="M5 12l4 4"></path>
                            <path d="M5 12l4 -4"></path>
                        </svg>
                        Quay lại
                    </a>
                    <a href="{{url('/role')}}" class="btn btn-default d-sm-none btn-icon">
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
            <form id="frmAdd" class="card" action="" method="POST">
            <div class="card-header">
                <h2 class="card-title">
                    Vai trò - Quyền
                </h2>
            </div>
            @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="mb-3 col-12">
                            <label class="form-label">Tên vai trò</label>
                            <input type="text" name="name" class="form-control" placeholder="Tên vai trò" value="" >
                            <span class="text-danger d-flex justify-content-start">
                                @error('name')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="mb-3 col-12">
                            <label class="form-label">Mô tả</label>
                            <input type="text" name="guard_name" class="form-control" placeholder="Không bắt buộc" value="" >
                        </div>
                       
                    </div>
                    <div class="row">
                        <div class="mb-3 col-6">
                            <p class="text-primary" style="font-weight: bold;">Vai trò này có quyền gì?</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-12">
                            <div class="card">
                                <div class="card-header">
                                  <h3 class="card-title">Tích để chọn quyền cho vai trò</h3>
                                </div>
                                
                                <div class="table-responsive">
                                  <table class="table card-table table-vcenter text-nowrap datatable">
                                    <thead>
                                      <tr>
                                        <th class="text-primary" style="font-weight: 700;">Chức năng</th>
                                        <th class="text-primary" style="font-weight: 700;">Truy cập</th>
                                        <th class="text-primary" style="font-weight: 700;">Thêm</th>
                                        <th class="text-primary" style="font-weight: 700;">Sửa</th>
                                        <th class="text-primary" style="font-weight: 700;">Xóa</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-black" style="font-weight: 500;">Quản lý tour</td>
                                            <td colspan="3"><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                        </tr>
                                        <tr>
                                            <td>|-- Thêm mới tour</td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                        </tr>
                                        <tr>
                                            <td>|-- Chỉnh sửa tour</td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                        </tr>
                                        <tr>
                                            <td>|-- Xóa bỏ tour</td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                        </tr>
                                         <tr>
                                            <td class="text-black" style="font-weight: 500;">Quản lý đánh giá tour</td>
                                            <td colspan="3"><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                        </tr>
                                        <tr>
                                            <td>|-- Trả lời đánh giá</td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                        </tr>
                                        <tr>
                                            <td>|-- Xóa đánh giá</td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                        </tr>
                                        <tr>
                                            <td class="text-black" style="font-weight: 500;">Quản lý bài viết</td>
                                            <td colspan="3"><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                        </tr>
                                        <tr>
                                            <td>|-- Thêm mới bài viết</td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                        </tr>
                                        <tr>
                                            <td>|-- Chỉnh sửa bài viết</td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                        </tr>
                                        <tr>
                                            <td>|-- Xóa bỏ bài viết</td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                        </tr>

                                        <tr>
                                            <td class="text-black" style="font-weight: 500;">Quản lý faq</td>
                                            <td colspan="3"><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                        </tr>
                                        <tr>
                                            <td>|-- Thêm mới faq</td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                        </tr>
                                        <tr>
                                            <td>|-- Chỉnh sửa faq</td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                        </tr>
                                        <tr>
                                            <td>|-- Xóa bỏ faq</td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                        </tr>
                                        <tr>
                                            <td class="text-black" style="font-weight: 500;">Quản lý danh mục</td>
                                            <td colspan="3"><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                        </tr>
                                        <tr>
                                            <td>|-- Thêm mới danh mục</td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                        </tr>
                                        <tr>
                                            <td>|-- Chỉnh sửa danh mục</td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                        </tr>
                                        <tr>
                                            <td>|-- Xóa bỏ danh mục</td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                        </tr>
                                        <tr>
                                            <td class="text-black" style="font-weight: 500;">Quản lý hóa đơn</td>
                                            <td colspan="3"><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                        </tr>
                                        <tr>
                                            <td>|-- Chỉnh sửa hóa đơn</td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                        </tr>
                                        <tr>
                                            <td class="text-black" style="font-weight: 500;">Quản lý mã giảm giá</td>
                                            <td colspan="3"><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                        </tr>
                                        <tr>
                                            <td>|-- Thêm mới mã giảm giá</td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                        </tr>
                                        <tr>
                                            <td>|-- Chỉnh sửa mã giảm giá</td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                        </tr>
                                        <tr>
                                            <td>|-- Xóa bỏ mã giảm giá</td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                        </tr>
                                        <tr>
                                            <td class="text-black" style="font-weight: 500;">Quản lý tài khoản</td>
                                            <td colspan="3"><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                        </tr>
                                        <tr>
                                            <td>|-- Thêm mới tài khoản</td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                        </tr>
                                        <tr>
                                            <td>|-- Chỉnh sửa tài khoản</td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                        </tr>
                                        <tr>
                                            <td>|-- Xóa bỏ tài khoản</td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></td>
                                        </tr>
                                    </tbody>
                                  </table>
                                </div>
                                <div class="card-footer d-flex align-items-center">
                                  <p class="m-0 text-secondary">Showing <span>1</span> to <span>8</span> of <span>16</span> entries</p>
                                  <ul class="pagination m-0 ms-auto">
                                    <li class="page-item disabled">
                                      <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/chevron-left -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M15 6l-6 6l6 6"></path></svg>
                                        prev
                                      </a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item active"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link" href="#">4</a></li>
                                    <li class="page-item"><a class="page-link" href="#">5</a></li>
                                    <li class="page-item">
                                      <a class="page-link" href="#">
                                        next <!-- Download SVG icon from http://tabler-icons.io/i/chevron-right -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M9 6l6 6l-6 6"></path></svg>
                                      </a>
                                    </li>
                                  </ul>
                                </div>
                              </div>
                        </div>
                    </div>
                    
                    </div>
                    <div class="card-footer text-right">
                        <button id="btnSubmitAdd" type="submit" class="btn btn-primary">Thêm mới</button>
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
