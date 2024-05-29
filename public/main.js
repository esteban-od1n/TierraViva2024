'use strict';

/** Preaload */
const preloader = document.querySelector("[data-preaload]");

window.addEventListener("load", function() {
    preloader.classList.add("loaded");
    document.body.classList.add("loaded");
});

const addEventOnElements = function(elements, eventType, callback) {
    for (let i = 0, len = elements.length; i < len; i++) {
        elements[i].addEventListener(eventType, callback);
    }
}


/** Navbar */

const navbar = document.querySelector("[data-navbar]");
const navTogglers = document.querySelectorAll("[data-nav-toggler]");
const overlay = document.querySelector("[data-overlay]");

const toggleNavbar = function() {
    navbar.classList.toggle("active");
    overlay.classList.toggle("active");
    document.body.classList.toggle("nav-active");
}

addEventOnElements(navTogglers, "click", toggleNavbar);


/** Header */

const header = document.querySelector("[data-header]");
const backTopBtn = document.querySelector("[data-back-top-btn]");

let lastScrollPos = 0;

const hideHeader = function() {
    const isScrollBottom = lastScrollPos < window.scrollY;
    if (isScrollBottom) {
        header.classList.add("hide");
    } else {
        header.classList.remove("hide");
    }
    lastScrollPos = window.scrollY;
}

window.addEventListener("scroll", function() {
    if (window.scrollY >= 50) {
        header.classList.add("active");
        backTopBtn.classList.add("active");
        hideHeader();
    } else {
        header.classList.remove("active");
        backTopBtn.classList.remove("active");
    }
});

/** Slider */
const slideSlider = document.querySelector("[data-slide-slider]");
const slideSliderItems = document.querySelectorAll("[data-slide-slider-item]");
const slideSliderPrevBtn = document.querySelector("[data-prev-btn]");
const slideSliderNextBtn = document.querySelector("[data-next-btn]");

let currentSliderPos = 0;
let lastActiveSliderItem = slideSliderItems[0];

const updateSliderPost = function() {
    lastActiveSliderItem.classList.remove("active");
    slideSliderItems[currentSliderPos].classList.add("active");
    lastActiveSliderItem = slideSliderItems[currentSliderPos];
}

const slideNext = function() {
    if (currentSliderPos >= slideSliderItems.length - 1) {
        currentSliderPos = 0;
    } else {
        currentSliderPos++;
    }
    updateSliderPost();
}

slideSliderNextBtn.addEventListener("click", slideNext);

const slidePrev = function() {
    if (currentSliderPos <= 0) {
        currentSliderPos = slideSliderItems.length - 1;
    } else {
        currentSliderPos--;
    }
    updateSliderPost();
}

slideSliderPrevBtn.addEventListener("click", slidePrev);

/*auto slide*/

let autoSlideInterval;
const autoSlide = function() {
    autoSlideInterval = setInterval(function() {
        slideNext();
    }, 7000);
}

addEventOnElements([slideSliderNextBtn, slideSliderPrevBtn], "mouseover", function() {
    clearInterval(autoSlideInterval);
});

addEventOnElements([slideSliderNextBtn, slideSliderPrevBtn], "mouseout", autoSlide);

window.addEventListener("load", autoSlide);
