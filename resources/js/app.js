import feather from 'feather-icons';

import Alpine from 'alpinejs'
window.Alpine = Alpine
Alpine.start()

import Swiper from 'swiper';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import { Navigation, Pagination, Grid } from 'swiper/modules';

// Replace all <i data-feather="icon-name"></i> with SVGs
document.addEventListener("DOMContentLoaded", () => {
    document.body.classList.add('animation-on');
  feather.replace({'stroke-width': 1});

    document.querySelectorAll('.browse-categ').forEach(button => {
        button.addEventListener('click', function () {
            // assume .browse-categ is directly inside .department (or adjust how many parentElement levels you need)
            const department = this.closest('.department'); 

            const siblings = department.parentElement.querySelectorAll('.department');
            siblings.forEach(sib => {
            if (sib !== department) {
                sib.classList.add('hidden'); // hide siblings only
            }
            });

            department.classList.add('active'); // keep clicked one active

            // get the data-id
            const id = this.dataset.id;
            console.log('Clicked department data-id:', id);
        });
    });

    // back-to-categs buttons
    document.querySelectorAll('.back-to-categs').forEach(button => {
        button.addEventListener('click', function () {
            const departments = document.querySelectorAll('.department');
            departments.forEach(dep => {
            dep.classList.remove('active', 'hidden');
            });
        });
    });

});

new Swiper('#home_slider', {
  modules: [Navigation, Pagination],
  loop: true,
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },
  pagination: {
    el: '.swiper-pagination',
    clickable: true,
  },
});

const swiper = new Swiper('#doc_slider', {
  modules: [Navigation, Pagination],
    spaceBetween: 10,                 // adjust gap if you like
    slidesPerView: 3.1,               // 3 full + ~10% of next on larger screens
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },

    breakpoints: {
      // mobile – 2 full slides + ~10% of the 3rd
      0:   { slidesPerView: 1.8 },
      640:   { slidesPerView: 2.4 },
      768:   { slidesPerView: 1.8 },
      // tablet & up – 3 full slides + ~10% of the 4th
      1024: { slidesPerView: 2.4 },
      1280: { slidesPerView: 1.7 },
      1536: { slidesPerView: 2.4 }
    }
  });

const swiper2 = new Swiper('#gallery_slider', {
  modules: [Navigation, Pagination, Grid],
    spaceBetween: 10,
    slidesPerView: 1.2, 
    grid: {
      rows: 1,
      fill: 'row'
    },
    navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },

    breakpoints: {
      // mobile – 2 full slides + ~10% of the 3rd
      768:   {
        slidesPerView: 1.2,
        grid: {
          rows: 3,
        },
      },
      // tablet & up – 3 full slides + ~10% of the 4th
      1024: {
        slidesPerView: 1.2,
        grid: {
          rows: 3,
        },
      },
      1280: {
        slidesPerView: 3,
        grid: {
          rows: 3,
        },
      }
    }
  });