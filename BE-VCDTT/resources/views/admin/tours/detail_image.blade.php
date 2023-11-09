<div class="modal-header">
    <h1 class="modal-title fs-4" id="exampleModalFullscreenMdLabel">Thư viện ảnh</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="card border-0 shadow-lg rounded-4 ">
    <div class="row g-0">
        <div class="col d-flex flex-column">
            <div class="card-body card-body-scrollable card-body-scrollable-shadow" style="height: 40rem;">
                <div class="table table-responsive">
                    <table class="table card-table table-vcenter text-nowrap datatable">
                        <tbody>
                            @if ($data)
                                @foreach ($data as $item)
                                    <tr>
                                        <td>
                                            <img style="width: 150px; height: 90px; object-fit: cover;" src="{{ $item->url}}" alt="{{ $item->name}}">
                                        </td>
                                        <td class="text-end">
                                            <a href="javascript: void(0);" data-url="{{ $item->url}}" class="btn btn-icon btn-outline-indigo btn-copy-url" title="Sao chép đường dẫn nội tuyến">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-link" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M9 15l6 -6"></path>
                                                <path d="M11 6l.463 -.536a5 5 0 0 1 7.071 7.072l-.534 .464"></path>
                                                <path d="M13 18l-.397 .534a5.068 5.068 0 0 1 -7.127 0a4.972 4.972 0 0 1 0 -7.071l.524 -.463"></path>
                                                </svg>
                                            </a>
                                            <a class="btn btn-icon btn-outline-indigo" href="/image-download/{{ $item->id}}" title="Tải xuống">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-download" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path>
                                                <path d="M7 11l5 5l5 -5"></path>
                                                <path d="M12 4l0 12"></path>
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="9">
                                        <div>Không có dữ liệu</div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-transparent mt-auto">
                <div class="btn-list justify-content-end">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    Fancybox.bind('[data-fancybox]');
    $('.btn-copy-url').click(function () {
        let _self = $(this);
        let url = _self.attr('data-url');
        clipboard.writeText(url).then(function(){
            bs5Utils.Snack.show('success', 'File url is copied.', delay = 5000, dismissible = true);
        }, function(err){
            bs5Utils.Snack.show('danger', 'Can not copy file url.', delay = 5000, dismissible = true);
        });
    });
</script>