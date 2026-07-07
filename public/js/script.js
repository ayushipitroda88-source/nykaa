let slides = document.querySelectorAll(".slide");
let current = 0;

function showSlide(index){
    slides.forEach(slide => slide.classList.remove("active"));
    slides[index].classList.add("active");
}

function nextSlide(){
    current = (current + 1) % slides.length;
    showSlide(current);
}

setInterval(nextSlide, 3000);