import $, { ready } from 'jquery';
// import AOS from 'aos';
// import 'aos/dist/aos.css';
import Splide from '@splidejs/splide';
import WOW from 'wow.js/dist/wow.js';
import 'animate.css/animate.min.css';
import Swal from 'sweetalert2';

window.Swal = Swal;
window.Splide = Splide;

new WOW().init();

// AOS.init({
//     mirror: true,
//     duration: 750,
// });
window.$ = $;

var elms = document.getElementsByClassName( 'product-img-slider' );

for ( var i = 0; i < elms.length; i++ ) {
  new Splide( elms[ i ], {
    perPage : 1,
    height  : '10rem',
    center: true,
    lazyLoad: 'nearby',
    breakpoints: {
      height: '6rem',
    },
  }).mount();
}

$('.circle').on('click', function(){
    $(this).attr('data-circle', '1');
    let index = 2;
    $(this).siblings().each(function(){
        $(this).attr('data-circle', String(index));
        index++;
    })
});

$('.toggler').on('click', function(){
    let target = $(this).data('toggle');
    let container = $(target).toggleClass('toggled');
});

$(document).ready(function(){
    console.log('workssss');
    $('.footer-right span.copyright-text').append(`- <a href="innosoft.az">Made with care by <img class="mt-1 ms-1" src="https://innosoft.az/front/img/inno_logo_b.png" height="20" alt=""></a>`);
});