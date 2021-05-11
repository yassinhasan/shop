"use strict";

function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance"); }

function _iterableToArray(iter) { if (Symbol.iterator in Object(iter) || Object.prototype.toString.call(iter) === "[object Arguments]") return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = new Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } }

// active class on navbar
var alllinks = document.querySelectorAll(".nav-item a");
var url = window.location.href;
alllinks.forEach(function (e) {
  e.addEventListener("click", function () {
    removeactivelinks();
    e.classList.add("active");
  });
}); // remove active on llinks function

function removeactivelinks() {
  var alllinks = document.querySelectorAll(".nav-item a");
  alllinks.forEach(function (E) {
    E.classList.remove("active");
  });
}
/*
*  function expect 5 parameter
## el = element when bluer this el is input
## passedvalue = the value i will check on it
## error_message = the messeage wehen error exists
## userid = only when check on edit  
*/


check_if_exists('check-exists-category', "http://www.shop.com/admin/check_data/checkdata.php", "CategoryName", "Category name is exists");
check_if_exists('check-edit-category', "http://www.shop.com/admin/check_data/checkdata.php", "CategoryName", "Category name is exists", window.location.search);
check_if_exists('check-exists-user', "http://www.shop.com/admin/check_data/checkdata.php", "UserName", "UserName  is exists");
check_if_exists('check-edit-username', "http://www.shop.com/admin/check_data/checkdata.php", "UserName", "user name is exists", window.location.search);
check_if_exists('check-email', "http://www.shop.com/admin/check_data/checkdata.php", "Email", "Email  is exists");
check_if_exists('check-edit-email', "http://www.shop.com/admin/check_data/checkdata.php", "Email", "Email  is exists", window.location.search);
check_if_exists('checkoldpassword', "http://www.shop.com/admin/check_data/checkdata.php", "Password", "Password  is exists", window.location.search);

function check_if_exists(el, url, passed_value, error_message) {
  var Id = arguments.length > 4 && arguments[4] !== undefined ? arguments[4] : null;

  if (document.querySelector(".".concat(el))) {
    var exists_el = document.querySelector(".".concat(el));
    exists_el.addEventListener("blur", function () {
      if (exists_el.value != "") {
        var req = new XMLHttpRequest();

        req.onload = function () {
          if (req.readyState == 4 && req.status == 200) {
            if (req.responseText == "yes") {
              if (document.querySelector('.exists-value')) {
                document.querySelector(".exists-value").remove();
              }

              var pp = document.createElement("p");
              pp.classList.add("alert");
              pp.classList.add("exists-value");
              pp.classList.add("alert-danger");
              var ptext = document.createTextNode("soory this ".concat(error_message, " "));
              pp.appendChild(ptext);
              exists_el.parentElement.appendChild(pp);
              document.querySelector(".submit").classList.add("disabled");
            } else {
              if (document.querySelector('.exists-value')) {
                document.querySelector(".exists-value").remove();
              }

              document.querySelector(".submit").classList.remove("disabled");
            }
          }
        };

        if (Id != null) {
          Id = Id.replace("?", "");
        }

        req.open("POST", url);
        req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        req.send("".concat(passed_value, "=").concat(exists_el.value, "&").concat(Id));
      } else {
        if (document.querySelector('.exists-value')) {
          document.querySelector(".exists-value").remove();
        }
      }
    });
  }
} // check confirm password on blur


var confirmpassword = document.querySelector("input[name=ConfirmPassword]");

if (confirmpassword) {
  confirmpassword.addEventListener("blur", function () {
    var confirmpasswordvalue = confirmpassword.value;
    var password = document.querySelector("input[name=Password]");
    var passwordvalue = password.value;

    if (confirmpasswordvalue == "" || passwordvalue != confirmpasswordvalue) {
      if (document.querySelector('.notmatchedpassword')) {
        document.querySelector(".notmatchedpassword").remove();
      } // document.querySelector(".submit").classList.remove("disabled");


      var pp = document.createElement("p");
      pp.classList.add("alert");
      pp.classList.add("notmatchedpassword");
      pp.classList.add("alert-danger");
      var ptext;

      if (confirmpasswordvalue == "") {
        ptext = document.createTextNode(' soory confirm password must not empty ');
      } else {
        ptext = document.createTextNode(' soory confirm not matched password ');
      }

      pp.appendChild(ptext);
      document.querySelector(".confirmdiv").appendChild(pp);
      document.querySelector(".submit").classList.add("disabled");
    } else {
      if (document.querySelector('.notmatchedpassword')) {
        document.querySelector(".notmatchedpassword").remove();
      }

      document.querySelector(".submit").classList.remove("disabled");
    }
  });
} // form input add strix


var inputwithreqiured = document.querySelectorAll("input[required]");
inputwithreqiured.forEach(function (inp) {
  var inputparent = inp.parentElement;
  inputparent.style.position = "relative";
  var i = document.createElement("i");
  i.classList.add("fas");
  i.classList.add("fa-star");
  i.classList.add("star-required");
  inputparent.appendChild(i);
  inp.addEventListener("focus", function () {
    inp.parentElement.querySelector(".star-required").style.opacity = "0";
  });
  inp.addEventListener("blur", function () {
    if (inp.value == "") {
      inp.parentElement.querySelector(".star-required").style.opacity = "1";
    } else {
      inp.parentElement.querySelector(".star-required").style.opacity = "0";
    }
  });
}); //toogle category bodu when click on titile

var card_title = document.querySelectorAll(".card-title");
card_title.forEach(function (e) {
  e.addEventListener("click", function (el) {
    el.target.nextElementSibling.classList.toggle("hide");
    el.target.parentElement.querySelector('.cat-box').classList.toggle("hide");
  });
}); //    document.querySelector(".full-view").addEventListener("click",toggle_card_body('full-view'));
//    document.querySelector(".classic-view").addEventListener("click",toggle_card_body('classic'));

function toggle_card_body(data_view) {
  if (data_view == 'classic') {
    var card_body = document.querySelectorAll(".card-text");
    card_body.forEach(function (e) {
      e.classList.add("hide");
    });
    var cat_box = document.querySelectorAll(".cat-box");
    cat_box.forEach(function (el) {
      el.classList.add("hide");
    });
  }

  if (data_view == 'full') {
    var _card_body = document.querySelectorAll(".card-text");

    _card_body.forEach(function (e) {
      e.classList.remove("hide");
    });

    var _cat_box = document.querySelectorAll(".cat-box");

    _cat_box.forEach(function (el) {
      el.classList.remove("hide");
    });
  }
}

var full;
full = document.querySelector(".full");

if (full) {
  full.addEventListener("click", function () {
    full.classList.add("active");
    classic.classList.remove("active");
    toggle_card_body('full');
  });
}

var classic = document.querySelector(".classic");

if (classic) {
  classic.onclick = function () {
    classic.classList.add("active");
    full.classList.remove("active");
    toggle_card_body('classic');
  };
} //fire select chosen


function load_countries() {
  var req = new XMLHttpRequest();

  req.onload = function () {
    if (req.readyState == 4 && req.status == 200) {
      all_countries_select = document.querySelector(".all-countries");

      if (all_countries_select) {
        var results = JSON.parse(req.responseText);
        var _iteratorNormalCompletion = true;
        var _didIteratorError = false;
        var _iteratorError = undefined;

        try {
          for (var _iterator = results[Symbol.iterator](), _step; !(_iteratorNormalCompletion = (_step = _iterator.next()).done); _iteratorNormalCompletion = true) {
            var country = _step.value;
            var country_option = new Option();
            country_option.value = country['name'];
            country_option.text = country['name'];
            all_countries_select.add(country_option);
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
      }
    }
  };

  req.open("GET", "https://restcountries.eu/rest/v2/all");
  req.send();
}

load_countries();
$(document).ready(function () {
  $(".chosen-select").chosen({
    width: "100%",
    height: "30px"
  });
}); // click on select to select subcategory

var select_category = document.querySelector(".select-cat");

if (select_category) {
  select_category.onchange = function () {
    // let senddata = new URLSearchParams("CategoryId",select_category.value);
    var x = "";
    var senddata = new FormData();
    senddata.append("CategoryId", select_category.value);
    fetch("http://www.shop.com/admin/check_data/checkdata.php", {
      method: "POST",
      body: senddata
    }).then(function (response) {
      return response.json();
    }).then(function (data) {
      if (data != false) {
        var _iteratorNormalCompletion2 = true;
        var _didIteratorError2 = false;
        var _iteratorError2 = undefined;

        try {
          for (var _iterator2 = data[Symbol.iterator](), _step2; !(_iteratorNormalCompletion2 = (_step2 = _iterator2.next()).done); _iteratorNormalCompletion2 = true) {
            var cat = _step2.value;
            x += "<option value=\"".concat(cat['CategoryId'], "\"> ").concat(cat['CategoryName'], "</option>");
          }
        } catch (err) {
          _didIteratorError2 = true;
          _iteratorError2 = err;
        } finally {
          try {
            if (!_iteratorNormalCompletion2 && _iterator2["return"] != null) {
              _iterator2["return"]();
            }
          } finally {
            if (_didIteratorError2) {
              throw _iteratorError2;
            }
          }
        }

        var parent = document.querySelector(".parent-test");

        if (!document.querySelector(".test")) {
          parent.insertAdjacentHTML("afterend", " <div class=\"mb-3 col-md-6 test\">\n           <select class=\"form-select\" name=\"subCategoryId\">".concat(x, "</select></div>"));
        } else {
          var u = document.querySelector(".test");
          u.innerHTML = "";
          parent.insertAdjacentHTML("afterend", " <div class=\"mb-3 col-md-6 test\">\n            <select class=\"form-select\" name=\"subCategoryId\">".concat(x, "</select></div>"));
        }
      } else {
        if (document.querySelector(".test")) {
          var _u = document.querySelector(".test");

          _u.innerHTML = "";
        }
      }
    });
  };
} // create tags


var tagcontainer = document.querySelector(".tag-container"); // هعمل تاجس حسبب عدد العناصر الي هكتبها ف الانبةت

function createtags(label) {
  var tagdiv = document.createElement("div");
  tagdiv.classList.add("tag");
  var span = document.createElement("span");
  span.innerHTML = label;
  var i = document.createElement("i");
  i.classList.add("fas");
  i.classList.add("fa-times");
  i.classList.add("icon");
  i.setAttribute("data-value", label);
  tagdiv.appendChild(span);
  tagdiv.appendChild(i);
  return tagdiv; // هضيف التاج الجديد ف الاول مش ف الاخر
} // هعمل ارراي هحط فيها العناصر الي هضفها من الانبوت


var tags = [];
var taginput = document.querySelector(".tag-container input");
hiddeninput = document.querySelector("input[name=tags]"); //  علي حسبب العناصر الي في الاراي هعمل لوب وهضفهم عكسي

function addtags() {
  // هشيل كل التاجات الي انضافت الاول عشان هضيف حسب الاراي فقط
  document.querySelectorAll(".tag").forEach(function (e) {
    e.parentElement.removeChild(e);
  });
  tags.reverse().forEach(function (tag) {
    var alltagsdiv = createtags(tag);
    tagcontainer.prepend(alltagsdiv);
  });
  hiddeninput.value = tags.toString();
}

if (taginput) {
  taginput.addEventListener("keyup", function (e) {
    // لما اضغط ع المسافه 
    if (e.which === 32) {
      tags.push(taginput.value.trim());
      addtags();
      taginput.value = "";
    }
  });
}

document.addEventListener("click", function (e) {
  if (e.target.classList.contains("icon")) {
    var value = e.target.getAttribute("data-value");
    var index = tags.indexOf(value); //    tags.splice(index,-1)
    // console.log(index)
    // tags = tags.slice(index,index+1,1)
    // tags.splice(index,index)

    tags = [].concat(_toConsumableArray(tags.splice(0, index)), _toConsumableArray(tags.splice(index + 1)));
    addtags();
  }
});