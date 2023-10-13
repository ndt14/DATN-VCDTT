function fillDaiDien(){
    const customer_id = $('.select_customer_new').val();
    if (customer_id == null) {
        alert('Chưa chọn khách hàng !');
        return
    }
    selectCustomer(customer_id)
        .then(res => {
            // $('#select_dai_dien').val(customer_id);
            $('input[name="customer_profile_code"]').val(res.customer_code);
            $('input[name="code_dai_dien"]').val(res.customer_code)
            $('input[name="customer"]').val(res.name)
            $('input[name="customer_email"]').val(res.email)
            $('input[name="customer_phone"]').val(res.phone)
            $('input[name="customer_address"]').val(res.address)
            $('input[name="customer_fax"]').val(res.fax)
            $('#dai_dien').modal("show")
            $('#doi_dai_dien').modal("hide");
            $('.country_dai_dien').select2()
                .val(res.country_id)
                .trigger('change');
            $('.select_dai_dien').select2()
                .val(customer_id)
                .trigger('change');
        })
}
function fillAuthor() {
    const customer_id = $('.select_author_new').val();
    if (customer_id == null) {
        alert('Chưa chọn khách hàng !');
        return
    }
    selectCustomer(customer_id)
        .then(res => {
            // Set values for the first input fields
            $('input[name="author"]').val(res.name);
            $('input[name="author_email"]').val(res.email);
            $('input[name="author_phone"]').val(res.phone);
            $('input[name="author_fax"]').val(res.fax);
            $('input[name="author_address"]').val(res.address);

            // Show the modal
            $('#author').modal("show");
            $('#doi_tac_gia').modal("hide");

            // Set the selected value for the first country select element
            $('.author_list_country').val(res.country_id).trigger('change');
        });
}
function fillChuDon() {
    const customer_id = $('.select_chu_don').val();
    if (customer_id == null) {
        alert('Chưa chọn khách hàng !');
        return
    }
    selectCustomer(customer_id)
        .then(res => {
            // Set values for the first input fields
            $('input[name="name_certificate_holder"]').val(res.name);
            $('input[name="email_certificate_holder"]').val(res.email);
            $('input[name="phone_certificate_holder"]').val(res.phone);
            $('input[name="address_certificate_holder"]').val(res.address);

            // Show the modal
            $('#chudonchubang').modal("show");
            $('#doichudon').modal("hide");

            // Set the selected value for the first country select element
            $('.country_certificate_holder').val(res.country_id).trigger('change');
        });
}
function fillChuyenNhuongDonBang(customer_id) {
    $("#name_form_transfer_invent").addClass('d-none');
    if (customer_id == null) {
        alert('Chưa chọn chủ mới!');
        return;
    }
    if (customer_id !== '') {
        selectCustomer(customer_id)
            .then(res => {
                $('input[name="transfer_address"]').val(res.address);
                $('#name_form_transfer').val(res.name);
                $('.country_cndb').val(res.country_id).trigger('change');
            });
    }
}
function fillLixang(customer_id) {
    if (customer_id == null) {
        alert('Chưa chọn bên nhận Lixang!');
        return;
    }
    if (customer_id !== '') {
        selectCustomer(customer_id)
            .then(res => {
                $('input[name="lixang_address"]').val(res.address);
            });
    }
}
function fillKhachHang(customer_id) {
    if (customer_id == null) {
        alert('Chưa chọn khách hàng!');
        return;
    }
    if (customer_id !== '') {
        selectCustomer(customer_id)
            .then(res => {
                $('#select_dai_dien').addClass('d-none');
                $('input[name="customer_address"]').val(res.address);
                $('input[name="customer_email"]').val(res.email);
                $('input[name="customer_phone"]').val(res.phone);
                $('input[name="customer_fax"]').val(res.fax);
                $('.country_dai_dien').val(res.country_id).trigger('change');
                $('.nationality_dai_dien').val(res.nationality).trigger('change');
                $('.customer_profile_code').val(res.customer_code).trigger('change');
            });
    }
}
function fillChuDonChuBang(select, customer_id) {
    if (customer_id == null) {
        alert('Chưa chọn chủ đơn chủ bằng mới!');
        return;
    }
    if (customer_id !== '') {
        const itemContainer = $(select).closest('.item-cdcb');
        selectCustomer(customer_id)
            .then(res => {
                $(itemContainer).find('input[name="address_certificate_holder"]').val(res.address);
                $(itemContainer).find('input[name="email_certificate_holder"]').val(res.email);
                $(itemContainer).find('input[name="phone_certificate_holder"]').val(res.phone);
                $(itemContainer).find('input[name="fax_certificate_holder"]').val(res.fax);
                $(itemContainer).find('.country_certificate_holder').val(res.country_id).trigger('change');
                $(itemContainer).find('.nationality_certificate_holder').val(res.nationality).trigger('change');

            });
    }
}
function fillAuthor2(select, customer_id) {
    if (customer_id == null) {
        alert('Chưa chọn khách hàng!');
        return;
    }
    if (customer_id !== '') {
        const itemContainer = $(select).closest('.item-author');
        selectCustomer(customer_id)
            .then(res => {
                $(itemContainer).find('input[name="author_address"]').val(res.address);
                $(itemContainer).find('input[name="author_email"]').val(res.email);
                $(itemContainer).find('input[name="author_phone"]').val(res.phone);
                $(itemContainer).find('input[name="author_fax"]').val(res.fax);
                $(itemContainer).find('.author_list_country').val(res.country_id).trigger('change');
                $(itemContainer).find('.author_list_nationality').val(res.nationality).trigger('change');
            });
    }
}
function clearContentInput() {
    $('#acceptance_date_radio').addClass('d-none');
    var inputElements = document.getElementsByClassName("clearInput");
    for(var i = 0;i < inputElements.length;i++){
        inputElements[i].value = "";
    }
}
function clearContentInputCapBang() {
    var inputElements = document.getElementsByClassName("clearInputCapBang");
    for(var i = 0;i < inputElements.length;i++){
        inputElements[i].value = "";
    }
}
function clearContentInputNopDon(){
    var inputElements = document.getElementsByClassName("clearInputNopDon");
    for(var i = 0;i < inputElements.length;i++){
        inputElements[i].value = "";
    }
    $('.list-images').empty();
    $('#add_images').attr('disabled', true);


}
function clearForm(){
    $("#formCreateInvent")[0].reset();
}
function updateClock() {
    const now = new Date();
    let hours = now.getHours();
    const minutes = now.getMinutes().toString().padStart(2, '0');
    const seconds = now.getSeconds().toString().padStart(2, '0');
    let amPm = 'AM'; // Mặc định là AM
    if (hours >= 12) {
        amPm = 'PM';
        if (hours > 12) {
            hours -= 12; // Đổi sang định dạng 12 giờ
        }
    }
    const hoursStr = hours.toString().padStart(2, '0');
    $('#clock-invent').val(`${hoursStr}:${minutes}:${seconds} ${amPm}`);
}
$(document).ready(function () {
    setInterval(updateClock, 1000);
    updateClock();
})
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
    $('.upload__inputfile_'+(i)).each(function () {
        $(this).on('change', function (e) {
            imgWrap = $('.images-'+(i));
            imgAll = $('.list-images-item-'+(i));
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
    renderModalShowAllImage(i)
}
function duplicateAddImage(){
    const currentDivCount = $('.plan_img').length + 1;
    $('input[name="image_lenght"]').val(currentDivCount)
    renderModalShowAllImage(currentDivCount);
    $('.list-images').append(`
    <div class="plan_img" id="phuong_an_image-${currentDivCount}">
        <div class="titleImg mb-3"><p>Phương án ${currentDivCount}:</p></div>
        <div style="display: grid; grid-template-columns: 85% 15%;">
            <div class="images-${currentDivCount} row"></div>
            <div class="allAddAndAll" style="height: 68px; line-height: normal; display: inline-grid; grid-template-columns: 45% 55%;">
                <div class="d-flex justify-content-center align-items-center">
                    <label class="upload__btn-${currentDivCount} mt-1">
                        <div class="iconCenter">
                            <div class="buttomAddImgNew"><div class="iconAdd mw"><i class="fa-solid fa-link"></i></div></div>
                            <p>Thêm ảnh</p>
                        </div>
                        <input type="file" name="image_invents_${currentDivCount}[]" multiple id="input_upload_img" class="upload__inputfile_${currentDivCount}">
                    </label>
                </div>
                <div class="d-flex justify-content-center align-items-center" data-bs-toggle="modal" data-bs-target="#show_anh_${currentDivCount}">
                    <div class="buttomFullImg"><p>Tất cả ảnh</p></div>
                </div>
            </div>
        </div>
    </div>
    `);
    addImage(currentDivCount)
}
function cancelValidate(input) {
    var errorId = input.name;
    $("#" + errorId).addClass('d-none');
}
function fillUpdateChuDonChuBang(select, customer_id) {
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
                $(itemContainer).find('.country_certificate_holder').val(res.country_id).trigger('change');
                $(itemContainer).find('.nationality_certificate_holder').val(res.nationality).trigger('change');
            });
    }
}
function fillUpdateChuyenNhuongDonBang(select, customer_id) {
    if (customer_id == null) {
        alert('Chưa chọn chủ mới!');
        return;
    }
    if (customer_id !== '') {
        const itemContainer = $(select).closest('.item-cndb');
        selectCustomer(customer_id)
            .then(res => {
                $(itemContainer).find('input[name="transfer_address[]"]').val(res.address);

                const transferCountrySelect = $(itemContainer).find('select[name="transfer_country[]"]');
                transferCountrySelect.val(res.country_id).trigger('change');
                // $(itemContainer).find('.country_cndb').val(res.country_id).trigger('change');
            });
    }
}
function fillUpdateAuthor(select, customer_id) {
    if (customer_id == null) {
        alert('Chưa chọn chủ đơn chủ bằng mới!');
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
                $(itemContainer).find('.author_list_country').val(res.country_id).trigger('change');
                $(itemContainer).find('.author_list_nationality').val(res.nationality).trigger('change');

            });
    }
}
function IndustrialDesignUpdateChuyenNhuongDonBang(select, customer_id) {
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

                const transferCountrySelect = $(itemContainer).find('select[name="transfer_country[]"]');
                transferCountrySelect.val(res.country_id).trigger('change');

                const transferNationalSelect = $(itemContainer).find('select[name="transfer_nationality[]"]');
                transferNationalSelect.val(res.nationality).trigger('change');



                // $(itemContainer).find('.country_cndb').val(res.country_id).trigger('change');
            });
    }
}
