@extends('layouts.guest2')
@section('content')
<style>
  .disabled-link {
    cursor: not-allowed;
    pointer-events: none;
    color: gray;
    text-decoration: none;
  }
</style>
<div class="container container-tight py-4">
    <div class="text-center mb-2">
      <a href="." class="navbar-brand navbar-brand-autodark">
        <img src="{{asset('/images/logo-vcdtt-removebg.png')}}" style="width: auto; height: 6.25rem;">
      </a>
    </div>
    <div class="card border-0 shadow-lg rounded-4  card-md">
      <div class="card-body">
        <h2 class="h2 text-center mb-4">Đăng nhập</h2>

        <form action="{{ route('login') }}" method="POST" id="loginForm">
        @csrf  
      <div>
            {{-- <x-input-label for="email" :value="__('Email')" /> --}}
            @if (Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show text-center" role="alert" id="notiSuccess">
                    {{ Session::get('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                @if (Session::has('fail'))
                <script>
                    Swal.fire({
                    icon: "error",
                    title: "Gặp lỗi rồi!",
                    text: "{{ session('fail') }}",
                    footer: ''
                  });
                </script>
                @endif
        </div>
	    <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="abc@email.com" value="{{old('email') ?? ''}}">
          </div>
          <div class="mb-2">
            <label class="form-label">
              Mật khẩu
              <span class="form-label-description">
                {{-- <a href="{{ route('password.request') }}">Tôi quên mật khẩu</a> --}}
              </span>
            </label>
            <div class="input-group input-group-flat">
              <input type="password" class="form-control" name="password" id="password" placeholder="Nhập mật khẩu của bạn">
              <span class="input-group-text">
                <a href="#" class="link-secondary disabled-link" id="showPass"  data-bs-toggle="tooltip" aria-label="Show password" data-bs-original-title="Show password"><!-- Download SVG icon from http://tabler-icons.io/i/eye -->
                  <i class="fa-solid fa-eye-slash"></i>
                </a>
              </span>
            </div>
          </div>
          <div class="mb-2">
            <label class="form-check">
              <input type="checkbox" name="remember" class="form-check-input">
              <span class="form-check-label">Ghi nhớ tôi</span>
            </label>
          </div>
          <div class="form-footer">
            <button type="submit" class="btn btn-submit btn-indigo w-100">Đăng nhập</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endSection
@section('page_js')
<script type="text/javascript">
   document.getElementById('loginForm').addEventListener('submit', function (event) {
        // Ngăn chặn việc submit lần thứ 2 của form
        if (this.getAttribute('data-submitted') === 'true') {
            event.preventDefault();
        } else {
            // Đặt thuộc tính data-submitted thành true để chỉ ra rằng form đã được submit
            this.setAttribute('data-submitted', 'true');
        }
    });
</script>
<script type="text/javascript">
   var notiError = document.querySelector("#notiError");
   if(notiError) {

    setTimeout(() => {
      notiError.style.display = 'none';
    }, 5000);

   }

   var btnClose = document.querySelector(".btn-close");
   if(btnClose) {
    btnClose.addEventListener("click", () => {
    if(notiError) {
      notiError.style.display = 'none';
    }
   });
   }

   var showPass = document.querySelector("#showPass");
   var inputPass = document.querySelector("#password");
   showPass.addEventListener("click", (e) => {

    e.preventDefault();

    if(showPass.classList.toggle("noEyes")) {

    inputPass.type = 'text';
    showPass.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"></path></svg>';
    }else {

      inputPass.type = 'password';
      showPass.innerHTML = '<i class="fa-solid fa-eye-slash"></i>';
    }

   }) 

  

   inputPass.addEventListener("input", () => {
    if(inputPass.value !== "") {
      showPass.classList.remove("disabled-link");
   }else {
    showPass.classList.add("disabled-link");
   }
   })


</script>
@endSection