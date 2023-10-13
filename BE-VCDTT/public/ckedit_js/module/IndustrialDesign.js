class IndustrialDesign {
    static fillChuDon(select, customer_id){
        if (customer_id == null) {
            alert('Chưa chọn chủ đơn chủ bằng mới!');
            return;
        }
        if (customer_id !== '') {
            const itemContainer = $(select).closest('.item-cdcb');
            selectCustomer(customer_id)
                .then(res => {
                    $(itemContainer).find('input[name="address_certificate_holder[]"]').val(res.address);
                    $(itemContainer).find('input[name="email_certificate_holder[]"]').val(res.email);
                    $(itemContainer).find('input[name="phone_certificate_holder[]"]').val(res.phone);
                    $(itemContainer).find('input[name="fax_certificate_holder[]"]').val(res.fax);
                    $(itemContainer).find('.country_certificate_holder').val(res.country_code).trigger('change');
                    $(itemContainer).find('.nationality_certificate_holder').val(res.nationality_code).trigger('change');
                });
        }
    }
    static fillDaiDien(customer_id) {
        if (customer_id == null) {
            alert('Chưa chọn khách hàng!');
            return;
        }
        if (customer_id !== '') {
            selectCustomer(customer_id)
                .then(res => {
                    $('#select_dd').addClass('d-none');
                    $('input[name="customer_profile_code"]').val(res.customer_code);
                    $('input[name="customer_address"]').val(res.address);
                    $('input[name="customer_email"]').val(res.email);
                    $('input[name="customer_phone"]').val(res.phone);
                    $('input[name="customer_fax"]').val(res.fax);
                    $('.country_dai_dien').val(res.country_code).trigger('change');
                    $('.nationality_dai_dien').val(res.nationality_code).trigger('change');
                });
        }
    }
    static fillTacGia(select, customer_id) {
        if (customer_id == null) {
            alert('Chưa chọn khách hàng!');
            return;
        }
        if (customer_id !== '') {
            const itemContainer = $(select).closest('.item-author');
            selectCustomer(customer_id)
                .then(res => {
                    $(itemContainer).find('input[name="author_address[]"]').val(res.address);
                    $(itemContainer).find('input[name="author_email[]"]').val(res.email);
                    $(itemContainer).find('input[name="author_phone[]"]').val(res.phone);
                    $(itemContainer).find('input[name="author_fax[]"]').val(res.fax);
                    $(itemContainer).find('.author_list_country').val(res.country_code).trigger('change');
                    $(itemContainer).find('.author_list_nationality').val(res.nationality_code).trigger('change');
                });
        }
    }
    static doi_chu_don(){
        const customer_id = $('.select_chu_don_moi').val();

        // Kiểm tra nếu không có khách hàng nào được chọn
        if (!customer_id) {
            alert('Chưa chọn khách hàng!');
            return;
        }

        // Gọi hàm selectCustomer(customer_id) để lấy thông tin khách hàng
        selectCustomer(customer_id)
            .then(res => {
                // Thiết lập giá trị cho các trường input đầu tiên
                $('input[name="email_certificate_holder[]"]:first').val(res.email);
                $('input[name="phone_certificate_holder[]"]:first').val(res.phone);
                $('input[name="address_certificate_holder[]"]:first').val(res.address);

                // Hiển thị modal "chudonchubang" và ẩn modal "doichudon"
                $('#chudonchubang').modal("show");
                $('#doichudon').modal("hide");

                // Đặt giá trị đã chọn cho phần tử select đầu tiên có class "country_certificate_holder"
                $('.country_certificate_holder:first').val(res.country_code).trigger('change');
                $('.nationality_certificate_holder:first').val(res.country_code).trigger('change');
                $('.name_certificate_holder:first').val(res.nationality_code).trigger('change');
            })
            .catch(error => {
                console.error('Lỗi khi lấy thông tin khách hàng:', error);
                alert('Có lỗi xảy ra khi lấy thông tin khách hàng!');
            });
    }
    static doi_tac_gia(){
        const customer_id = $('#select_author_new').val();
        if (customer_id == null) {
            alert('Chưa chọn khách hàng!');
            return;
        }
        if (customer_id !== '') {
            const itemContainer = $('.select-author').closest('.item-author');
            selectCustomer(customer_id)
                .then(res => {
                    $(itemContainer).find('input[name="author_address[]"]:first').val(res.address);
                    $(itemContainer).find('input[name="author_email[]"]:first').val(res.email);
                    $(itemContainer).find('input[name="author_phone[]"]:first').val(res.phone);
                    $(itemContainer).find('input[name="author_fax[]"]:first').val(res.fax);
                    $(itemContainer).find('.author_list_country').val(res.country_code).trigger('change');
                    $(itemContainer).find('.author_list_nationality').val(res.nationality_code).trigger('change');
                    $(itemContainer).find('.author').val(customer_id).trigger('change');

                    $('#author').modal("show")
                    $('#doi_tac_gia').modal("hide");
                });
        }
    }
    static doi_dai_dien(){
        const customer_id = $('.select_customer_new').val();
        if (customer_id == null) {
            alert('Chưa chọn khách hàng !');
            return
        }
        selectCustomer(customer_id)
            .then(res => {
                $('input[name="customer_profile_code"]').val(res.customer_code);
                $('input[name="customer_address"]').val(res.address);
                $('input[name="customer_email"]').val(res.email);
                $('input[name="customer_phone"]').val(res.phone);
                $('input[name="customer_fax"]').val(res.fax);
                $('.select_dd').select2().val(customer_id).trigger('change');
                $('.country_dai_dien').val(res.country_code).trigger('change');
                $('.nationality_dai_dien').val(res.nationality_code).trigger('change');
                $('#dai_dien').modal("show")
                $('#doi_dai_dien').modal("hide");
            })
    }
    static fillChuyenNhuongDonBang(select, customer_id) {
        if (customer_id == null) {
            alert('Chưa chọn chủ mới!');
            return;
        }
        if (customer_id !== '') {
            const itemContainer = $(select).closest('.item-cndb');
            selectCustomer(customer_id)
                .then(res => {
                    $(itemContainer).find('input[name="transfer_address[]"]').val(res.address);
                    $(itemContainer).find('input[name="transfer_email[]"]').val(res.email);
                    $(itemContainer).find('input[name="transfer_phone[]"]').val(res.phone);
                    $(itemContainer).find('input[name="transfer_fax[]"]').val(res.fax);
                    $(itemContainer).find('.transfer_country').val(res.country_code).trigger('change');
                    $(itemContainer).find('.transfer_nationality').val(res.nationality_code).trigger('change');
                });
        }
    }
    static fillLixang(select, customer_id) {
        if (customer_id == null) {
            alert('Chưa chọn bên nhận lixang!');
            return;
        }
        if (customer_id !== '') {
            const itemContainer = $(select).closest('.item-lixang');
            selectCustomer(customer_id)
                .then(res => {
                    $(itemContainer).find('input[name="lixang_address[]"]').val(res.address);
                });
        }
    }
}


function renderModalShowAllImage(number) {
    $('#list-modal-img').empty();
    for (let i = 0; i < number; i++) {
        $('#list-modal-img').append(`
            <div class="modal fade" id="show_anh_${i + 1}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="titlePriority"><p>Tất cả ảnh phương án ${i + 1}</p></div>
                            <button type="button" data-bs-toggle="modal" data-bs-target="#them_anh" style="color: rgba(27, 175, 31, 1)">Quay lại</button>
                        </div>
                        <div class="modal-body text-left">
                            <div class="row list-images-item-${i + 1}"></div>
                        </div>
                        <div class="modal-footer d-flex justify-content-between"></div>
                    </div>
                </div>
            </div>
        `);
    }
}
function addImage(i){
    let imgWrap = "";
    let imgAll = "";
    const imgArray = [];
    $('.upload__inputfile_'+(i+1)).each(function () {
        $(this).on('change', function (e) {
            imgWrap = $('.images-'+(i+1));
            imgAll = $('.list-images-item-'+(i+1));
            const files = e.target.files;
            const filesArr = Array.prototype.slice.call(files);
            // Số lượng ảnh tối đa
            const maxImages = 6;
            const currentImageCount = imgWrap.find('.upload__img-box').length;
            const remainingSlots = maxImages - currentImageCount;
            filesArr.slice(0, remainingSlots).forEach(function (f, index) {
                if (!f.type.match('image.*')) {
                    return;
                }
                const reader = new FileReader();
                reader.onload = function (e) {
                    const html =
                        `<div class='upload__img-box col-2'>
                            <div style='background-image: url(${e.target.result})' data-number='${$(".upload__img-close").length}' data-file='${f.name}' class='img-bg'>
                                <div class='upload__img-close'>
                                </div>
                            </div>
                        </div>`;
                    imgWrap.append(html);
                }
                reader.readAsDataURL(f);
            });
            filesArr.forEach(function (f, index) {
                if (!f.type.match('image.*')) {
                    return;
                }
                const reader = new FileReader();
                reader.onload = function (e) {
                    const html =
                        `<div class='upload__img-box col-2'>
                            <div style='background-image: url(${e.target.result})' data-number='${$(".upload__img-close").length}' data-file='${f.name}' class='img-bg'>
                                <div class='upload__img-close'>
                                </div>
                            </div>
                        </div>`;
                    imgAll.append(html);
                }
                reader.readAsDataURL(f);
            });
        });
    });
    $('body').on('click', ".upload__img-close", function (e) {
        const file = $(this).parent().data("file");
        for (let i = 0; i < imgArray.length; i++) {
            if (imgArray[i].name === file) {
                imgArray.splice(i, 1);
                break;
            }
        }
        $(this).parent().parent().remove();
    });
    renderModalShowAllImage(i+1)
}
function duplicateAddImage(input){
    const quantity_item = input.value;
    renderModalShowAllImage(quantity_item);
    const currentDivCount = $('.plan_img').length;
    if (quantity_item > currentDivCount) {
        for (let i = currentDivCount; i < quantity_item; i++) {
            $('.list-images').append(`
                <div class="plan_img" id="phuong_an_image-${i+1}">
                    <div class="titleImg mb-3"><p>Phương án ${i+1}:</p></div>
                    <div style="display: grid; grid-template-columns: 85% 15%;">
                        <div class="images-${i+1} row"></div>
                        <div class="allAddAndAll" style="height: 68px; line-height: normal; display: inline-grid; grid-template-columns: 45% 55%;">
                            <div class="d-flex justify-content-center align-items-center">
                                <label class="upload__btn-${i+1} mt-1">
                                    <div class="iconCenter">
                                        <div class="buttomAddImgNew"><div class="iconAdd mw"><i class="fa-solid fa-link"></i></div></div>
                                        <p>Thêm ảnh</p>
                                    </div>
                                    <input type="file" name="image_invents_${i+1}[]" multiple id="input_upload_img" class="upload__inputfile_${i+1}">
                                </label>
                            </div>
                            <div class="d-flex justify-content-center align-items-center" data-bs-toggle="modal" data-bs-target="#show_anh_${i+1}">
                                <div class="buttomFullImg"><p>Tất cả ảnh</p></div>
                            </div>
                        </div>
                    </div>
                </div>
            `);
            addImage(i)
        }
    } else if (quantity_item < currentDivCount) {
        for (let i = currentDivCount; i > quantity_item; i--) {
            $(`#phuong_an_image-${i}`).remove();
        }
    }
    $(`#${input.name}`).addClass('d-none');
}
