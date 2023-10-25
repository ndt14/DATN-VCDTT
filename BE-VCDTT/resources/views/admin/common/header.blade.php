<div class="d-none d-sm-none d-lg-block">
    <header class="navbar navbar-expand-md d-print-none">
        <div class="container-xl">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu"
                aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
                <!-- <span class="navbar-toggler-icon"></span> -->
            </button>
            <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
                <a href="/">
                </a>
            </h1>
            <div class="navbar-nav flex-row order-md-last">
                <div class="nav-item d-none d-md-flex me-3">
                    <div class="btn-list">

                    </div>
                </div>
                <div class="d-none d-md-flex">

                    <a href="?theme=dark" class="nav-link px-0 hide-theme-dark" data-bs-toggle="tooltip"
                        data-bs-placement="bottom" aria-label="Enable dark mode"
                        data-bs-original-title="Enable dark mode">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z">
                            </path>
                        </svg>
                    </a>
                    <a href="?theme=light" class="nav-link px-0 hide-theme-light" data-bs-toggle="tooltip"
                        data-bs-placement="bottom" aria-label="Enable light mode"
                        data-bs-original-title="Enable light mode">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                            <path
                                d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7">
                            </path>
                        </svg>
                    </a>


                    <div class="nav-item dropdown d-none d-md-flex me-3">
                        <a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1"
                            aria-label="Show notifications" aria-expanded="false" data-bs-auto-close="outside">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path
                                    d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6">
                                </path>
                                <path d="M9 17v1a3 3 0 0 0 6 0v-1"></path>
                            </svg>
                            @foreach ($user->unreadNotifications as $notification)
                                @if ($notification)
                                    <span class="badge bg-red"></span>
                                @endif
                            @endforeach
                        </a>
                        <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Thông báo</h3>
                                </div>
                                <div class="list-group list-group-flush list-group-hoverable">
                                    @foreach ($user->notifications as $notification)
                                        <div class="list-group-item">

                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    @if ($notification)
                                                        @if ($notification->read_at == null)
                                                            <span class="badge bg-danger" data-bs-toggle="tooltip"
                                                                data-bs-placement="top"
                                                                data-bs-title="Unactivated"></span>
                                                        @else
                                                            <span class="badge bg-success" data-bs-toggle="tooltip"
                                                                data-bs-placement="top"
                                                                data-bs-title="Activated"></span>
                                                        @endif
                                                </div>
                                                <div class="col text-truncate ">
                                                    <a onclick='@php $notification->markAsRead() @endphp'
                                                        href="javascript: viewDetail({{ $notification->data['purchase_history_id'] }});"
                                                        class="text-body d-block">Mã giao dịch:
                                                        {{ $notification->data['transaction_id'] }}</a>
                                                    <div class="d-block text-secondary mt-n1">
                                                        {{ string_truncate($notification->data['data'], 75) }}
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <a
                                                        href="{{ route('purchase_histories.mark_as_read') }}">Đánh
                                                        dấu là đã đọc</a>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="col text-truncate">Không có thông báo</span>
                                    @endif
                                    @endforeach


                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="nav-item dropdown">
                    <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                        aria-label="Open user menu" aria-expanded="false">
                        <span class="avatar avatar-sm"
                            style="background-image: url({{ asset('images/admin.jpg') }});"></span>
                        <div class="d-none d-xl-block ps-2">
                            <div>Nhóm VCDTT</div>
                            <div class="mt-1 small text-secondary">6 anh em</div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <a href="#" class="dropdown-item">Status</a>
                        <a href="./profile.html" class="dropdown-item">Profile</a>
                        <a href="#" class="dropdown-item">Feedback</a>
                        <div class="dropdown-divider"></div>
                        <a href="./settings.html" class="dropdown-item">Settings</a>
                        <a href="./sign-in.html" class="dropdown-item">Logout</a>
                    </div>
                </div>


            </div>
        </div>
    </header>
</div>
@section('page_js')
    <script type="text/javascript">
        let modalContainer;
        $(document).ready(function() {
            modalContainer = new bootstrap.Modal('#modalContainer', {
                keyboard: true,
                backdrop: 'static'
            });
        });

        let viewDetail = function(id) {
            axios.get(`/purchase-history/detail/${id}`)
                .then(function(response) {
                    $('#modalContainer div.modal-content').html(response.data.html);
                    modalContainer.show();
                })
                .catch(function(error) {
                    bs5Utils.Snack.show('danger', 'Error', delay = 5000, dismissible = true);
                })
                .finally(function() {});
        };

        let removeItem = function(id) {
            $.confirm({
                theme: theme,
                title: 'Confirm',
                content: 'Are you sure to remove?',
                columnClass: 'col-md-3 col-sm-6',
                buttons: {
                    removeButton: {
                        text: 'Yes',
                        btnClass: 'btn-danger',
                        action: function() {
                            axios.delete(`/api/purchase-history/${id}`).then(function(response) {
                                bs5Utils.Snack.show('success', 'Success', delay = 5000,
                                    dismissible = true);
                                setTimeout(() => {
                                    location.reload();
                                }, 2000);
                            });
                        }
                    },
                    close: function() {}
                }
            });
        };
    </script>
@endSection
