@extends('admin.common.layout')
@section('meta_title')
Chỉnh sửa phần quyền
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
                   Chỉnh sửa cấp quyền
                </h2>
            </div>
            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">


                        <a href="{{route('allocation.list')}}" class="btn btn-default d-none d-sm-inline-block">

                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-narrow-left" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M5 12l14 0"></path>
                                <path d="M5 12l4 4"></path>
                                <path d="M5 12l4 -4"></path>
                            </svg>
                            Quay lại
                        </a>
                        <a href="{{url('/allocation')}}" class="btn btn-default d-sm-none btn-icon">
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
                <form id="frmAdd" class="card border-0 shadow-lg rounded-4 " action="" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Email user</label>
                            <select class="select2 form-control" name="user">
                                <option value=""><i>Chọn email người dùng</i></option>
                                @if(!empty($list_users))
                                @foreach($list_users as $user)
                                <option value="{{$user->id}}" {{$user_id == $user->id ? 'SELECTED' : ''}}>{{$user->email}}</option>
                                @endforeach
                                @endif
                            </select>
                            <span class="text-danger d-flex justify-content-start">
                                @error('user')
                                {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Người dùng này thuộc nhóm vai trò gì?</label>
                            <i>Tích để chọn một hoặc nhiều vai trò</i>
                            <div class="row mt-3">
                                @if(!empty($list_roles))
                                @foreach($list_roles as $role)
                                <div class="col-md-3">
                                    <label class="form-check">
                                        <input class="form-check-input" type="checkbox" name="role[]" @if(in_array($role->id, $roles_user)) checked @endif value="{{$role->id}}">
                                        <span class="form-check-label">{{$role->name}}</span>
                                      </label>
                                </div>
                                @endforeach
                                @endif
                            </div>
                            <span class="text-danger d-flex justify-content-start">
                                @error('role')
                                {{ $message }}
                                @enderror
                            </span>
                        </div>

                    </div>
                    <div class="card-footer text-right">
                        <button id="btnSubmitAdd" type="button" data-id="{{$user_id}}" class="btn btn-indigo">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal modal-blur fade" id="modalContainer" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div class="modal-content">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('page_js')
<script>
    $(document).ready(function() {

        $('#btnSubmitAdd').click(function(e) {
            e.preventDefault();

            // lấy dữ liệu từ form
            var formData = new FormData(this.form);
            // thực hiện Ajax
            $.ajax({

                url: "{{ route('allocation.edit', ['user_id' => ':id']) }}".replace(':id', this.dataset.id),
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    // xử lý response từ server
                    if (response.status === 200) {

                        // Hiển thị SweetAlert khi thành công
                        Swal.fire({
                                title: 'Thành công!',
                                text: response.message,
                                icon: 'success'
                            })
                            .then(function(response) {
                                if (response) {
                                    location.reload();
                                }
                            })
                    } else {
                        Swal.fire({
                            title: 'Lỗi!',
                            text: 'Cập nhật quyền cho người dùng không thành công',
                            icon: 'error'
                        });
                    }

                },
                error: function(xhr, status, error) {
                    // Xóa tất cả lỗi hiện tại trên giao diện
                    var listSpans = document.querySelectorAll(".spanError");
                    listSpans.forEach(function(item) {
                        item.innerHTML = '';
                    });

                    // Xử lý lỗi ajax nếu có
                    var errorResponse = JSON.parse(xhr.responseText);

                    // Lặp qua từng trường lỗi
                    Object.keys(errorResponse.errors).forEach(function(fieldName) {
                        // `fieldName` là tên trường có lỗi
                        var errorMessages = errorResponse.errors[fieldName];

                        // Lặp qua từng thông điệp lỗi trong mảng
                        errorMessages.forEach(function(errorMessage) {
                            var listSpans = document.querySelectorAll(
                                ".spanError");

                            listSpans.forEach(function(item) {
                                if (item.dataset.tag.trim() ==
                                    fieldName.trim()) {
                                    // Hiển thị lỗi chỉ ở trường tương ứng
                                    item.innerHTML = errorMessage;
                                }
                            });
                        });
                    });

                    Swal.fire({
                        title: 'Lỗi!',
                        text: 'Đã xảy ra lỗi khi thực hiện cập nhật cấp quyền',
                        icon: 'error'
                    });
                }

            });
        });
    });
</script>
<!-- --------------------------------------------- !-->
@endSection
