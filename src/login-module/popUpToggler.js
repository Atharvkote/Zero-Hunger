function toggleLoginPopup() {
  const blurr = document.getElementById('blurr');
  blurr.classList.toggle('active');

  const popup = document.getElementById('popup');
  popup.classList.toggle('active');
}
function myFunction() {
    var x = document.getElementById("password");
    if (x.type === "password") {
      x.type = "text";
    } else {
      x.type = "password";
    }
  }