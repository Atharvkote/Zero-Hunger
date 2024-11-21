function sendLocation() {
    const submitButton = document.querySelector(".submit-button");
    
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(position => {
            const latitude = position.coords.latitude;
            const longitude = position.coords.longitude;

            // Append latitude and longitude to form action URL
            const form = document.querySelector("form");
            form.action = `donateFood.php?latitude=${latitude}&longitude=${longitude}`;
            
            // Enable the submit button after location is set
            submitButton.disabled = false;
            alert("Location added successfully! You can now submit the form.");
        });
    } else {
        alert("Geolocation is not supported by this browser.");
    }
}
