function sendmails() {
    let parametrs = {
        name: document.getElementById("username").value,
        email: document.getElementById("email").value
    };

    emailjs.send("service_hfnis4g", "template_4x941zs", parametrs)
        .then(response => {
            console.log("Email sent successfully:", response.status, response.text);
            alert("Confirmation email sent!");
        })
        .catch(error => {
            console.error("Failed to send email:", error);
            alert("Failed to send confirmation email. Please try again.");
        });
}
