const forms = document.getElementById("form_dia_chi");
const show = document.getElementById("show_dia_chi");
const huyButton = document.getElementById("huy");
const themButton = document.getElementById("them");
const submitButton = document.getElementById("submitButton");
const tbody_dia_chi = document.getElementById("tbody_dia_chi");



function them() {
  forms.style.display = "block";
  show.style.display = "none";
}


function huy() {
  forms.style.display = "none";
  show.style.display = "block";
}

themButton.onclick = them;




