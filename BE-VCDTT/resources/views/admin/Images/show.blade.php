<div class="modal-header">
    <h5 class="modal-title" id="imageModalLabel">Xem ảnh
    </h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <img id="modalImage" src="{{ $data ?? '' }}" width="100%" alt="{{ $data ?? 'Rỗng' }}">
</div>
