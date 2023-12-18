<!-- Tabler Core -->
<script src="{{ asset('admin/assets/js/tabler.min.js') }}" defer></script>
<script src="{{ asset('admin/assets/js/demo.min.js') }}" defer></script>
<!-- Jquery -->
<script src="{{ asset('admin/assets/js/vendors/jquery-3.6.3.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/vendors/Bs5Utils.js') }}"></script>
<script src="{{ asset('admin/assets/js/vendors/jquery.form.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/vendors/axios.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/vendors/fancybox.umd.js') }}"></script>
<!-- Plugins -->
{{-- <script src="{{ asset('ckedit_js/plugins/ckeditor/ckeditor.js') }}" type="text/javascript"></script> --}}
<!-- Libs JS -->
<script src="{{ asset('admin/assets/libs/apexcharts/dist/apexcharts.min.js') }}" defer></script>
<script src="{{ asset('admin/assets/libs/jsvectormap/dist/js/jsvectormap.min.js') }}" defer></script>
<script src="{{ asset('admin/assets/libs/jsvectormap/dist/maps/world.js') }}" defer></script>
<script src="{{ asset('admin/assets/libs/jsvectormap/dist/maps/world-merc.js') }}" defer></script>
<script src="{{ asset('admin/assets/libs/fslightbox/index.js') }}" defer></script>
<script src="{{ asset('admin/assets/libs/jquery-confirm/jquery-confirm.min.js') }}"></script>
{{-- Apex chart --}}
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<!-- JS -->
<script type="text/javascript">
    Bs5Utils.defaults.toasts.position = 'top-center';
    Bs5Utils.defaults.toasts.container = 'toast-container';
    Bs5Utils.defaults.toasts.stacking = false;
    const bs5Utils = new Bs5Utils();
    axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    let updateUrlParameter = function(key, value, uri) {
        if (!uri) {
            uri = window.location.href;
        }
        value = encodeURIComponent(value);
        // remove the hash part before operating on the uri
        let i = uri.indexOf('#');
        let hash = i === -1 ? '' : uri.substr(i);
        uri = i === -1 ? uri : uri.substr(0, i);

        let re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
        let separator = uri.indexOf('?') !== -1 ? "&" : "?";

        if (!value) {
            // remove key-value pair if value is empty
            uri = uri.replace(new RegExp("([&]?)" + key + "=.*?(&|$)", "i"), '');
            if (uri.slice(-1) === '?') {
                uri = uri.slice(0, -1);
            }
        } else if (uri.match(re)) {
            uri = uri.replace(re, '$1' + key + "=" + value + '$2');
        } else {
            uri = uri + separator + key + "=" + value;
        }
        return uri + hash;
    };
    let theme = localStorage.getItem('tablerTheme') ? localStorage.getItem('tablerTheme') : 'light';
    $(document).ready(function() {
        $('body').attr('data-bs-theme', theme);
        if ($('#rpp').length) {
            $('#rpp').change(function() {
                let objectClicked = $(this);
                let rppValue = objectClicked.val();
                let currentUrl = document.location.href;
                let newUrl = updateUrlParameter('limit', rppValue, currentUrl);
                document.location.replace(newUrl);
            });
        }
    });
    let modalContainer;
    $(document).ready(function() {
        modalContainer = new bootstrap.Modal('#modalContainer', {
            keyboard: true,
            backdrop: 'static'
        });
    });
    let viewPurchaseHistoryDetail = function(id) {
        axios.get(`/purchase-history/detail/${id}`)
            .then(function(response) {
                $('#modalContainer div.modal-content').html(response.data.html);
                modalContainer.show();
            })
            // .catch(function(error) {
            //     bs5Utils.Snack.show('danger', 'Error', delay = 5000, dismissible = true);
            // })
            .finally(function() {});
    };

    //lăn chuột để tải thông báo
    // Trang bắt đầu
    var page = 3;

    let loadNotifications = function() {
        axios.get(`api/get-notifications/${user.id}?page=` + page)
            .then(function(response) {
                // Thêm thông báo vào box
                checkRequest = response.data.notifications.last_page;
                console.log();
                notificationsArray = response.data.notifications.data;
                notificationsArray.forEach(function(notification) {
                    var id = notification.id;
                    if (notification.data.purchase_method == 2) {
                        if (notification.data.transaction_id == null) {
                            var purchaseMethodText = 'Mã giao dịch VN Pay:';
                        } else {
                            var purchaseMethodText = 'Mã giao dịch VN Pay:' + notification
                                .data.transaction_id;
                        }
                    } else {
                        var purchaseMethodText = 'Khách hàng chuyển khoản online:';
                    }

                    if (notification.read_at == null) {
                        var readNotiCheck = `<div class="col-auto">
                        <span class="badge bg-danger" name="notification-unread" id="notification-` + id + `" data-bs-toggle="tooltip"
                        data-bs-placement="top"
                        data-bs-title="Chưa đọc"></span>
                    </div>`
                    } else {
                        var readNotiCheck =
                            `<div class="col-auto"><span class="badge bg-success"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top" data-bs-title="Đã đọc"
                            id="notification-` + id + `"></span></div>`
                    }


                    var moreNotificationHtml = `
            <div class="list-group-item">
                <div class="row align-items-center">
                    ` + readNotiCheck + `
                    <div class="col text-truncate " style="width:925px; max-width: 925px">
                        <a onclick="markAsRead('` + id + `')"
                        href="javascript: viewPurchaseHistoryDetail(${notification.data.purchase_history_id});"
                            class="text-body d-block">
                            ` + purchaseMethodText + `
                        </a>
                        <div class="d-block text-secondary mt-n1">
                            <span
                                class="text-wrap">${notification.data.data}</span>
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
                    $('.notification').append(moreNotificationHtml);
                });

                // Tăng số trang
                page++;

                // Kiểm tra nếu đã cuộn đến cuối
                // if (page < response.data.lastPage) {
                //     if ($('#notificationBox').scrollTop() + $('#notificationBox').innerHeight() >= $(
                //             '#notificationBox')[0].scrollHeight) {
                //         loadNotifications();
                //     }
                // }
            });
    }
    $(document).ready(function() {
        $('#notificationBox').scroll(function(response) {
            // Kiểm tra nếu đã cuộn đến cuối
            if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
                // Tải thêm thông báo
                loadNotifications();
            }
        });
    });
</script>
