function previewMedia(event, source) {
    const previewContainer = document.getElementById('preview-container');
    const files = event.target.files;

    // Clear the current images
    previewContainer.innerHTML = '';

    for (let i = 0; i < files.length; i++) {
      const file = files[i];
      const reader = new FileReader();

      reader.onload = function(e) {
        const img = document.createElement('img');
        img.src = e.target.result;
        img.style.maxWidth = '100%'; // Maintain width
        img.style.maxHeight = '200px'; // Set height limit
        img.style.borderRadius = '20px'; // Maintain rounded corners
        img.style.objectFit = 'cover'; // Maintain aspect ratio
        previewContainer.appendChild(img); // Add to the container
      }

      reader.readAsDataURL(file);
    }
  }

  function openCamera() {
    document.getElementById('camera-upload').click(); // Trigger the hidden file input for camera
  }

  function openGallery() {
    document.getElementById('gallery-upload').click(); // Trigger the hidden file input for gallery
  }

  function openVideoUpload() {
    document.getElementById('video-upload').click(); // Trigger the hidden file input for videos
  }