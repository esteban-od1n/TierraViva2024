const sliders = document.querySelectorAll("[data-slider]")
sliders.forEach(slider => {
    const items = slider.querySelectorAll('[data-slider-item]')
    const prev = slider.querySelector('[data-prev-btn]')
    const next = slider.querySelector('[data-next-btn]')
    let currentPos = 0

    const goNext = () => {
        items[currentPos].classList.add('hidden')
        currentPos = (currentPos + 1) % items.length
        items[currentPos].classList.remove('hidden')
    }

    const goPrev = () => {
        items[currentPos].classList.add('hidden')
        currentPos--
        if (currentPos < 0) currentPos = items.length - 1
        items[currentPos].classList.remove('hidden')
    }

    items[currentPos].classList.remove('hidden')

    prev.addEventListener('click', _ => goPrev())
    next.addEventListener('click', _ => goNext())

    let autoSlide;
    autoSlide = setInterval(goNext, 7000)
})
