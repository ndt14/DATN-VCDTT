function duplicate(class_select_2, id_item, id_list, id_modal = null) {
    if ($(`.${class_select_2}`).data('select2')) {
        $(`.${class_select_2}`).select2('destroy');
    }
    const divToClone = document.querySelector(`#${id_item}`);
    const clonedDiv = divToClone.cloneNode(true);
    $(clonedDiv).find('input[type="text"]').val('');
    $(clonedDiv).find(`.${class_select_2}`).val(null);
    const list_input = document.getElementById(id_list);
    list_input.insertBefore(clonedDiv, list_input.firstChild);
    if(id_modal !== null){
        $(`.${class_select_2}`).select2({
            dropdownParent: $('#'+id_modal)
        })
    }
    else{
        $(`.${class_select_2}`).select2()
    }
}

function duplicateMultiSelect(class_select_2_array, id_item, id_list, id_modal) {
    class_select_2_array.forEach(function(class_name) {
        if ($(`.${class_name}`).data('select2')) {
            $(`.${class_name}`).select2('destroy');
        }
    });
    const divToClone = document.querySelector(`#${id_item}`);
    const clonedDiv = divToClone.cloneNode(true);
    $(clonedDiv).find('input[type="text"]').val('');
    class_select_2_array.forEach(function(class_name) {
        $(clonedDiv).find(`.${class_name}`).val(null);
    });
    const list_input = document.getElementById(id_list);
    list_input.insertBefore(clonedDiv, list_input.firstChild);
    class_select_2_array.forEach(function(class_name) {
        $(`.${class_name}`).select2({
            dropdownParent: $(`#${id_modal}`)
        });
    });
}

function duplicateNoSelect(id_list, id_item) {
    const divToClone = document.querySelector(`#${id_item}`);
    const clonedDiv = divToClone.cloneNode(true);
    $(clonedDiv).find('input[type="text"]').val('');
    const list_input = document.getElementById(id_list);
    list_input.insertBefore(clonedDiv, list_input.firstChild);
}

const remove2 = (class_list, button) => {
    const divToRemove = button.parentElement.parentElement.parentElement;
    const divs = document.querySelectorAll('.' + class_list);
    if (divs.length > 1) {
        if(confirm('Bạn có chắc chắn muốn xoá ?')){
            divToRemove.remove();
        }
    } else {
        if (confirm('Không xoá được ! Bạn có muốn xoá dữ liệu trong các input ?')) {
            const inputs = divToRemove.querySelectorAll('input');
            inputs.forEach(input => {
                input.value = '';
            });
        }
    }
}

const remove = (class_list, button) => {
    const divToRemove = button.parentElement.parentElement;
    const divs = document.querySelectorAll('.' + class_list);
    if (divs.length > 1) {
        if (confirm('Bạn có chắc chắn muốn xoá ?')) {
            divToRemove.remove();
        }
    } else {
        if (confirm('Không xoá được ! Bạn có muốn xoá dữ liệu trong các input ?')) {
            const inputs = divToRemove.querySelectorAll('input');
            inputs.forEach(input => {
                input.value = '';
            });
        }
    }
}
