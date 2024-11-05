function sendmails() {
    let parametrs = {
        name: document.getElementById("username").value,
        email: document.getElementById("email").value,
        message : document.getElementById("message").value
    };

    emailjs.send("service_e8hjt14", "template_jcwqc78", parametrs)
        .then(response => {
            console.log("Email sent successfully:", response.status, response.text);
            alert("Confirmation email sent!");
        })
        .catch(error => {
            console.error("Failed to send email:", error);
            alert("Failed to send confirmation email. Please try again.");
        });
}
