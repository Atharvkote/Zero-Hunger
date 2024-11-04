function sendmails(){

    let parametrs={
        name:document.getElementById("username"),
        email : document.getElementById("email")
    }

    emailjs.send("service_hfnis4g","template_4x941zs",parametrs)
}