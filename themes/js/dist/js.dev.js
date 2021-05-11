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
  if (document.querySelector(".menu-has-children.active .submenu")) {
    document.querySelector(".menu-has-children.active .submenu").removeAttribute("style");
  }

  if (document.querySelector(".menu-has-children.active")) {
    document.querySelector(".menu-has-children.active").classList.remove("active");
  }
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
}); // fetch country api

var selectcountry = document.querySelector(".all-countries");

function fetch_countries() {
  fetch("https://restcountries.eu/rest/v2/all").then(function (resp) {
    return data = resp.json();
  }).then(function (data) {
    // for(let country of data)
    // {
    //     let option = new Option(country['name'],country['name']);
    //     selectcountry.appendChild(option);
    // }
    data.map(function (country) {
      var option = new Option(country['name'], country['name']);
      selectcountry.appendChild(option);
    });
  })["catch"](function (err) {
    console.log(err);
  });
}

if (selectcountry) {
  fetch_countries();
}

var input_item_name = document.querySelector('.check-item-exists');
var myform = document.querySelector(".theform");

if (input_item_name) {
  input_item_name.addEventListener("blur", function () {
    // let formdata = new FormData();
    // formdata.append('itemName',input_item_name.value);
    var itemname = new URLSearchParams("itemName=".concat(input_item_name.value));
    fetch("http://www.shop.com/admin/check_data/checkdata.php", {
      method: 'POST',
      body: itemname
    }).then(function (resp) {
      return answer = resp.text();
    }).then(function (answer) {
      if (answer == 'yes') {
        if (document.querySelector('.exists-value')) {
          document.querySelector(".exists-value").remove();
        }

        var pp = document.createElement("p");
        pp.classList.add("alert");
        pp.classList.add("exists-value");
        pp.classList.add("alert-danger");
        var ptext = document.createTextNode("soory this item is exists ");
        pp.appendChild(ptext);
        input_item_name.parentElement.appendChild(pp);
        document.querySelector(".submit").classList.add("disabled");
      } else if (answer == 'no') {
        if (document.querySelector('.exists-value')) {
          document.querySelector(".exists-value").remove();
        }

        document.querySelector(".submit").classList.remove("disabled");
      }
    });
  });
} // let sub = document.querySelector(".submit");
// sub.addEventListener("click",(e)=>
// {
//     e.preventDefault();
//     let mdata = new URLSearchParams();
//     for(let names of new FormData(myform))
//     {
//         mdata.append(names[0],names[1])
//     }
//         fetch("http://www.shop.com/admin/check_data/checkdata.php",
//     {
//         method: 'POST',
//         // headers: {
//         //     'Content-Type': 'application/x-www-form-urlencoded', 
//         // },
//         body: mdata
//     })
//     .then(resp=>
//         {
//             return answer = resp.json();
//         })
//     .then(answer=>
//         {
//             console.log(answer)
//         })
// })
// live review


var itemname = document.querySelector(".item-info .it-name");
var itemndesc = document.querySelector(".item-info .it-desc");
var itemprice = document.querySelector(".item-info .it-price");
var itemrating = document.querySelector(".item-rating");

function livepreview(el) {
  if (el) {
    el.addEventListener("keyup", function () {
      document.querySelector(el.getAttribute('data-name')).innerHTML = el.value;
    });
  }
}

livepreview(input_item_name); // console.log(document.querySelector('input[data-name=".it-desc"'))

livepreview(document.querySelector('[data-name=".it-desc"'));
livepreview(document.querySelector('[data-name=".it-price"'));
var selector_ratings = document.querySelector("select[name='itemRating']");

if (selector_ratings) {
  selector_ratings.addEventListener("change", function () {
    itemrating.innerHTML = "";
    var x = selector_ratings.value;

    for (var i = 0; i < x; i++) {
      var span = document.createElement("span");
      var istar = document.createElement("i");
      istar.classList.add("fas");
      istar.classList.add("fa-star");
      istar.classList.add("start-chekced");
      span.appendChild(istar);
      itemrating.appendChild(span);
    }

    for (var y = 0; y < 5 - x; y++) {
      var _span = document.createElement("span");

      var _istar = document.createElement("i");

      _istar.classList.add("fas");

      _istar.classList.add("fa-star");

      _span.appendChild(_istar);

      itemrating.appendChild(_span);
    }
  });
} // test dropdpwn menu


var dropdownli = document.querySelector(".drop-test");

if (dropdownli) {
  dropdownli.addEventListener("click", function () {
    var sub = document.querySelector(".sub");
    sub.classList.toggle("show");
    sub.style.maxHeight = sub.scrollHeight + "px"; // console.log(sub.scrollHeight)
  });
}

window.addEventListener("resize", function () {
  var sub = document.querySelector(".sub");

  if (sub) {
    if (sub.classList.contains("show")) {
      sub.classList.toggle("show");
    }
  }
}); // search all items at home page

var searchinput = document.querySelector(".search-input");
searchinput.addEventListener("keyup", function () {
  var all_contents = document.querySelectorAll(".item-content");

  if (searchinput.value.length > 0) {
    all_contents.forEach(function (e) {
      e.style.display = "none";
    });
    var searcheditem = new URLSearchParams("searcheditem=".concat(searchinput.value));
    fetch("http://www.shop.com/admin/check_data/checkdata.php", {
      method: 'POST',
      body: searcheditem
    }).then(function (resp) {
      return answer = resp.json();
    }).then(function (data) {
      if (data !== false) {
        var _iteratorNormalCompletion = true;
        var _didIteratorError = false;
        var _iteratorError = undefined;

        try {
          for (var _iterator = data[Symbol.iterator](), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
            var items = _step.value;
            var dataname = items['itemName'].replace(/\s|[0-9]|[%]/g, "");
            console.log(dataname);

            if (document.querySelector("[data-name=".concat(dataname))) {
              document.querySelector("[data-name=".concat(dataname)).style.display = "flex";
            }
          }
        } catch (err) {
          _didIteratorError = true;
          _iteratorError = err;
        } finally {
          try {
            if (!_iteratorNormalCompletion && _iterator["return"] != null) {
              _iterator["return"]();
            }
          } finally {
            if (_didIteratorError) {
              throw _iteratorError;
            }
          }
        }
      } //     {
      //         let dataname = data['itemName'].replace(" ","");
      //         if(document.querySelector(`[data-name=${dataname}`))
      //         {
      //             document.querySelector(`[data-name=${dataname}`).style.display ="flex";
      //         }
      //     }

    }); // if(fetch_item() !== false)
    // {
    //      console.log(item);
    //     // if(document.querySelector(`[data-name=${}`))
    //     // {
    //     //     document.querySelector(`[data-name=${searchinput.value}`).style.display ="flex";
    //     // }
    // }
  } else {
    all_contents.forEach(function (e) {
      e.style.display = "flex";
    });
  }
});