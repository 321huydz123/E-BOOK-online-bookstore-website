const searchBar = document.querySelector(".search input");
const searchIcon = document.querySelector(".search button");
const usersList = document.getElementById("usersList");

setInterval(() => {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "api/chatbox/inform.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
      if (!searchBar.classList.contains("active")) {
        usersList.innerHTML = xhr.response;
      }
    }
  };
  xhr.send();
}, 500);
