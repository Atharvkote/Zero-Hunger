function getCurrentLocation() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position) {
        const latitude = position.coords.latitude;
        const longitude = position.coords.longitude;
  
        // Set the values of the hidden input fields
        document.getElementById('latitude').value = latitude;
        document.getElementById('longitude').value = longitude;
      }, function(error) {
        // Handle geolocation errors
        document.getElementById('latitude').value = 69;
        document.getElementById('longitude').value = 69;
      });
    } else {
      // If geolocation is not supported by the browser
      document.getElementById('latitude').value = 69;
      document.getElementById('longitude').value = 69;
    }
  }
  