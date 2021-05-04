//start get local storage
let interval;
let backgroundchange;
if(localStorage.getItem("color-option") != null)
{
    document.documentElement.style.setProperty("--second-main-color",localStorage.getItem("color-option"));
    document.querySelectorAll(".color-menu li")
    .forEach(element => {
        if(element.dataset.color == localStorage.getItem("color-option"))
        {
            element.classList.add("active")
        }
    });
}
else
{
    document.querySelector(".color-menu li:first-child").classList.add("active")
}
// change background
if(localStorage.getItem("change-background") != null)
{
   
    if((localStorage.getItem("change-background") == "yes"))
    {
        backgroundchange ="true";
        changeimages();
      
    }
    else
    {
        backgroundchange ="false";
        clearInterval(interval);
        
    }
    document.querySelectorAll(".yes-no span")
    .forEach(element => {
        if(element.dataset.change == localStorage.getItem("change-background"))
        {
            element.classList.add("active")
        }
    });
}
else
{
    document.querySelector(".yes-no span:first-child").classList.add("active")
}

// image chaoosen

if(localStorage.getItem("image-choosen") !=null)
{
    document.querySelector(".header").style.backgroundImage = `url(/pharmacy/themes/images/${localStorage.getItem("image-choosen")}`;
    document.querySelectorAll(".background-iamges img")
    .forEach(element => {
        if(element.dataset.image == localStorage.getItem("image-choosen"))
        {
            element.classList.add("active")
        }
    });
}
else
{
    document.querySelector(".background-iamges img:nth-child(4").classList.add("active")
}

// 

// show hide bullts
if(localStorage.getItem("show-hide-bullets") != null)
{
   
    if((localStorage.getItem("show-hide-bullets") == "show"))
    {
        document.querySelector(".bullets-scroll").style.display = "flex";
      
    }
    else
    {
 
        document.querySelector(".bullets-scroll").style.display = "none";
    }
    document.querySelectorAll(".show-hide-bullets span")
    .forEach(element => {
        if(element.dataset.showscrol == localStorage.getItem("show-hide-bullets"))
        {
            element.classList.add("active")
        }
    });
}
else
{
    document.querySelector(".show-hide-bullets span:first-child").classList.add("active")
}



// add active on all links on nav

let alllinks = document.querySelectorAll(".nav-list a");

alllinks.forEach((e)=>
{
    e.addEventListener('click',()=>
        {
          
            removeactive(alllinks)
            e.classList.add("active");
        }
    )
}
)

//function remove active

function removeactive(el)
{
    el.forEach((e)=>
    {
        e.classList.remove("active");
    })
}

// add random image

function changeimages()
{
    interval = setInterval(()=>
    {
        let images = [
            "1.jpg",
            "2.jpg",
            "3.jpg",
            "4.jpg",
            "5.jpg",
        ];
        randomindex = Math.floor(Math.random() * images.length);
        document.querySelector(".header").style.backgroundImage = `url(/pharmacy/themes/images/${images[randomindex]}`;
    }, 10000);
}


//

if(backgroundchange == true)
{
    changeimages() 
}
if(backgroundchange == false)
{
    clearInterval(interval);
}


// toggle settigns

let settings = document.querySelector(".settings");
let open_settings = document.querySelector(".toggle-settings");
open_settings.addEventListener("click",opensettings)
function opensettings()
{
    document.querySelector(".settings").classList.toggle("show");
}
settings.addEventListener("click",function(e)
{
    e.stopPropagation();
})

document.addEventListener("click",(e)=>
    {
        if(e.target != settings)
        {
           if(settings.classList.contains("show"))
           {
            opensettings()
           }
        }
    }
)
// 
let allcolorli = document.querySelectorAll(".color-menu li");
allcolorli.forEach((e)=>
{
    e.addEventListener("click",(el)=>
    {
        document.documentElement.style.setProperty("--second-main-color",el.target.getAttribute("data-color"));
        localStorage.setItem("color-option",el.target.getAttribute("data-color"));
        removeactive(allcolorli);
        el.target.classList.add("active")
    })
})

// stop start change color

let yes = document.querySelector(".yes");
let no= document.querySelector(".no");

let start_stop_change_background = document.querySelectorAll(".start-stop-background span");
start_stop_change_background.forEach((el)=>
{
  
    el.addEventListener("click",(e)=>
    {
        removeactive(start_stop_change_background);
    if(e.target.classList.contains("yes"))
    {
        
        localStorage.setItem("change-background",e.target.getAttribute("data-change"));
        backgroundchange = true;
        changeimages();
        e.target.classList.add("active")
       
    }
    if(e.target.classList.contains("no"))
    {
        backgroundchange = false;
        localStorage.setItem("change-background",e.target.getAttribute("data-change"));
        clearInterval(interval)
        e.target.classList.add("active")
       
    }
})
})
// show hide bullets
let show_hide_bullets_spans = document.querySelectorAll(".show-hide-bullets span");
show_hide_bullets_spans.forEach((el)=>
{
  
    el.addEventListener("click",(e)=>
    {
        removeactive(show_hide_bullets_spans);
    if(e.target.classList.contains("yes"))
    {
        
        localStorage.setItem("show-hide-bullets",e.target.getAttribute("data-showscrol"));
        e.target.classList.add("active");
        document.querySelector(".bullets-scroll").style.display = "flex";
     
       
    }
    if(e.target.classList.contains("no"))
    {
        backgroundchange = false;
        localStorage.setItem("show-hide-bullets",e.target.getAttribute("data-showscrol"));
        e.target.classList.add("active");
        document.querySelector(".bullets-scroll").style.display = "none";
       
    }
})
})



// change background
let allimagestochanfed =document.querySelectorAll(".background-iamges img");
allimagestochanfed.forEach((e)=>
{
    e.addEventListener("click",(el)=>
    {
        removeactive(allimagestochanfed);
        document.querySelector(".header").style.backgroundImage = `url(/pharmacy/themes/images/${el.target.getAttribute("data-image")}`;
        localStorage.setItem("image-choosen",el.target.getAttribute("data-image"))
        el.target.classList.add("active")

    })
})
// start bullets
let bullets_scroll = document.querySelectorAll(".bullets-scroll >div");
bullets_scroll.forEach((e)=>
{
    e.addEventListener("click",()=>
    {
        let elm = document.querySelector(`#${e.dataset.scroll}`);
        // let elm_offsetfTop = elm.offsetTop;
        // let elm_outerheight = elm.offsetHeight;
        // let wheight = window.innerHeight;
        // let net_offset = elm_offsetfTop + elm_outerheight - wheight;

        // console.log(net_offset)
        // window.scrollTo(0,net_offset)
        // window.scrollTo(0,elm_offsetfTop)
        elm.scrollIntoView(
            {
                behavior: 'smooth'
            }
        )
    })
})

//  scroll down

document.querySelector(".go-down").addEventListener("click",()=>
{

    let aboutus = document.querySelector(".about-us");
    let aboutus_offsettop = aboutus.offsetTop;
    let aboutus_ouerheight =  aboutus.offsetHeight;
    let windowheight = window.innerHeight;
    window.scrollTo(0, aboutus_offsettop);
})

// window.addEventListener("scroll",()=>
// {
//     let aboutus = document.querySelector(".about-us");
//     let aboutus_offsettop = aboutus.offsetTop;
//     let aboutus_ouerheight =  aboutus.offsetHeight;
//     let windowheight = window.innerHeight;
//     console.log(aboutus_offsettop)
// })

let gallery_images = document.querySelectorAll(".gallery-box img");
gallery_images.forEach((img)=>
{
    img.addEventListener("click",(e)=>
    {
        let gallery_overlay = document.createElement("div");
        gallery_overlay.className = "gallery-overlay";
        document.body.appendChild(gallery_overlay);

        let popup_gallery = document.createElement("div");
        popup_gallery.className = "pop-gallery";

        let popup_gallery_span = document.createElement("span");
        popup_gallery_span.className = "pop-gallery-span";
        let span_close = document.createTextNode("x");
        popup_gallery_span.appendChild(span_close);
        popup_gallery.appendChild(popup_gallery_span);

        let popup_gallery_img = document.createElement("img");
        popup_gallery_img.className = "pop-gallery-img";
        popup_gallery_img.src = e.target.src;
        popup_gallery.appendChild(popup_gallery_img);
        
        document.body.appendChild(popup_gallery);

    })
})

document.addEventListener("click",(e)=>
{
    if(e.target.classList.contains("pop-gallery-span"))
    { // e.target.parentElement.remove();
            e.target.parentElement.remove();
            document.querySelector(".gallery-overlay").remove();
  
    }
    else if(e.target.classList.contains("gallery-overlay"))
    { // e.target.parentElement.remove();
         
            document.querySelector(".gallery-overlay").remove();
            document.querySelector(".pop-gallery").remove();
  
    }
})

// toggle nav

let toggle_nav = document.querySelector(".toggle-nav");
let nav_menu  =document.querySelector(".nav-menu");
toggle_nav.addEventListener("click",()=>
{
    document.querySelector(".nav-menu").classList.toggle("show");
    toggle_nav.classList.toggle("active");
})

let mediaquery = 992;

window.addEventListener("resize",()=>
{
    if(window.innerWidth >= mediaquery)
    {
        if(nav_menu.classList.contains("show"))
        {
            document.querySelector(".nav-menu").classList.remove("show");
            toggle_nav.classList.remove("active");
        }
    }
})

nav_menu.addEventListener("click",(e)=>
{
    e.stopPropagation();
})
toggle_nav.addEventListener("click",(e)=>
{
    e.stopPropagation();
})
document.addEventListener("click",(e)=>
{
    if(e.target != nav_menu && e.target != toggle_nav)
    {
        if(nav_menu.classList.contains("show"))
        {
            document.querySelector(".nav-menu").classList.remove("show");
            toggle_nav.classList.remove("active");

        }

    }
})

