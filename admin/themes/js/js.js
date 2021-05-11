// active class on navbar

let alllinks = document.querySelectorAll(".nav-item a");
let url = window.location.href;
alllinks.forEach((e)=>
{

        e.addEventListener("click",function()
        {
            removeactivelinks();
            e.classList.add("active")
           
        })
})

// remove active on llinks function


function removeactivelinks()
{
    let alllinks = document.querySelectorAll(".nav-item a");
    alllinks.forEach((E)=>
    {
        E.classList.remove("active");
    })  
}




/*
*  function expect 5 parameter
## el = element when bluer this el is input
## passedvalue = the value i will check on it
## error_message = the messeage wehen error exists
## userid = only when check on edit  
*/
check_if_exists('check-exists-category',"http://www.shop.com/admin/check_data/checkdata.php","CategoryName","Category name is exists");
check_if_exists('check-edit-category',"http://www.shop.com/admin/check_data/checkdata.php","CategoryName","Category name is exists",window.location.search);
check_if_exists('check-exists-user',"http://www.shop.com/admin/check_data/checkdata.php","UserName","UserName  is exists");
check_if_exists('check-edit-username',"http://www.shop.com/admin/check_data/checkdata.php","UserName","user name is exists",window.location.search);
check_if_exists('check-email',"http://www.shop.com/admin/check_data/checkdata.php","Email","Email  is exists");
check_if_exists('check-edit-email',"http://www.shop.com/admin/check_data/checkdata.php","Email","Email  is exists",window.location.search)
check_if_exists('checkoldpassword',"http://www.shop.com/admin/check_data/checkdata.php","Password","Password  is exists",window.location.search)
function check_if_exists(el ,url,passed_value,error_message,Id= null)
{
        if(document.querySelector(`.${el}`))
        {
            var exists_el =document.querySelector(`.${el}`);
            
            exists_el.addEventListener("blur",()=>
            {

                if(exists_el.value != "")
                {
                    var req = new XMLHttpRequest();
                    req.onload =function()
                    {
                        if(req.readyState == 4 && req.status == 200)
                        {
                        if(req.responseText == "yes")
                        {
                                if(document.querySelector('.exists-value'))
                                {
                                    document.querySelector(".exists-value").remove();
                                }
                                let pp =document.createElement("p");
                                pp.classList.add("alert");
                                pp.classList.add("exists-value");
                                pp.classList.add("alert-danger");
                                let ptext = document.createTextNode( `soory this ${error_message} `);
                                pp.appendChild(ptext);
                                exists_el.parentElement.appendChild(pp);
                                document.querySelector(".submit").classList.add("disabled");
                        } 
                        else
                        {
                            if(document.querySelector('.exists-value'))
                            {
                                document.querySelector(".exists-value").remove();
                            }
                            document.querySelector(".submit").classList.remove("disabled");
            
                        }                 
            
                        }
                    }  
                if(Id != null) 
                {
                    Id = Id.replace("?","");
                }   
                req.open("POST",url);
                req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                req.send(`${passed_value}=${exists_el.value}&${Id}`);              
                }
                else
                {
                    if(document.querySelector('.exists-value'))
                    {
                        document.querySelector(".exists-value").remove();
                    }
                }
            })
        
        }
        
}

// check confirm password on blur
let confirmpassword = document.querySelector("input[name=ConfirmPassword]");
    if(confirmpassword)
    {
        confirmpassword.addEventListener("blur",()=>
        {
            let confirmpasswordvalue = confirmpassword.value;
            let password= document.querySelector("input[name=Password]");
            let passwordvalue = password.value;
            if(confirmpasswordvalue == "" || (passwordvalue != confirmpasswordvalue))
            {
                if(document.querySelector('.notmatchedpassword'))
                {
                    document.querySelector(".notmatchedpassword").remove();
                }
            // document.querySelector(".submit").classList.remove("disabled");
                let pp =document.createElement("p");
                pp.classList.add("alert");
                pp.classList.add("notmatchedpassword");
                pp.classList.add("alert-danger");
                let ptext;
                if(confirmpasswordvalue == "")
                {
                     ptext = document.createTextNode( ' soory confirm password must not empty ');
                }
                else
                {
                     ptext = document.createTextNode( ' soory confirm not matched password ');
                }
                pp.appendChild(ptext);
                document.querySelector(".confirmdiv").appendChild(pp);
                document.querySelector(".submit").classList.add("disabled");
            }
            else
            {
             if(document.querySelector('.notmatchedpassword'))
            {
                document.querySelector(".notmatchedpassword").remove();
            }
            document.querySelector(".submit").classList.remove("disabled");
            }

             
        })
    }

    // form input add strix

   let inputwithreqiured=  document.querySelectorAll("input[required]");
   inputwithreqiured.forEach((inp)=>
   {
       let inputparent = inp.parentElement;

       inputparent.style.position ="relative";
            let i = document.createElement("i");
            i.classList.add("fas");
            i.classList.add("fa-star");
            i.classList.add("star-required");
            inputparent.appendChild(i);
        inp.addEventListener("focus",()=>
        {
            inp.parentElement.querySelector(".star-required").style.opacity ="0"
        })   

            inp.addEventListener("blur",()=>
            {
                if(inp.value == "")
                {
                 inp.parentElement.querySelector(".star-required").style.opacity ="1"                   
                }
                else
                {
                    inp.parentElement.querySelector(".star-required").style.opacity ="0"  
                }

            })
   })
    

   //toogle category bodu when click on titile
   let card_title = document.querySelectorAll(".card-title");

   card_title.forEach((e)=>
   {
       e.addEventListener("click",(el)=>
       {
           el.target.nextElementSibling.classList.toggle("hide")
            el.target.parentElement.querySelector('.cat-box').classList.toggle("hide")     

       
       })
   })

   


//    document.querySelector(".full-view").addEventListener("click",toggle_card_body('full-view'));
//    document.querySelector(".classic-view").addEventListener("click",toggle_card_body('classic'));

   function toggle_card_body(data_view)
   {
        if(data_view == 'classic')
        {
        let card_body = document.querySelectorAll(".card-text");
        card_body.forEach((e)=>
        {  
                    e.classList.add("hide")  
            })    
        let cat_box = document.querySelectorAll(".cat-box"); 
        cat_box.forEach((el)=>
        {
            el.classList.add("hide")    
        
        })               
        }
        if(data_view == 'full')
        {
        let card_body = document.querySelectorAll(".card-text");
        card_body.forEach((e)=>
        {  
                    e.classList.remove("hide")  
            })    
        let cat_box = document.querySelectorAll(".cat-box"); 
        cat_box.forEach((el)=>
        {
            el.classList.remove("hide")    
        
        })               
        }
   }
   let full;
    full = document.querySelector(".full");
   if(full )
   {
   full.addEventListener("click", function(){
      
    full.classList.add("active")
    classic.classList.remove("active")
    
    toggle_card_body('full')
   });

   }

   let classic = document.querySelector(".classic");
   if(classic)
   {
   classic.onclick = function()
   {
    classic.classList.add("active")
    full.classList.remove("active")
    toggle_card_body('classic')
   }       
   }


   //fire select chosen

function load_countries()
{
    let req = new XMLHttpRequest();
    req.onload = function()
    {
        if(req.readyState == 4 && req.status == 200)
        {
            all_countries_select = document.querySelector(".all-countries");    
            if(all_countries_select)
            {
                let results = JSON.parse(req.responseText) 
                for(let country of results)
                {
                    let country_option = new Option();
                    country_option.value = country['name'];
                    country_option.text = country['name'];
                    all_countries_select.add(country_option)
                }
            }
            
        }

    }
    req.open("GET","https://restcountries.eu/rest/v2/all");
    req.send();
}
load_countries()

$(document).ready(function()
{
    $(".chosen-select").chosen({
        width: "100%",
        height: "30px"
    }); 
    

   
})

// click on select to select subcategory
let select_category = document.querySelector(".select-cat");


if(select_category)
{
    select_category.onchange =function()
{
    // let senddata = new URLSearchParams("CategoryId",select_category.value);
    let x ="";
    let senddata = new FormData();
    senddata.append("CategoryId",select_category.value)
    fetch("http://www.shop.com/admin/check_data/checkdata.php",
    {
        method: "POST",
        body: senddata
    })
    .then(response=> response.json())
    .then(data=>
    {

        if(data != false)
        {
           for(let cat of data)
           {
               x +=`<option value="${cat['CategoryId']}"> ${cat['CategoryName']}</option>`;
           }
          let parent = document.querySelector(".parent-test");
          if(! document.querySelector(".test"))
          {
            parent.insertAdjacentHTML("afterend",` <div class="mb-3 col-md-6 test">
           <select class="form-select" name="subCategoryId">${x}</select></div>`)
          }
          else
          {
            let u = document.querySelector(".test");
            u.innerHTML = "";  
            parent.insertAdjacentHTML("afterend",` <div class="mb-3 col-md-6 test">
            <select class="form-select" name="subCategoryId">${x}</select></div>`)
          }

        }
        else
        {
            if(document.querySelector(".test"))
            {
                let u = document.querySelector(".test");
                u.innerHTML = ""; 
            }
        }
      
    })
}
}

// create tags

let tagcontainer = document.querySelector(".tag-container");

// هعمل تاجس حسبب عدد العناصر الي هكتبها ف الانبةت
function createtags(label)
{
    let tagdiv = document.createElement("div");
    tagdiv.classList.add("tag");
    let span = document.createElement("span");
    span.innerHTML = label;
    let i = document.createElement("i");
    i.classList.add("fas");
    i.classList.add("fa-times");
    i.classList.add("icon");
    i.setAttribute("data-value",label)
    tagdiv.appendChild(span);
    tagdiv.appendChild(i);
    return tagdiv;
    // هضيف التاج الجديد ف الاول مش ف الاخر
}

// هعمل ارراي هحط فيها العناصر الي هضفها من الانبوت
let tags = [];
let taginput = document.querySelector(".tag-container input");
hiddeninput = document.querySelector("input[name=tags]");
//  علي حسبب العناصر الي في الاراي هعمل لوب وهضفهم عكسي
function addtags()
{
    // هشيل كل التاجات الي انضافت الاول عشان هضيف حسب الاراي فقط
    document.querySelectorAll(".tag").forEach((e)=>
    {
        e.parentElement.removeChild(e)
    })
    tags.reverse().forEach((tag)=>
    {

        let alltagsdiv = createtags(tag);
        tagcontainer.prepend(alltagsdiv);
    })
    hiddeninput.value = tags.toString();
}

if(taginput)
{
    taginput.addEventListener("keyup",(e)=>
{
    // لما اضغط ع المسافه 
   if(e.which === 32)
   {
    tags.push(taginput.value.trim());
    addtags();
    taginput.value =""
   }

})
}

document.addEventListener("click",(e)=>
{
    if(e.target.classList.contains("icon"))
    {
       let value = e.target.getAttribute("data-value");
       let index = tags.indexOf(value);
    //    tags.splice(index,-1)
        // console.log(index)
        // tags = tags.slice(index,index+1,1)
        // tags.splice(index,index)
        tags = [...tags.splice(0,index),...tags.splice(index+1)];

        addtags();

    }
})








