
let open_nav_menu = document.querySelector(".open-nav");
let desktop_menu = document.querySelector(".desktop-menu");
let open_desktop_menu = document.querySelector(".desktop-menu.show");
let close_nav_menu = document.querySelector(".close-menu");
let overlay = document.querySelector(".overlay");

// start open submenu
let clicked_a = document.querySelectorAll(".menu-list > a");

clicked_a.forEach((e)=>
{
    e.addEventListener("click",(e)=>

    {

        if(e.target.parentElement.classList.contains("menu-has-children") && window.innerWidth < 900)
        {
            let menu_has_children = e.target.parentElement;
            // هقفل نفسي
            if(menu_has_children.classList.contains("active"))
            {
                collapse_expanded_submenu();
            }
            else
            {
                // هقفل الباقين
                if (document.querySelector(".menu-has-children.active"))
                {
                    collapse_expanded_submenu();
                }
                
                // لاول مره خالص مش عليا اكتف وعايز افتح السب منيو
            menu_has_children.classList.add("active");
            let submenu = menu_has_children.querySelector(".submenu");
            submenu.style.maxHeight = submenu.scrollHeight+"px";
            submenu.style.visibility  = "visible";
            submenu.style.opacity = "1";
            }


        
        }
    })
})
collapse_expanded_submenu
function collapse_expanded_submenu(){
    if(document.querySelector(".menu-has-children.active .submenu"))
    {
    document.querySelector(".menu-has-children.active .submenu")
    .removeAttribute("style");
    }

    if(document.querySelector(".menu-has-children.active"))
    {
         document.querySelector(".menu-has-children.active").classList.remove("active")
    }
   
    
}

// open desktop_menu when click on open_nav 
open_nav_menu.addEventListener("click",toggle_nav_menu)

//close desktopmenu 
close_nav_menu.addEventListener("click", toggle_nav_menu)
function toggle_nav_menu()
{
    desktop_menu.classList.toggle("show");
    overlay.classList.toggle("show");
    collapse_expanded_submenu();
}


document.addEventListener("click", function (e) { 
    if (e.target.className == "overlay show")
    {
        toggle_nav_menu();

    }
 })
function closenav()
{
    desktop_menu.classList.remove("show")
}
window.onresize =function()
{
    if(window.innerWidth > 900)
    {
        if (check_open_nav())
        {
            toggle_nav_menu();
        }
        collapse_expanded_submenu();

    }
    if (window.innerWidth < 900 && open_desktop_menu)
    {
        open_desktop_menu.style.width = "calc(100% - 80px)";
    }

}

function check_open_nav()
{
    if (desktop_menu.classList.contains("show"))
    {
        return true
    }

}

// form to add qty or decrease 
let increase_qty = document.querySelectorAll(".add-qty");
increase_qty.forEach((el)=>
{
    el.addEventListener("click",(btn)=>
    {
        btn.preventDefault();
       let input_item_qty = btn.target.nextElementSibling;
       input_item_qty.stepUp(1);
    })

})
let decrease_qty = document.querySelectorAll(".decrease-qty");
decrease_qty.forEach((el)=>
{
    el.addEventListener("click",(btn)=>
    {
        btn.preventDefault();
       let input_item_qty = btn.target.previousElementSibling;
       input_item_qty.stepDown(1);
    })

})

// fetch country api
let selectcountry = document.querySelector(".all-countries");

function fetch_countries()
{
    fetch("https://restcountries.eu/rest/v2/all")
    .then(resp=>
        {
            return data = resp.json();
        })
    .then(data=>
        {
            // for(let country of data)
            // {
            //     let option = new Option(country['name'],country['name']);
            //     selectcountry.appendChild(option);
            // }
            data.map(country=>
                {
                 let option = new Option(country['name'],country['name']);
                selectcountry.appendChild(option);
                })
        }) 
    .catch(err=>
        {
            console.log(err)
        })       
}
if(selectcountry)
{
    fetch_countries();
}



let input_item_name = document.querySelector('.check-item-exists');
let myform = document.querySelector(".theform")
if(input_item_name)
{
    input_item_name.addEventListener("blur",()=>
{
    // let formdata = new FormData();
    // formdata.append('itemName',input_item_name.value);

    let itemname = new URLSearchParams(`itemName=${input_item_name.value}`);
    fetch("http://www.shop.com/admin/check_data/checkdata.php",
    {
        method: 'POST',
        body:itemname
    })
    .then(resp=>
        {
         return answer = resp.text();
        })
    .then(answer=>
        {
           
           if(answer == 'yes')
           {
            if(document.querySelector('.exists-value'))
            {
                document.querySelector(".exists-value").remove();
            }
            let pp =document.createElement("p");
            pp.classList.add("alert");
            pp.classList.add("exists-value");
            pp.classList.add("alert-danger");
            let ptext = document.createTextNode( `soory this item is exists `);
            pp.appendChild(ptext);
            input_item_name.parentElement.appendChild(pp);
            document.querySelector(".submit").classList.add("disabled");

           }
           else if(answer == 'no')
           {
            if(document.querySelector('.exists-value'))
            {
                document.querySelector(".exists-value").remove();
            }
            document.querySelector(".submit").classList.remove("disabled");
           }
        })    


})
}

// let sub = document.querySelector(".submit");
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
let itemname = document.querySelector(".item-info .it-name");
let itemndesc = document.querySelector(".item-info .it-desc");
let itemprice = document.querySelector(".item-info .it-price");
let itemrating = document.querySelector(".item-rating");



function livepreview(el)
{
    if(el)
    {
        el.addEventListener("keyup",()=>
        {
        document.querySelector(el.getAttribute('data-name')).innerHTML = el.value;
        })
    }
}

livepreview(input_item_name);
// console.log(document.querySelector('input[data-name=".it-desc"'))
livepreview(document.querySelector('[data-name=".it-desc"'))
livepreview(document.querySelector('[data-name=".it-price"'))

let selector_ratings = document.querySelector("select[name='itemRating']");
if(selector_ratings)
{
    selector_ratings.addEventListener("change",()=>
{
    itemrating.innerHTML = "";
   let x = selector_ratings.value;
   for(let i= 0 ; i < x; i++)
   { 
        let span= document.createElement("span");
        let istar= document.createElement("i");

        istar.classList.add("fas");
        istar.classList.add("fa-star");
        istar.classList.add("start-chekced");
        span.appendChild(istar);
        itemrating.appendChild(span)

       }

       for(let y = 0 ; y < 5 - x ; y++)
       { 
        let span= document.createElement("span");
        let istar= document.createElement("i");
        istar.classList.add("fas");
        istar.classList.add("fa-star");
        span.appendChild(istar);
        itemrating.appendChild(span)
    }
      
})
}




