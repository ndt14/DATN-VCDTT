<!-- Sidebar -->
@php
    $currentController = class_basename($__data['app']['request']->route()->getController());
@endphp
<aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="light" style="z-index: 98;">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu" aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <h1 class="text-indigo navbar-brand">
      <a href="http://datn-vcdtt.test:5173/" class="d-flex align-items-center text-indigo text-decoration-none">
        <span class="fs-1 text-indigo">Home page</span>
      </a>
    </h1>
    <div class="collapse navbar-collapse" id="sidebar-menu">
      <ul class="navbar-nav pt-lg-5 mt-lg-3 accordion" id="nav-parent">
        <li class="nav-item py-lg-2 accordion-item {{ $currentController == 'DashboardController' ? 'active active-sidebar' : '' }}" style="border: none;">
            <a class="accordion-header accordion-button nav-link {{ $currentController == 'DashboardController' ? '' : 'collapsed' }}" href="#navbar-help" data-bs-toggle="collapse" data-bs-target="#nav-link-3" role="button" aria-expanded="{{ $currentController == 'DashboardController' ? 'true' : 'false' }}">
              <span class="d-md-none d-lg-inline-block text-back me-1">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chart-histogram" style="margin-bottom: 2px;" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M3 3v18h18"></path>
                <path d="M20 18v3"></path>
                <path d="M16 16v5"></path>
                <path d="M12 13v8"></path>
                <path d="M8 16v5"></path>
                <path d="M3 11c6 0 5 -5 9 -5s3 5 9 5"></path>
              </svg>
            </span>
            <span class="fw-bold ms-1 fs-3">
              Thống kê
            </span>
            </a>
            <div id="nav-link-3" class="accordion-collapse collapse {{ $currentController == 'DashboardController' ? 'show' : '' }}" data-bs-parent="#nav-parent">
                <div class="accordion-body pt-0 ps-3">
                  <a class="nav-link fw-bold" href="{{route('dashboard.tour')}}">
                    - Thông kế doanh số tour
                  </a>
                  <a class="nav-link fw-bold" href="{{route('dashboard.user')}}" rel="noopener">
                    - Thống kê số liệu user
                  </a>
                </div>
              </div>
        </li>
        @if(auth()->user()->hasAnyDirectPermission(['access tour', 'add tour', 'edit tour', 'delete tour', 'access review', 'reply review', 'delete review']) || auth()->user()->is_admin == 1)
        <li class="nav-item py-lg-2 accordion-item {{ $currentController == 'TourController' ||$currentController == 'RatingController' ? 'active active-sidebar' : '' }}" style="border: none;">
          <a class="accordion-header accordion-button nav-link {{ $currentController == 'TourController' ||$currentController == 'RatingController' ? '' : 'collapsed' }}" href="#navbar-help" data-bs-toggle="collapse" data-bs-target="#nav-link-1" role="button" aria-expanded="{{ $currentController == 'TourController' ||$currentController == 'RatingController' ? 'true' : 'false' }}">
            <span class="d-md-none d-lg-inline-block text-back me-1">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-map-2" style="margin-bottom: 2px;" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M12 18.5l-3 -1.5l-6 3v-13l6 -3l6 3l6 -3v7.5"></path>
                <path d="M9 4v13"></path>
                <path d="M15 7v5.5"></path>
                <path d="M21.121 20.121a3 3 0 1 0 -4.242 0c.418 .419 1.125 1.045 2.121 1.879c1.051 -.89 1.759 -1.516 2.121 -1.879z"></path>
                <path d="M19 18v.01"></path>
              </svg>
            </span>
            <span class="fw-bold ms-1 fs-3">
              Tour
            </span>
          </a>
          <div id="nav-link-1" class="accordion-collapse collapse {{ $currentController == 'TourController' ||$currentController == 'RatingController' ? 'show' : '' }}" data-bs-parent="#nav-parent">
            <div class="accordion-body pt-0 ps-3">
              @if(auth()->user()->hasAnyDirectPermission(['access tour', 'add tour', 'edit tour', 'delete tour', 'reply review']) || auth()->user()->is_admin == 1)
              <a class="nav-link fw-bold" href="{{route('tour.list')}}">
                - Nội dung
              </a>
              @endif
              @if(auth()->user()->hasAnyDirectPermission(['access review', 'reply review', 'delete review']) || auth()->user()->is_admin == 1)
              <a class="nav-link fw-bold" href="{{route('all.rating.list')}}" rel="noopener">
                - Quản lý tất đánh giá
              </a>
              @endif
            </div>
          </div>
        </li>
        @endif
        @if(auth()->user()->hasAnyDirectPermission(['access post', 'add post', 'edit post', 'delete post']) || auth()->user()->is_admin == 1)
        <li class="nav-item py-lg-2 {{ $currentController == 'BlogController' ? 'active active-sidebar' : '' }}">
          <a class="nav-link" href="{{route('blog.list')}}">
            <span class="me-1 d-md-none d-lg-inline-block">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-notebook" style="margin-bottom: 2px;" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M6 4h11a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-11a1 1 0 0 1 -1 -1v-14a1 1 0 0 1 1 -1m3 0v18"></path>
                <path d="M13 8l2 0"></path>
                <path d="M13 12l2 0"></path>
              </svg>
            </span>
            <span class="fw-bold ms-1 fs-3">
              Bài viết
            </span>
          </a>
        </li>
        @endif
        @if(auth()->user()->hasAnyDirectPermission(['access faq', 'add faq', 'edit faq', 'delete faq']) || auth()->user()->is_admin == 1)
        <li class="nav-item py-lg-2 {{ $currentController == 'FAQController' ? 'active active-sidebar' : '' }}">
          <a class="nav-link" href="{{route('faq.list')}}">
            <span class="me-1 d-md-none d-lg-inline-block">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-message" style="margin-bottom: 2px;" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M8 9h8"></path>
                <path d="M8 13h6"></path>
                <path d="M18 4a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-5l-5 3v-3h-2a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12z"></path>
              </svg>
            </span>
            <span class="fw-bold ms-1 fs-3">
              FAQs
            </span>
          </a>
        </li>
        @endif
        @if(auth()->user()->hasAnyDirectPermission(['access bill', 'edit bill', 'delete bill']) || auth()->user()->is_admin == 1)
        <li class="nav-item py-lg-2 {{ $currentController == 'PurchaseHistoryController' ? 'active active-sidebar' : '' }}">
          <a class="nav-link" href="{{route('purchase_histories.list')}}">
            <span class="me-1 d-md-none d-lg-inline-block">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-invoice" style="margin-bottom: 2px;" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
                <path d="M9 7l1 0"></path>
                <path d="M9 13l6 0"></path>
                <path d="M13 17l2 0"></path>
              </svg>
            </span>
            <span class="fw-bold ms-1 fs-3">
              Đơn đặt
            </span>
          </a>
        </li>
        @endif
        @if(auth()->user()->hasAnyDirectPermission(['access category','add category','edit category', 'delete category']) || auth()->user()->is_admin == 1)
        <li class="nav-item py-lg-2 {{ $currentController == 'CategoryController' ? 'active active-sidebar' : '' }}">
          <a class="nav-link" href="{{route('category.list')}}">
            <span class="me-1 d-md-none d-lg-inline-block">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-tags" style="margin-bottom: 2px;" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M3 8v4.172a2 2 0 0 0 .586 1.414l5.71 5.71a2.41 2.41 0 0 0 3.408 0l3.592 -3.592a2.41 2.41 0 0 0 0 -3.408l-5.71 -5.71a2 2 0 0 0 -1.414 -.586h-4.172a2 2 0 0 0 -2 2z"></path>
                <path d="M18 19l1.592 -1.592a4.82 4.82 0 0 0 0 -6.816l-4.592 -4.592"></path>
                <path d="M7 10h-.01"></path>
              </svg>
            </span>
            <span class="fw-bold ms-1 fs-3">
              Danh mục
            </span>
          </a>
        </li>
        @endif

        @if(auth()->user()->hasAnyDirectPermission(['access discount', 'add discount', 'edit discount', 'delete discount']) || auth()->user()->is_admin == 1)
        <li class="nav-item py-lg-2 {{ $currentController == 'CouponController' ? 'active active-sidebar' : '' }}">
          <a class="nav-link" href="{{route('coupon.list')}}">
            <span class="me-1 d-md-none d-lg-inline-block">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-ticket" style="margin-bottom: 2px;" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M15 5l0 2"></path>
                <path d="M15 11l0 2"></path>
                <path d="M15 17l0 2"></path>
                <path d="M5 5h14a2 2 0 0 1 2 2v3a2 2 0 0 0 0 4v3a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-3a2 2 0 0 0 0 -4v-3a2 2 0 0 1 2 -2"></path>
              </svg>
            </span>
            <span class="fw-bold ms-1 fs-3">
              Mã giảm giá
            </span>
          </a>
        </li>
        @endif
        @if(auth()->user()->hasAnyDirectPermission(['access account', 'add account', 'edit account', 'delete account']) || auth()->user()->is_admin == 1)
        <li class="nav-item py-lg-2 {{ $currentController == 'UserController' ? 'active active-sidebar' : '' }}">
          <a class="nav-link" href="{{route('user.list')}}">
            <span class="me-1 d-md-none d-lg-inline-block">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users" style="margin-bottom: 2px;" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
              </svg>
            </span>
            <span class="fw-bold ms-1 fs-3">
              Tài khoản
            </span>
          </a>
        </li>
        @endif
        @if(auth()->user()->is_admin == 1)
        <li class="nav-item py-lg-2 accordion-item {{ $currentController == 'RoleController' || $currentController == 'AllocationController' ? 'active active-sidebar' : '' }}" style="border: none;">
          <a class="accordion-header accordion-button nav-link {{ $currentController == 'RoleController' || $currentController == 'AllocationController' ? '' : 'collapsed' }}" href="#navbar-help" data-bs-toggle="collapse" data-bs-target="#nav-link-2" role="button" aria-expanded="{{ $currentController == 'RoleController' || $currentController == 'AllocationController' ? 'true' : 'false' }}">
            <span class="d-md-none d-lg-inline-block text-back me-1">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-binary-tree" style="margin-bottom: 2px;" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M6 20a2 2 0 1 0 -4 0a2 2 0 0 0 4 0z"></path>
                <path d="M16 4a2 2 0 1 0 -4 0a2 2 0 0 0 4 0z"></path>
                <path d="M16 20a2 2 0 1 0 -4 0a2 2 0 0 0 4 0z"></path>
                <path d="M11 12a2 2 0 1 0 -4 0a2 2 0 0 0 4 0z"></path>
                <path d="M21 12a2 2 0 1 0 -4 0a2 2 0 0 0 4 0z"></path>
                <path d="M5.058 18.306l2.88 -4.606"></path>
                <path d="M10.061 10.303l2.877 -4.604"></path>
                <path d="M10.065 13.705l2.876 4.6"></path>
                <path d="M15.063 5.7l2.881 4.61"></path>
              </svg>
            </span>
            <span class="fw-bold ms-1 fs-3">
              Phân quyền
            </span>
          </a>
          <div id="nav-link-2" class="accordion-collapse collapse {{ $currentController == 'RoleController' || $currentController == 'AllocationController' ? 'show' : '' }}" data-bs-parent="#nav-parent">
            <div class="accordion-body pt-0 ps-3">
              <a class="nav-link fw-bold" href="{{route('role.list')}}">
                - Vai trò
              </a>
              <a class="nav-link fw-bold" href="{{route('allocation.list')}}" rel="noopener">
                - Cấp quyền sử dụng
              </a>
            </div>
          </div>
        </li>
        @endif
        <li class="nav-item py-lg-2 {{ $currentController == 'ImageController' ? 'active active-sidebar' : '' }}">
          <a class="nav-link" href="{{route('image.list')}}">
            <span class="me-1 d-md-none d-lg-inline-block">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-photo" style="margin-bottom: 2px;" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M15 8h.01"></path>
                <path d="M3 6a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v12a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3v-12z"></path>
                <path d="M3 16l5 -5c.928 -.893 2.072 -.893 3 0l5 5"></path>
                <path d="M14 14l1 -1c.928 -.893 2.072 -.893 3 0l3 3"></path>
              </svg>
            </span>
            <span class="fw-bold ms-1 fs-3">
              Thư viện ảnh
            </span>
          </a>
        </li>
        <li class="nav-item py-lg-2 {{ $currentController == 'TermAndPrivacy' ? 'active active-sidebar' : '' }}">
          <a class="nav-link" href="{{route('page.list')}}">
            <span class="me-1 d-md-none d-lg-inline-block">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-license" style="margin-bottom: 2px;" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 21h-9a3 3 0 0 1 -3 -3v-1h10v2a2 2 0 0 0 4 0v-14a2 2 0 1 1 2 2h-2m2 -4h-11a3 3 0 0 0 -3 3v11" /><path d="M9 7l4 0" /><path d="M9 11l4 0" /></svg>
            </span>
            <span class="fw-bold ms-1 fs-3">
              Điều khoản & dịch vụ
            </span>
          </a>
        </li>
      </ul>
    </div>
  </div>
</aside>
