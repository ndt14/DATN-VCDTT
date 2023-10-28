<!-- Sidebar -->
<aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="dark">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu" aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <h1 class="navbar-brand navbar-brand-autodark">
      <a href="http://datn-vcdtt.test:5173/" class="btn btn-primary">
        Trang chủ
      </a>
    </h1>

    <div class="collapse navbar-collapse" id="sidebar-menu">
      <ul class="navbar-nav pt-lg-3">



        <li class="nav-item">
          <a class="nav-link" href="http://datn-vcdtt.test">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chart-histogram" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M3 3v18h18"></path>
                <path d="M20 18v3"></path>
                <path d="M16 16v5"></path>
                <path d="M12 13v8"></path>
                <path d="M8 16v5"></path>
                <path d="M3 11c6 0 5 -5 9 -5s3 5 9 5"></path>
              </svg>
            </span>
            <span class="nav-link-title">
              Thống kê
            </span>
          </a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-map-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M12 18.5l-3 -1.5l-6 3v-13l6 -3l6 3l6 -3v7.5"></path>
                <path d="M9 4v13"></path>
                <path d="M15 7v5.5"></path>
                <path d="M21.121 20.121a3 3 0 1 0 -4.242 0c.418 .419 1.125 1.045 2.121 1.879c1.051 -.89 1.759 -1.516 2.121 -1.879z"></path>
                <path d="M19 18v.01"></path>
              </svg>
            </span>
            <span class="nav-link-title">
              Tour
            </span>
          </a>
          <div class="dropdown-menu">
            <div class="dropdown-menu-columns">
              <div class="dropdown-menu-column">
                <a class="dropdown-item" href="{{route('tour.list')}}">
                  Nội dung
                </a>
                <!-- <a class="dropdown-item" href="{{route('tour.list')}}">
                    Selling management
                  </a> -->
                  <a class="dropdown-item" href="{{route('all.rating.list')}}">
                    Quản lý tất đánh giá
                  </a>
              </div>
            </div>
          </div>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{route('blog.list')}}">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-notebook" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M6 4h11a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-11a1 1 0 0 1 -1 -1v-14a1 1 0 0 1 1 -1m3 0v18"></path>
                <path d="M13 8l2 0"></path>
                <path d="M13 12l2 0"></path>
              </svg>
            </span>
            <span class="nav-link-title">
              Bài viết
            </span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{route('faq.list')}}">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-message" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M8 9h8"></path>
                <path d="M8 13h6"></path>
                <path d="M18 4a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-5l-5 3v-3h-2a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12z"></path>
              </svg>
            </span>
            <span class="nav-link-title">
              FAQs
            </span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{route('purchase_histories.list')}}">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-invoice" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
                <path d="M9 7l1 0"></path>
                <path d="M9 13l6 0"></path>
                <path d="M13 17l2 0"></path>
              </svg>
            </span>
            <span class="nav-link-title">
              Đơn đặt
            </span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('category.list')}}">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <i class="fa-brands fa-microsoft"></i>
            </span>
            <span class="nav-link-title">
              Danh mục
            </span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{route('coupon.list')}}">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <i class="fa-solid fa-ticket"></i>
            </span>
            <span class="nav-link-title">
              Mã giảm giá
            </span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{route('user.list')}}">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-heart" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                <path d="M6 21v-2a4 4 0 0 1 4 -4h.5"></path>
                <path d="M18 22l3.35 -3.284a2.143 2.143 0 0 0 .005 -3.071a2.242 2.242 0 0 0 -3.129 -.006l-.224 .22l-.223 -.22a2.242 2.242 0 0 0 -3.128 -.006a2.143 2.143 0 0 0 -.006 3.071l3.355 3.296z"></path>
              </svg>
            </span>
            <span class="nav-link-title">
              Tài khoản
            </span>
          </a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <i class="fa-solid fa-users"></i>
            </span>
            <span class="nav-link-title">
             Phân quyền
            </span>
          </a>
          <div class="dropdown-menu">
            <div class="dropdown-menu-columns">
              <div class="dropdown-menu-column">
                <a class="dropdown-item" href="{{route('role.list')}}">
                  Vai trò
                </a>
                <!-- <a class="dropdown-item" href="{{route('tour.list')}}">
                    Selling management
                  </a> -->
                  <a class="dropdown-item" href="{{route('all.rating.list')}}">
                    Cấp quyền sử dụng
                  </a>
              </div>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </div>
</aside>
