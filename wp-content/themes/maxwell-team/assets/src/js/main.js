// document.addEventListener('DOMContentLoaded', function() {
    const toursSwiper = new Swiper('.tours-swiper', {
        slidesPerView: 1.5,  // 1.5 slajda na mobilnom
        spaceBetween: 16,
        centeredSlides: false,
        loop: true,
        grabCursor: true,
        
        // Pagination
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        
        // Navigation arrows
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        
        // Breakpoints
        breakpoints: {
            // When window width is >= 768px (tablet)
            768: {
                slidesPerView: 2,
                spaceBetween: 20,
            },
            // When window width is >= 1024px (desktop)
            1024: {
                slidesPerView: 4,  // 4 slajda na desktopu
                spaceBetween: 24,
            },
        }
    });
// });