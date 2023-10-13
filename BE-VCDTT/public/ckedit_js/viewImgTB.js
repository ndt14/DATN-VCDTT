$(document).ready(function() {
    $('.image-link').click(function(e) {
      e.preventDefault();

      var imageSrc = $(this).attr('href');

      var modal = $('<div class="modal"><div class="modal-dialog modal-dialog-centered"><div class="modal-content"><div class="modal-header"><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div><div class="modal-body"><img src="' + imageSrc + '" alt="Image"></div></div></div></div>');

      // Add additional functionality to the modal
      var modalInstance = new bootstrap.Modal(modal[0]);
      modalInstance.show();

      modal.on('hidden.bs.modal', function() {
        $(this).remove();
      });
    });
  });