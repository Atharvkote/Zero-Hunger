function previewMedia(event) {
  const previewContainer = document.getElementById('preview-container');
  const file = event.target.files[0]; // Get the first file

  if (!file) {
    previewContainer.innerHTML = ''; // Clear preview
    return;
  }

  const reader = new FileReader();

  reader.onload = function (e) {
    const isImage = file.type.startsWith('image/');
    const isVideo = file.type.startsWith('video/');
    previewContainer.innerHTML = ''; // Clear any previous previews

    if (isImage) {
      const img = document.createElement('img');
      img.src = e.target.result;
      img.style.maxWidth = '100%';
      img.style.maxHeight = '200px';
      img.style.borderRadius = '20px';
      img.style.objectFit = 'cover';
      previewContainer.appendChild(img);
    } else if (isVideo) {
      const video = document.createElement('video');
      video.src = e.target.result;
      video.controls = true;
      video.style.maxWidth = '100%';
      video.style.maxHeight = '200px';
      previewContainer.appendChild(video);
    } else {
      alert('Invalid file type. Please upload an image or video.');
    }
  };

  reader.readAsDataURL(file);
}

function triggerInput(inputId) {
  const inputElement = document.getElementById(inputId);
  inputElement.value = ''; // Clear previous selection
  inputElement.click(); // Trigger the file input
}
