function copyMultiInfoTab1() {
    var inputIds = ["text1", "text2", "text3", "input1", "input2", "input3"];

    var textToCopy = "";
    for (var i = 0; i < inputIds.length; i++) {
      var input = document.getElementById(inputIds[i]);
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
