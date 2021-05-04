"use strict";

// active class on navbar
document.querySelectorAll(".nav-item a").forEach(function (e) {
  e.classList.remove("active");
  e.addEventListener("click", function () {
    e.target.classList.add("active");
  });
});

if (document.querySelector(".checkoldpassword")) {
  var Password = document.querySelector(".checkoldpassword");
  Password.addEventListener("blur", function () {
    if (Password.value != "") {
      var req = new XMLHttpRequest();

      req.onload = function () {
        if (this.readyState == 4 && this.status == 200) {
          if (req.responseText != 1) {
            if (document.querySelector('.notmatchedpassword')) {
              document.querySelector(".notmatchedpassword").remove();
            }

            var pp = document.createElement("p");
            pp.classList.add("alert");
            pp.classList.add("notmatchedpassword");
            pp.classList.add("alert-danger");
            var ptext = document.createTextNode(' soory old password not coorect');
            pp.appendChild(ptext);
            document.querySelector(".checkdiv").appendChild(pp);
            document.querySelector(".submit").classList.add("disabled");
          } else {
            if (document.querySelector('.notmatchedpassword')) {
              document.querySelector(".notmatchedpassword").remove();
            }

            document.querySelector(".submit").classList.remove("disabled");
          }
        }
      };

      req.open("POST", "http://www.shop.com/admin/checkpass.php");
      req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      req.send("Password=" + this.value);
    } else {
      if (document.querySelector('.notmatchedpassword')) {
        document.querySelector(".notmatchedpassword").remove();
      }
    }
  });
}