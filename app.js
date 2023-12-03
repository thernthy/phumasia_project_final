/*===== MENU SHOW =====*/ 
const showMenu = (toggleId, navId, ) =>{
    const toggle = document.getElementById(toggleId)
    const menu = document.querySelector('#nav-toggle')
    nav = document.getElementById(navId)

    if(toggle && nav){
        toggle.addEventListener('click', ()=>{
            nav.classList.toggle('show')
            menu.classList.toggle('is-active')
        })
    }
}
showMenu('nav-toggle','nav-menu',);


/*==================== REMOVE MENU MOBILE ====================*/
const navLink = document.querySelectorAll('.nav__link')

function linkAction(){
    const navMenu = document.getElementById('nav-menu')
    // When we click on each nav__link, we remove the show-menu class
    navMenu.classList.remove('show')
}
navLink.forEach(n => n.addEventListener('click', linkAction));


const myslide = document.querySelectorAll('.slide-imege'),
    dot = document.querySelectorAll('.dot');
let counter = 1;
slidefun(counter);
let timer = setInterval(autoslide, 8000);
function autoslide(){
    counter += 1;
    slidefun(counter);
}

function plusSlides(n) {
    counter += n;
    slidefun(counter);
    resetTimer();
}

function currentSlide(n) {
    counter = n;
    slidefun(counter);
    resetTimer();
}

function resetTimer(){
    clearInterval(timer)
    timer = setInterval(autoslide, 8000);
}

function slidefun(n){
    let i;
    for(i = 0;i<myslide.length;i++){
        myslide[i].style.display = "none"
    }
    for(i = 0;i<dot.length;i++){
        dot[i].classList.remove('active');
    }
    if(n > myslide.length){
        counter = 1;
    }
    if(n < 1){
        counter = myslide.length;
    }
    myslide[counter - 1].style.display = "block";
    dot[counter - 1].classList.add('active');
};

var click = document.querySelector('#howtoaccess')
function showaccess(){
    window.location.href('')
}




// time input
const display = document.getElementById('time')
function updateTime() {
    const date = new Date();
    const hour = formatTime(date.getHours());
    const minute = formatTime(date.getMinutes());
    const second = formatTime(date.getSeconds());
    display.innerText= hour + ':' + minute + ':' + second
}

function formatTime(time) {
    if ( time < 10 ) {
        return '0' + time;
    }
    return time;
}
setInterval(updateTime, 1000);



