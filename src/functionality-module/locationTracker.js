function sendLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(position => {
            const latitude = position.coords.latitude;
            const longitude = position.coords.longitude;

            // Send latitude and longitude to PHP backend via AJAX
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "saveLocation.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    console.log("Location sent successfully");
                }
            };
            xhr.send("latitude=" + latitude + "&longitude=" + longitude);
        });
    } else {
        alert("Geolocation is not supported by this browser.");
    }
}