function toggleLoginPopup() {
  const blurr = document.getElementById('blurr');
  blurr.classList.toggle('active');

  const popup = document.getElementById('popup');
  popup.classList.toggle('active');

}
function toggleSponser() {
  const blurr1 = document.getElementById('blurr1');
  blurr1.classList.toggle('active');

  const popup1 = document.getElementById('popup1');
  popup1.classList.toggle('active');
}

function myFunction() {
    var x = document.getElementById("password");
    if (x.type === "password") {
      x.type = "text";
    } else {
      x.type = "password";
    }
  }