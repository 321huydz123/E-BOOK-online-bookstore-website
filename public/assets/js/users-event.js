const searchBar = document.querySelector(".search input");
const searchIcon = document.querySelector(".search button");
const usersList = document.querySelector(".users-list");

searchIcon.onclick = function () {
  searchBar.classList.toggle("show");
  searchIcon.classList.toggle("active");
  searchBar.focus();

  if (searchBar.classList.contains("active")) {
    searchBar.value = "";
    searchBar.classList.remove("active");
  }
};

searchBar.onkeyup = () => {
  let searchTerm = searchBar.value;
  if (searchTerm !== "") {
    searchBar.classList.add("active");
  } else {
    searchBar.classList.remove("active");
  }

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "api/chatbox/search.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
      usersList.innerHTML = xhr.response;
    }
  };
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send("searchTerm=" + searchTerm);
};

setInterval(() => {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "api/chatbox/users.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
      if (!searchBar.classList.contains("active")) {
        usersList.innerHTML = xhr.response;
      }
    }
  };
  xhr.send();
}, 500);
// const usersLists = document.getElementById("usersList");

// setInterval(() => {
//   let xhr = new XMLHttpRequest();
//   xhr.open("PUT", "api/inform.php", true);
//   xhr.onload = () => {
//     if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
//       if (!searchBar.classList.contains("active")) {
//         usersLists.innerHTML = xhr.response;
//       }
//     }
//   };
//   xhr.send();
// }, 500);
