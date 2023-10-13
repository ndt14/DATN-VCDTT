function copyText(inputId) {
  var input = document.getElementById(inputId);
  input.select();
  input.setSelectionRange(0, 99999);
  document.execCommand("copy");

  Swal.fire({
    title: "Thông báo",
    text: "Thông tin đã được sao chép",
    icon: "success",
    confirmButtonText: "Đóng",
  });
}