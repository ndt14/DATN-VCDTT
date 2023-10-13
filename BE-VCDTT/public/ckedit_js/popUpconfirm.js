function showConfirmation() {
  Swal.fire({
    title: "Bạn chắc chắn chứ?",
    text: "Hành động này không thể hoàn tác sau khi xác nhận.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#4e73df",
    cancelButtonColor: "#F6C23E",
    confirmButtonText: "Xác nhận",
    cancelButtonText: "Hủy bỏ",
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire("Xác nhận thành công!", "", "success");
    } else if (result.dismiss === Swal.DismissReason.cancel) {
      Swal.fire("Hủy bỏ hành động.", "", "error");
    }
  });
}

function UploadSuccess() {
  document.getElementById('upload-link').disabled = false;
  
  var icon = document.getElementById('upload-link').querySelector('span');
  icon.style.backgroundColor = '#00ff00'; // Change to desired color
  
  Swal.fire({
    position: 'top',
    icon: 'success',
    title: 'Tải ảnh lên thành công',
    showConfirmButton: false,
    timer: 1500
  });
}

function successPopup(){
  Swal.fire({
    icon: 'success',
    title: 'Thanh toán thành công',
    showConfirmButton: false,
    timer: 1500
  })
}

  