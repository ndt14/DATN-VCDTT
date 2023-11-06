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
                        <form id="frmEdit" class="card border-0 shadow-lg rounded-4 " action="{{ route('tour.edit', ['id' => $tour->id])}}" method="POST">
                            <div class="card-header">
                                <h2 class="card-title">
                                    Chỉnh sửa {{ $tour->name  }}
                                </h2>
                            </div>
                            @csrf

                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">Tên tour</label>
                                    <input type="text" name="name" class="form-control"
                                        placeholder="Nhập tên cho tour" value="{{ $tour->name }}">
                                    <span class="text-danger d-flex justify-content-start">
                                        @error('name')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-6">
                                        <label class="form-label">Ảnh đại diện</label>
                                        <input type="text" name="main_img" class="form-control"
                                            placeholder="Link ảnh đại diện" value="{{ $tour->main_img  }}">
                                        <span class="text-danger d-flex justify-content-start">
                                            @error('main_img')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="mb-3 col-6">
                                        <label class="form-label">Khoảng thời gian</label>
                                        <input type="text" name="duration" class="form-control"
                                            placeholder="Nhập khoảng thời gian diễn ra tour"
                                            value="{{ $tour->duration  }}">
                                        <span class="text-danger d-flex justify-content-start">
                                            @error('duration')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-6">
                                        <div class="form-label">Giá người lớn</div>
                                        <input name="adult_price" type="text" placeholder="Nhập giá người lớn"
                                            class="form-control" value="{{ $tour->adult_price  }}">
                                        <span class="text-danger d-flex justify-content-start">
                                            @error('adult_price')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="mb-3 col-6">
                                        <div class="form-label">Giá trẻ nhỏ</div>
                                        <input name="child_price" type="text" placeholder="Nhập giá cho trẻ nhỏ"
                                            class="form-control" value="{{ $tour->child_price  }}">
                                        <span class="text-danger d-flex justify-content-start">
                                            @error('child_price')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-6">
                                        <div class="form-label">Điểm bắt đầu</div>
                                        <input name="start_destination" type="text"
                                            placeholder="Nhập điểm khởi hành tour" class="form-control"
                                            value="{{ $tour->start_destination  }}">
                                        <span class="text-danger d-flex justify-content-start">
                                            @error('start_destination')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="mb-3 col-6">
                                        <div class="form-label">Điểm kết thúc</div>
                                        <input name="end_destination" type="text"
                                            placeholder="Nhập điểm kết thúc tour" class="form-control"
                                            value="{{ $tour->end_destination  }}">
                                        <span class="text-danger d-flex justify-content-start">
                                            @error('end_destination')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="mb-3 col-6">
                                        <div class="form-label">Vị trí tour</div>
                                        <input name="location" type="text" class="form-control"
                                            placeholder="Nhập vị trí của tour" value="{{ $tour->location  }}">
                                        <span class="text-danger d-flex justify-content-start">
                                            @error('location')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="mb-3 col-6">
                                        <div class="form-label">Vị trí chính xác tour</div>
                                        <input name="exact_location" type="text" class="form-control"
                                            placeholder="Nhập vị trí chính xác của tour"
                                            value="{{ $tour->exact_location  }}">
                                        <span class="text-danger d-flex justify-content-start">
                                            @error('exact_location')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="mb-3 col-6">
                                        <div class="form-label">Lịch trình tour</div>
                                        <input name="pathway" type="text" class="form-control"
                                            placeholder="Nhập lịch trình của tour" value="{{ $tour->pathway  }}">
                                        <span class="text-danger d-flex justify-content-start">
                                            @error('exact_location')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="mb-3 col-6">
                                        <label class="form-label">Choose Category</label>
                                        <select type="text" class="form-select" name="categories_data[]" placeholder="Select category" id="select-category" value="" multiple></select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-4">
                                        <div class="form-label">Phần trăm giảm giá</div>
                                        <input name="sale_percentage" type="text" class="form-control"
                                            placeholder="Nhập phần trăm giảm giá của tour"
                                            value="{{ $tour->sale_percentage  }}">
                                        <span class="text-danger d-flex justify-content-start">
                                            @error('sale_percentage')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>

                                    <div class="mb-3 col-4">
                                        <div class="form-label">Số lượng hành khách</div>
                                        <input name="tourist_count" type="text" class="form-control"
                                            placeholder="Nhập tỉ lệ bán hàng của tour"
                                            value="{{ $tour->tourist_count  }}">
                                        <span class="text-danger d-flex justify-content-start">
                                            @error('tourist_count')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-label">Nội dung mô tả</div>
                                    <textarea id="editor" rows="6" class="form-control text-editor ckeditor" name="details"
                                        placeholder="Nhập nội dung mô tả">{{ $tour->details  }}</textarea>
                                    <span class="text-danger d-flex justify-content-start">
                                        @error('details')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="mb-3">
                                    <div class="form-label">Trạng thái</div>
                                    <div class="custom-controls-stacked">
                                        <label class="custom-control custom-radio custom-control-inline me-2">
                                            <input type="radio" class="custom-control-input"
                                                @if ($tour->status  == '1') checked @endif name="status"
                                                checked="" value="1">
                                            <span class="custom-control-label">Kích hoạt</span>
                                        </label>
                                        <label class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" class="custom-control-input"
                                                @if ($tour->status  == '0') checked @endif name="status"
                                                value="0">
                                            <span class="custom-control-label">Vô hiệu hóa</span>
                                        </label>

                                        <span class="text-danger d-flex justify-content-start">
                                            @error('status')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <button id="btnSubmitEdit" type="submit" class="btn btn-indigo">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- <div class="row row-deck row-cards">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">Files upload</h3>
                                <form class="dropzone dz-clickable" id="dropzone-files" action="{{ route('file.store') }}" autocomplete="off" novalidate>
                                    @csrf
                                    <div class="fallback">
                                        <input name="files[]" type="file"/>
                                    </div>
                                    <div class="dz-message">
                                        <h3 class="dropzone-msg-title">Your text here</h3>
                                        <span class="dropzone-msg-desc">Select or Drop files here to upload</span>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    @endsection
@section('page_css')
<link href="{{ asset('admin/assets/libs/dropzone/dist/dropzone.css')}}" rel="stylesheet"/>
@endsection
@section('page_js')
<script src="{{ asset('admin/assets/libs/dropzone/dist/dropzone-min.js')}}" defer></script>
<script src="{{ asset('admin/assets/libs/tom-select/dist/js/tom-select.base.min.js')}}" defer></script>
<script type="text/javascript">

$(document).ready(function() {
        var categories_data = <?php echo htmlspecialchars(json_encode($cateIds)) ?>;
        if ($('#frmEdit').length) {
//             $('#frmEdit').submit(function() {
//                 var options = {
//                     beforeSubmit: function(formData, jqForm, options) {
//                         $('#btnSubmitEdit').addClass('btn-loading');
//                         $('#btnSubmitEdit').addClass("disabled");
//                     },
//                     success: function(response, statusText, xhr, $form) {
//                         $('#btnSubmitEdit').removeClass('btn-loading');
//                         if(response.status == 404){
//                             $('#btnSubmitEdit').removeClass("disabled");
//                             bs5Utils.Snack.show('danger', response.message, delay = 5000, dismissible = true);
//                         }
//                         if(response.status == 200){
//                             $('#btnSubmitEdit').removeClass("disabled");
//                             bs5Utils.Snack.show('success', response.message, delay = 6000, dismissible = true);
//                         }
//                     },
//                     error: function() {
//                         $('#btnSubmitEdit').removeClass('btn-loading');
//                         $('#btnSubmitEdit').removeClass("disabled");
//                         bs5Utils.Snack.show('danger', 'Error, please check your input', delay = 5000, dismissible = true);
//                     },
//                     dataType: 'json',
//                     clearForm: false,
//                     resetForm: false
//                 };
//                 $(this).ajaxSubmit(options);
//                 return false;
//             });

            $.ajax({
            url: "/api/category",
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                //gender category
                var selectCatogories = $('#select-category');
                $.each(response.data.categoriesParent, function(index, category) {
                    var id = category.id
                    id = +id
                    if (categories_data.includes(id)) {
                        var option = $('<option selected></option>').val(id).text(category.name);
                    } else {
                        var option = $('<option></option>').val(id).text(category.name);
                    }
                    selectCatogories.append(option);
                    $.each(category.child, function(index, childCategory) {
                        let chlidId = childCategory.id;
                        chlidId = +chlidId;
                        let option = $('<option></option>').val(chlidId).text(category.name + '-> '+ childCategory.name);
                        selectCatogories.append(option);
                    });
                });

                //add to select by tom-select lib
                var el;
                window.TomSelect && (new TomSelect(el = document.getElementById('select-category'), {
                    copyClassesToDropdown: false,
                    dropdownParent: 'body',
                    controlInput: '<input>',
                    render: {
                        item: function(data, escape) {
                            if (data.customProperties) {
                                return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
                            }
                            return '<div>' + escape(data.text) + '</div>';
                        },
                        option: function(data, escape) {
                            if (data.customProperties) {
                                return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
                            }
                            return '<div>' + escape(data.text) + '</div>';
                        },
                    },
                }));
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }
    $('#select-category').change(function() {
        catogories_data = $(this).val();
        console.log(catogories_data)
    });
});
//     document.addEventListener("DOMContentLoaded", function() {
//         var imgArray = [];
//         new Dropzone("#dropzone-files", {
//             paramName: "files", // The name that will be used to transfer the file
//             maxFilesize: 100, // MB
//             uploadMultiple: true,
//             accept: function(file, done) {
//                 done();
//             },
//             success: function(file, response) {
//                 if (response.status === 200) {
//                     imgArray.push(response.files); // Thêm giá trị files vào mảng
//                 }
//                 document.getElementById('imgArray').value = JSON.stringify(imgArray);
//                 console.log(document.getElementById('imgArray').value);
//             },
//             error: function(file, response) {
//                 console.error(response.message);
//             }
//         });
//     })
</script>
@endSection
