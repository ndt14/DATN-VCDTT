<div class="d-none d-sm-none d-lg-block  sticky-top shadow-lg border-0">
    <header class="navbar navbar-expand-md d-print-none sticky-top shadow-lg border-0" style="z-index: 99;">
        <div class="container-xl">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu"
                aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
                <!-- <span class="navbar-toggler-icon"></span> -->
            </button>
            <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3 ms-5">
                <a href="/" class="d-flex align-items-center text-indigo text-decoration-none">
                    <span class="fs-1 text-indigo me-1">VCDTT</span><span class="fw-light fst-italic">quản trị</span>
                </a>
            </h1>
            <div class="navbar-nav flex-row order-md-last">
                <div class="nav-item d-none d-md-flex me-3">
                    <div class="btn-list">

                    </div>
                </div>
                <div class="d-none d-md-flex">

                    <a href="?theme=dark" class="nav-link px-0 hide-theme-dark text-purple" data-bs-toggle="tooltip"
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
                    <a href="?theme=light" class="nav-link px-0 hide-theme-light text-yellow" data-bs-toggle="tooltip"
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
                            id="notificationPing" aria-label="Show notifications" aria-expanded="false"
                            data-bs-auto-close="outside">
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
                                    <span class="badge bg-red" id="notificationDot"></span>
                                @endif
                            @endforeach
                        </a>
                        <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card  ">
                            <div class="card border-0 shadow-lg rounded-4 ">
                                <div class="card-header row">
                                    <div class="col-md-6">
                                        <h3 class="ms-auto">Thông báo</h3>
                                    </div>
                                    <div class="col-md-6">
                                        <a class="ms-auto float-end" href="javascript: markAllAsRead()">Đánh dấu tất cả
                                            là đã đọc</a>
                                    </div>
                                </div>
                                <div class="list-group list-group-flush list-group-hoverable overflow-auto notification"
                                    style="max-height: 27rem" id="notificationBox">
                                    @if (auth()->user()->hasAnyDirectPermission(['access bill', 'edit bill', 'delete bill']) || auth()->user()->is_admin == 1)
                                    @if($user->notifications)
                                        @foreach ($user->notifications()->limit(10)->get() as $notification)
                                            <div class="list-group-item">
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        @if ($notification)
                                                            @if ($notification->read_at == null)
                                                                <span class="badge bg-danger" data-bs-toggle="tooltip"
                                                                    data-bs-placement="top" data-bs-title="Chưa đọc"
                                                                    name="notification-unread"
                                                                    id="notification-{{ $notification->id }}"></span>
                                                            @else
                                                                <span class="badge bg-success"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    data-bs-title="Đã đọc"
                                                                    id="notification-{{ $notification->id }}"></span>
                                                            @endif
                                                        @endif
                                                    </div>
                                                    <div class="col text-truncate " style="width:850px; max-width: 850px">
                                                        <a onclick="markAsRead('{{ $notification->id }}')"
                                                            href="javascript: viewPurchaseHistoryDetail({{ $notification->data['purchase_history_id'] }});"
                                                            class="text-body d-block">
                                                            @if ($notification->data['purchase_method'] == 2)
                                                                Mã giao dịch VN Pay:
                                                                {{ $notification->data['transaction_id'] }}
                                                            @else
                                                                Khách hàng chuyển khoản online:
                                                            @endif
                                                        </a>
                                                        <div class="d-block text-secondary mt-n1">
                                                            <span
                                                                class="text-wrap">{{ $notification->data['data'] }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <a data-bs-toggle="tooltip" data-bs-placement="right"
                                                            data-bs-title="Đánh dấu là đã đọc"
                                                            href="javascript: markAsRead('{{ $notification->id }}')"><svg
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                class="icon icon-tabler icon-tabler-checks"
                                                                width="30" height="24" viewBox="0 0 24 24"
                                                                stroke-width="5" stroke="paleGreen" fill="none"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none">
                                                                </path>
                                                                <path d="M7 12l5 5l10 -10"></path>
                                                                <path d="M2 12l5 5m5 -5l5 -5"></path>
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                    <span class="col text-truncate">Không có thông báo</span>
                                    @endif
                                    @else
                                        <span class="col text-truncate">Không có thông báo</span>
                                    @endif

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
                        @if (auth()->user()->is_admin == 1)
                            <div class="d-none d-xl-block ps-2">
                                <div>{{ auth()->user()->name }}</div>
                                <div class="mt-1 small text-secondary">6 anh em</div>
                            </div>
                        @else
                            <div class="d-none d-xl-block ps-2 pl-1">
                                <div>{{ auth()->user()->name }}</div>
                            </div>
                        @endif

                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="route('logout')"
                                onclick="event.preventDefault();
                                        this.closest('form').submit();"
                                class="dropdown-item">
                                <span class="me-2">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-logout" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path
                                            d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2">
                                        </path>
                                        <path d="M9 12h12l-3 -3"></path>
                                        <path d="M18 15l3 -3"></path>
                                    </svg>
                                </span>
                                Logout
                            </a>
                        </form>
                    </div>
                </div>


            </div>
        </div>
    </header>
</div>
<script src="https://js.pusher.com/8.0.1/pusher.min.js"></script>
<script type="text/javascript">
    let backendBaseUrl = "http://be-vcdtt.datn-vcdtt.test";
    var user = <?php echo $user; ?>;
    var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
        cluster: "ap1",
        authEndpoint: `${backendBaseUrl}/broadcasting/auth`,
        auth: {
            headers: {
                "Authorization": "Bearer "
            }
        },
        encrypted: true
    });
    var channel = pusher.subscribe('private-datn-vcdtt-development.' + user.id);
    channel.bind('Illuminate\\Notifications\\Events\\BroadcastNotificationCreated', function(data) {
        var id = data.id;
        if (data.purchase_method == 2) {
            var purchaseMethodText = 'Mã giao dịch VN Pay:' + data.transaction_id;
        } else {
            var purchaseMethodText = 'Khách hàng chuyển khoản online:';
        }

        var newNotificationHtml = `
            <div class="list-group-item">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <span class="badge bg-danger" name="notification-unread" id="notification-` + id + `" data-bs-toggle="tooltip"
                        data-bs-placement="top"
                        data-bs-title="Chưa đọc"></span>
                    </div>
                    <div class="col text-truncate " style="width: 850px">
                        <a onclick="markAsRead('` + id + `')"
                        href="javascript: viewPurchaseHistoryDetail(${data.purchase_history_id});"
                            class="text-body d-block">
                            ` + purchaseMethodText + `
                        </a>
                        <div class="d-block text-secondary mt-n1">
                            <span
                                class="text-wrap">${data.data}</span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <a data-bs-toggle="tooltip" data-bs-placement="right"
                            data-bs-title="Đánh dấu là đã đọc"
                            href="javascript: markAsRead('` + id + `')"><svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="icon icon-tabler icon-tabler-checks"
                                width="30" height="24" viewBox="0 0 24 24"
                                stroke-width="5" stroke="paleGreen" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none">
                                </path>
                                <path d="M7 12l5 5l10 -10"></path>
                                <path d="M2 12l5 5m5 -5l5 -5"></path>
                            </svg></a>
                    </div>
                </div>
            </div>
        `;

        var notificationPing = `
            <span class="badge bg-red" id="notificationDot"></span>
        `

        $('.notification').prepend(newNotificationHtml);
        $('#notificationDot').remove();
        $('#notificationPing').prepend(notificationPing);
    });

    let markAsRead = function(id) {
        axios.get(`/api/purchase-history/mark-as-read/${id}`)
            .then(function(response) {
                readNoti(id);
            })
            // .catch(function(error) {
            //     bs5Utils.Snack.show('danger', 'Error', delay = 5000, dismissible = true);
            // })
            .finally(function() {
                let checkNoti = document.getElementsByName('notification-unread');
                if (checkNoti.length == 0 && document.getElementById('notificationDot')) {
                    document.getElementById('notificationDot').remove();
                }
            });

    };

    let readNoti = function(id) {
        document.getElementById('notification-' + id).classList.remove('bg-danger');
        document.getElementById('notification-' + id).removeAttribute('name')
        document.getElementById('notification-' + id).classList.add('bg-success');
    };

    let markAllAsRead = function() {
        axios.get(`/api/purchase-history/mark-all-as-read`)
            .then(function(response) {
                document.getElementsByName('notification-unread').forEach(
                    (element) => {
                        element.classList.remove('bg-danger');
                        element.classList.add('bg-success');
                    }

                );
            })
            .finally(function() {
                if (document.getElementById('notificationDot')) {
                    document.getElementById('notificationDot').remove();
                };
            });
    };
</script>
