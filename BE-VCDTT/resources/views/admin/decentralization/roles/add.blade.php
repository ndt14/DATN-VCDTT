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
            <form id="frmAdd" class="card" action="{{route('role.add')}}" method="POST">
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
                            <input type="text" name="desc_role" class="form-control" placeholder="Không bắt buộc" value="" >
                            <input type="hidden" name="guard_name" value="web">
                        </div>
                       
                    </div>
                    <div class="row">
                        <div class="mb-3 col-6">
                            <p class="text-indigo" style="font-weight: bold;">Vai trò này có quyền gì?</p>
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
                                        <th class="text-indigo" style="font-weight: 700;">Chức năng</th>
                                        <th class="text-indigo" style="font-weight: 700;">Truy cập</th>
                                        <th class="text-indigo" style="font-weight: 700;">Thêm</th>
                                        <th class="text-indigo" style="font-weight: 700;">Sửa</th>
                                        <th class="text-indigo" style="font-weight: 700;">Xóa</th>
                                        <th class="text-indigo" style="font-weight: 700;">Trả lời</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                        <tr style="border-bottom: 1px solid #0D6EFD;">
                                            <td class="text-black" style="font-weight: 500;">Quản lý tour</td>
                                            <td><input name="permission[]" data-bs-toggle="tooltip" title="Quyền truy cập mục tour" class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices" value="4"></td>
                                            <td><input name="permission[]" data-bs-toggle="tooltip" title="Quyền thêm mới tour" class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices" value="1"></td>
                                            <td><input name="permission[]" data-bs-toggle="tooltip" title="Quyền sửa tour" class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices" value="2"></td>
                                            <td><input name="permission[]" data-bs-toggle="tooltip" title="Quyền xóa tour" class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices" value="3"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="8" >|-- Thêm mới tour</td>
                                            
                                        </tr>
                                        <tr>
                                            <td colspan="8">|-- Chỉnh sửa tour</td>
                                            
                                        </tr>
                                        <tr>
                                            <td colspan="8">|-- Xóa bỏ tour</td>
                                        </tr>
                                         <tr style="border-bottom: 1px solid #0D6EFD;">
                                            <td class="text-black" style="font-weight: 500;">Quản lý đánh giá tour</td>
                                            <td colspan="3"><input class="form-check-input m-0 align-middle" name="permission[]" data-bs-toggle="tooltip" title="Quyền truy cập mục đánh giá" type="checkbox" aria-label="Select all invoices" value="30"></td>
                                            <td><input class="form-check-input m-0 align-middle" name="permission[]" data-bs-toggle="tooltip" title="Quyền xóa đánh giá" type="checkbox" aria-label="Select all invoices" value="29"></td>
                                            <td><input class="form-check-input m-0 align-middle" name="permission[]" type="checkbox" data-bs-toggle="tooltip" title="Quyền trả lời đánh giá" aria-label="Select all invoices" value="28"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="8">|-- Trả lời đánh giá</td>
                                        </tr>
                                        <tr>
                                            <td colspan="8">|-- Xóa đánh giá</td>
                                        </tr>
                                        <tr style="border-bottom: 1px solid #0D6EFD;">
                                            <td class="text-black" style="font-weight: 500;">Quản lý bài viết</td>
                                            <td><input name="permission[]" class="form-check-input m-0 align-middle" data-bs-toggle="tooltip" title="Quyền truy cập mục bài viết" type="checkbox" aria-label="Select all invoices" value="27"></td>
                                            <td><input name="permission[]" class="form-check-input m-0 align-middle" data-bs-toggle="tooltip" title="Quyền thêm bài viết" type="checkbox" aria-label="Select all invoices" value="24"></td>
                                            <td><input name="permission[]" class="form-check-input m-0 align-middle" data-bs-toggle="tooltip" title="Quyền sửa bài viết" type="checkbox" aria-label="Select all invoices" value="25"></td>
                                            <td><input name="permission[]" class="form-check-input m-0 align-middle" data-bs-toggle="tooltip" title="Quyền xóa bài viết" type="checkbox" aria-label="Select all invoices" value="26"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="8">|-- Thêm mới bài viết</td>
                                            
                                        </tr>
                                        <tr>
                                            <td colspan="8">|-- Chỉnh sửa bài viết</td>
                                        </tr>
                                        <tr>
                                            <td colspan="8">|-- Xóa bỏ bài viết</td>
                                        </tr>

                                        <tr style="border-bottom: 1px solid #0D6EFD;">
                                            <td class="text-black" style="font-weight: 500;">Quản lý faq</td>
                                            <td><input name="permission[]" data-bs-toggle="tooltip" title="Quyền truy cập mục faq" class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"  value="23"></td>
                                            <td><input name="permission[]" data-bs-toggle="tooltip" title="Quyền thêm mới faq" class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices" value="20"></td>
                                            <td><input name="permission[]" class="form-check-input m-0 align-middle"  data-bs-toggle="tooltip" title="Quyền sửa faq" type="checkbox" aria-label="Select all invoices" value="21"></td>
                                            <td><input name="permission[]" class="form-check-input m-0 align-middle" type="checkbox"  data-bs-toggle="tooltip" title="Quyền xóa faq" aria-label="Select all invoices" value="22"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="8">|-- Thêm mới faq</td>
                                            
                                        </tr>
                                        <tr>
                                            <td colspan="8">|-- Chỉnh sửa faq</td>
                                        </tr>
                                        <tr>
                                            <td colspan="8">|-- Xóa bỏ faq</td>
                                        </tr>
                                        <tr style="border-bottom: 1px solid #0D6EFD;">
                                            <td class="text-black" style="font-weight: 500;">Quản lý danh mục</td>
                                            <td><input name="permission[]" class="form-check-input m-0 align-middle"  data-bs-toggle="tooltip" title="Quyền truy cập mục danh mục" type="checkbox" aria-label="Select all invoices" value="11"></td>
                                            <td><input name="permission[]" class="form-check-input m-0 align-middle" data-bs-toggle="tooltip" title="Quyền thêm danh mục" type="checkbox" aria-label="Select all invoices" value="8"></td>
                                            <td><input name="permission[]" class="form-check-input m-0 align-middle" type="checkbox" data-bs-toggle="tooltip" title="Quyền sửa danh mục" aria-label="Select all invoices" value="9"></td>
                                            <td><input name="permission[]" class="form-check-input m-0 align-middle" type="checkbox" data-bs-toggle="tooltip" title="Quyền xóa danh mục" aria-label="Select all invoices" value="10"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="8">|-- Thêm mới danh mục</td>
                                        </tr>
                                        <tr>
                                            <td colspan="8">|-- Chỉnh sửa danh mục</td>
                                        </tr>
                                        <tr>
                                            <td colspan="8">|-- Xóa bỏ danh mục</td>
                                        </tr>
                                        <tr style="border-bottom: 1px solid #0D6EFD;">
                                            <td class="text-black" style="font-weight: 500;">Quản lý hóa đơn</td>
                                            <td colspan="2"><input name="permission[]" class="form-check-input m-0 align-middle" data-bs-toggle="tooltip" title="Quyền truy cập mục hóa đơn" type="checkbox" aria-label="Select all invoices" value="7"></td> 
                                            <td><input name="permission[]" class="form-check-input m-0 align-middle" type="checkbox" data-bs-toggle="tooltip" title="Quyền sửa hóa đơn" aria-label="Select all invoices" value="5"></td>
                                            <td><input name="permission[]" class="form-check-input m-0 align-middle" type="checkbox" data-bs-toggle="tooltip" title="Quyền xóa hóa đơn" aria-label="Select all invoices" value="6"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="8">|-- Chỉnh sửa hóa đơn</td>
                                        </tr>
                                        <tr>
                                            <td colspan="8">|-- Chỉnh sửa xóa hóa đơn</td>
                                        </tr>
                                        <tr style="border-bottom: 1px solid #0D6EFD;">
                                            <td class="text-black" style="font-weight: 500;">Quản lý mã giảm giá</td>
                                            <td><input name="permission[]" class="form-check-input m-0 align-middle" data-bs-toggle="tooltip" title="Quyền truy cập mục mã giảm giá" type="checkbox" aria-label="Select all invoices" value="15"></td>
                                            <td><input name="permission[]" class="form-check-input m-0 align-middle" data-bs-toggle="tooltip" title="Quyền thêm mã giảm giá" type="checkbox" aria-label="Select all invoices" value="12"></td>
                                            <td><input name="permission[]" class="form-check-input m-0 align-middle" type="checkbox" data-bs-toggle="tooltip" title="Quyền sửa mã giảm giá" aria-label="Select all invoices" value="13"></td>
                                            <td><input name="permission[]" class="form-check-input m-0 align-middle" type="checkbox" data-bs-toggle="tooltip" title="Quyền xóa mã giảm giá" aria-label="Select all invoices" value="14"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="8">|-- Thêm mới mã giảm giá</td>
                                            
                                        </tr>
                                        <tr>
                                            <td colspan="8">|-- Chỉnh sửa mã giảm giá</td>
                                        </tr>
                                        <tr>
                                            <td colspan="8">|-- Xóa bỏ mã giảm giá</td>
                                        </tr>
                                        <tr style="border-bottom: 1px solid #0D6EFD;">
                                            <td class="text-black" style="font-weight: 500;">Quản lý tài khoản</td>
                                            <td><input name="permission[]" class="form-check-input m-0 align-middle" data-bs-toggle="tooltip" title="Quyền truy cập mục tài khoản" type="checkbox" aria-label="Select all invoices" value="19"></td>
                                            <td><input name="permission[]" class="form-check-input m-0 align-middle" data-bs-toggle="tooltip" title="Quyền thêm tài khoản" type="checkbox" aria-label="Select all invoices" value="16"></td>
                                            <td><input name="permission[]" class="form-check-input m-0 align-middle" type="checkbox" data-bs-toggle="tooltip" title="Quyền sửa tài khoản" aria-label="Select all invoices" value="17"></td>
                                            <td><input name="permission[]" class="form-check-input m-0 align-middle" type="checkbox" data-bs-toggle="tooltip" title="Quyền xóa tài khoản" aria-label="Select all invoices" value="18"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="8">|-- Thêm mới tài khoản</td>
                                            
                                        </tr>
                                        <tr>
                                            <td colspan="8">|-- Chỉnh sửa tài khoản</td>
                                        </tr>
                                        <tr>
                                            <td colspan="8">|-- Xóa bỏ tài khoản</td>
                                        </tr>
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                              <span class="text-danger d-flex justify-content-start">
                                @error('permission')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>
                    
                    </div>
                    <div class="card-footer text-right">
                        <button id="btnSubmitAdd" type="submit" class="btn btn-indigo">Thêm mới</button>
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
