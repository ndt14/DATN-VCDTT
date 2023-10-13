function copyMultiInfoTab2() {
    var inputId2s = [
      "text4",
      "text5",
      "text6",
      "inputSTK",
      "inputMoney",
      "inputCont",
    ];
  
    var textToCopy = "";
    for (var i = 0; i < inputId2s.length; i++) {
      var input = document.getElementById(inputId2s[i]);
      textToCopy += input.value + "\n";
    }
  
    var tempInput = document.createElement("textarea");
    tempInput.style.position = "absolute";
    tempInput.style.left = "-9999px";
    document.body.appendChild(tempInput);
    tempInput.value = textToCopy;
    tempInput.select();
    document.execCommand("copy");
    document.body.removeChild(tempInput);
  
    Swal.fire({
      title: "Thông tin đã được sao chép",
      icon: "success",
      confirmButtonText: "Đóng",
    });
  }
  