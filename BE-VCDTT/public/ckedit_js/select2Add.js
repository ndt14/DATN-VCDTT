$(document).ready(function() {
    $('#sender_phone, #receiver_phone ,#commodity, #shelf_floor, #inventory, #package_location').select2({
        width: '100%',
    });

    $('#provinces, #districts, #wards, #admin_number, #admin_name').select2({
        width: '100%',
    });

    $('#ward-list, #district-list, #province, #inventory_chain_name, #method').select2({
        width: '100%',
    });
});