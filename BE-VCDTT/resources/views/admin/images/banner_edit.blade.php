<div class="modal-header">
    <h5 class="modal-title" id="imageModalLabel">Xem Banner</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <div id="imageCarousel" class="carousel slide mb-2" data-bs-ride="carousel">
        <div class="carousel-inner">
            @if (is_array($data) && count($data) > 0)
                @foreach ($data as $key => $image)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                        <img class="d-block mx-auto object-cover img-fluid" alt=""
                            style="filter: brightness(80%);max-height: 15rem;" src="{{ $image->url }}"
                            alt="Slide {{ $key }}">
                    </div>
                @endforeach
            @else
                <div class="carousel-item active">
                    <img src="" class="d-block w-100" alt="{{ 'Rỗng' }}">
                </div>
            @endif
        </div>
        @if (is_array($data) && count($data) > 0)
        <button class="carousel-control-prev bg-secondary" type="button" data-bs-target="#imageCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next bg-secondary" type="button" data-bs-target="#imageCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    @endif
    </div>
    <div class="card border-0 shadow-lg rounded-4">
        <div class="row g-0">
            <div class="col d-flex flex-column">
                <div class="card-body card-body-scrollable card-body-scrollable-shadow" style="height: 40rem;">
                    <div class="table table-responsive">
                        <table class="table card-table table-vcenter text-nowrap datatable"> Danh sách ảnh
                            @if ($dataImages)
                                @foreach ($dataImages as $item)
                                    <tr>
                                        <td>
                                            <img style="width: 150px; height: 90px; object-fit: cover;"
                                                src="{{ $item->url }}" alt="{{ $item->name }}">
                                        </td>
                                        <td class="text-end">
                                            @if ($item->banner_id != 1)
                                                <a href="javascript: void(0);"
                                                    onclick="bannerEdit('{{ $item->id }}')"
                                                    class="btn btn-icon btn-outline-green btn-checking"
                                                    title="Dùng làm banner">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-check" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="green" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M5 12l5 5l10 -10" />
                                                    </svg>
                                                </a>
                                            @else
                                                <a href="javascript: void(0);"
                                                    onclick="bannerEdit('{{ $item->id }}')"
                                                    class="btn btn-icon btn-outline-red btn-checking"
                                                    title="Không dùng nữa">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-x" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="red" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M18 6l-12 12" />
                                                        <path d="M6 6l12 12" />
                                                    </svg>
                                                </a>
                                            @endif
                                            <a href="javascript: void(0);" data-url="{{ $item->url }}"
                                                class="btn btn-icon btn-outline-indigo btn-copy-url"
                                                title="Sao chép đường dẫn nội tuyến">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-link" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M9 15l6 -6"></path>
                                                    <path d="M11 6l.463 -.536a5 5 0 0 1 7.071 7.072l-.534 .464"></path>
                                                    <path
                                                        d="M13 18l-.397 .534a5.068 5.068 0 0 1 -7.127 0a4.972 4.972 0 0 1 0 -7.071l.524 -.463">
                                                    </path>
                                                </svg>
                                            </a>
                                            <a class="btn btn-icon btn-outline-indigo"
                                                href="/image-download/{{ $item->id }}" title="Tải xuống">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-download" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
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
            </div>
        </div>
    </div>
</div>
