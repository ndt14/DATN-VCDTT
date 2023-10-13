function handleFileInput(fileInputId) {
  const fileInput = document.getElementById(fileInputId);
  const chooseFileLabel = document.querySelector(`label[for="${fileInputId}"].custom-choose-file-button`);
  const selectedFileName = document.querySelector(`label[for="${fileInputId}"] .selected-file-name`);
  const imagePreview = document.querySelector(`label[for="${fileInputId}"] .image-preview`);

  fileInput.addEventListener('change', () => {
    if (fileInput.files.length > 0) {
      const file = fileInput.files[0];
      const allowedExtensions = /(\.jpg|\.jpeg|\.png|\.webp)$/i;

      if (!allowedExtensions.exec(file.name)) {
        fileInput.value = '';
        selectedFileName.textContent = '';
        selectedFileName.style.display = 'none';
        chooseFileLabel.querySelector('.choose-file-text').style.display = 'block';
        imagePreview.style.display = 'none';

        Swal.fire({
          icon: 'error',
          title: 'Tải file không hợp lệ',
          text: 'Hãy tải lên file với định dạng: JPG, JPEG, PNG, or WebP',
        });
      } else {
        selectedFileName.textContent = file.name;
        chooseFileLabel.querySelector('.choose-file-text').style.display = 'none';
        selectedFileName.style.display = 'block';
        imagePreview.style.display = 'block';

        const reader = new FileReader();
        reader.onload = function (e) {
          const img = document.createElement('img');
          img.src = e.target.result;
          imagePreview.innerHTML = '';
          imagePreview.appendChild(img);
        };
        reader.readAsDataURL(file);
      }
    } else {
      selectedFileName.style.display = 'none';
      chooseFileLabel.querySelector('.choose-file-text').style.display = 'block';
      imagePreview.style.display = 'none';
    }
  });
}

// gọi hàm update Ảnh
handleFileInput('inputNH');
handleFileInput('inputMM');
