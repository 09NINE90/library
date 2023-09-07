const form = document.querySelector(".search form"),
searchBtn = form.querySelector(".button input");

searchBtn.onclick = () => {
  
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "php/search.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let data = xhr.response;
        if (data === "success") {
          location.href = "login.php";
        }
      }
    }
  };
  let formData = new FormData(form);
  xhr.send(formData);
};
