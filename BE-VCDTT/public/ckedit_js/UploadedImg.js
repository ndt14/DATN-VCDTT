$(document).ready(function() {
    var imageModal = new bootstrap.Modal(document.getElementById('imageModal'), {});

    function addImage(imageUrl, orderId) {
        var imageContainer = $('<div>').addClass('uploaded-image-container');
        var image = $('<img>').attr('src', imageUrl).addClass('uploaded-image');
        var deleteIcon = $('<i>').addClass('fas fa-trash delete-icon');

        imageContainer.append(image).append(deleteIcon);
        $('.uploaded-images[data-order-id="' + orderId + '"]').append(imageContainer);
    }

    $('.image-upload-label').click(function(e) {
        e.preventDefault();
        var orderId = $(this).attr('for').replace('upload-input-', '');
        $('#upload-input-' + orderId).trigger('click');
    });

    $(document).on('change', '.image-upload-input', function() {
        $('.uploaded-image-container').remove();
        var orderId = $(this).attr('id').replace('upload-input-', '');
        var files = $(this).prop('files');
        var existingImages = $('.uploaded-images[data-order-id="' + orderId + '"] .uploaded-image-container').length;

        if (existingImages >= 5 || files.length > 5) {
            Swal.fire({
                icon: 'error',
                title: 'Tối đa là 5 ảnh',
            });
            return;
        }

        var totalFiles = Math.min(files.length, 5 - existingImages);
        for (var i = 0; i < totalFiles; i++) {
            var reader = new FileReader();
            reader.onload = (function(orderId) {
                return function(e) {
                    addImage(e.target.result, orderId);
                };
            })(orderId);
            reader.readAsDataURL(files[i]);
        }
    });

    $(document).on('click', '.uploaded-image', function(e) {
        e.preventDefault();
        var clickedImage = $(this).clone();
        $('#clicked-image-container').empty().append(clickedImage);
        imageModal.show();
    });

    $(document).on('click', '.delete-icon', function(e) {
        e.stopPropagation();
        var imageContainer = $(this).closest('.uploaded-image-container');
        imageContainer.remove();
    });
});