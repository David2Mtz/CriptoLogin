var swiper = new Swiper(".mySwiper", {
  slidesPerView: 3, // Número de tarjetas visibles en pantallas grandes
  spaceBetween: 50, // Espacio entre tarjetas
  navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
  },
  breakpoints: {
      // Configuración para pantallas pequeñas
      0: { // Móviles pequeños
          slidesPerView: 1,
          spaceBetween: 10,
      },
      576: { // Tabletas
          slidesPerView: 2,
          spaceBetween: 20,
      },
      768: { // Pantallas medianas en adelante
          slidesPerView: 3,
          spaceBetween: 30,
      }
  }
});