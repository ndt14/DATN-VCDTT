function AddImage(input){
    const quantity_item = input.value;
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
}
