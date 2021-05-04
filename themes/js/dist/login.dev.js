"use strict";

// login page
var login_btn = document.querySelectorAll(".btn-login"),
    regitser_btn = document.querySelectorAll(".btn-register"),
    login_form = document.querySelector(".login-form"),
    register_form = document.querySelector(".register-form"),
    form_box = document.querySelector(".login-page .box");
login_btn.forEach(function (btn) {
  btn.addEventListener("click", function () {
    form_box.classList.remove("slide");
    login_form.classList.remove("hidden-form");
    register_form.classList.add("hidden-form");
  });
});
regitser_btn.forEach(function (btn) {
  btn.addEventListener("click", function () {
    form_box.classList.add("slide");
    login_form.classList.add("hidden-form");
    register_form.classList.remove("hidden-form");
  });
});