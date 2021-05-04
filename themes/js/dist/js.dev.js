"use strict";

var open_nav_menu = document.querySelector(".open-nav");
var desktop_menu = document.querySelector(".desktop-menu");
var open_desktop_menu = document.querySelector(".desktop-menu.show");
var close_nav_menu = document.querySelector(".close-menu");
var overlay = document.querySelector(".overlay"); // start open submenu

var clicked_a = document.querySelectorAll(".menu-list > a");
clicked_a.forEach(function (e) {
  e.addEventListener("click", function (e) {
    if (e.target.parentElement.classList.contains("menu-has-children") && window.innerWidth < 900) {
      var menu_has_children = e.target.parentElement; // هقفل نفسي

      if (menu_has_children.classList.contains("active")) {
        collapse_expanded_submenu();
      } else {
        // هقفل الباقين
        if (document.querySelector(".menu-has-children.active")) {
          collapse_expanded_submenu();
        } // لاول مره خالص مش عليا اكتف وعايز افتح السب منيو


        menu_has_children.classList.add("active");
        var submenu = menu_has_children.querySelector(".submenu");
        submenu.style.maxHeight = submenu.scrollHeight + "px";
        submenu.style.visibility = "visible";
        submenu.style.opacity = "1";
      }
    }
  });
});
collapse_expanded_submenu;

function collapse_expanded_submenu() {
  document.querySelector(".menu-has-children.active .submenu").removeAttribute("style");
  document.querySelector(".menu-has-children.active").classList.remove("active");
} // open desktop_menu when click on open_nav 


open_nav_menu.addEventListener("click", toggle_nav_menu); //close desktopmenu 

close_nav_menu.addEventListener("click", toggle_nav_menu);

function toggle_nav_menu() {
  desktop_menu.classList.toggle("show");
  overlay.classList.toggle("show");
  collapse_expanded_submenu();
}

document.addEventListener("click", function (e) {
  if (e.target.className == "overlay show") {
    toggle_nav_menu();
  }
});

function closenav() {
  desktop_menu.classList.remove("show");
}

window.onresize = function () {
  if (window.innerWidth > 900) {
    if (check_open_nav()) {
      toggle_nav_menu();
    }

    collapse_expanded_submenu();
  }

  if (window.innerWidth < 900 && open_desktop_menu) {
    open_desktop_menu.style.width = "calc(100% - 80px)";
  }
};

function check_open_nav() {
  if (desktop_menu.classList.contains("show")) {
    return true;
  }
} // form to add qty or decrease 


var increase_qty = document.querySelectorAll(".add-qty");
increase_qty.forEach(function (el) {
  el.addEventListener("click", function (btn) {
    btn.preventDefault();
    var input_item_qty = btn.target.nextElementSibling;
    input_item_qty.stepUp(1);
  });
});
var decrease_qty = document.querySelectorAll(".decrease-qty");
decrease_qty.forEach(function (el) {
  el.addEventListener("click", function (btn) {
    btn.preventDefault();
    var input_item_qty = btn.target.previousElementSibling;
    input_item_qty.stepDown(1);
  });
});