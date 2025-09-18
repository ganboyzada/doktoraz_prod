<header class="relative z-[10] mb-4 md:mb-6 flex items-center gap-3 px-5 lg:px-0">
    <a href="{{ route('home') }}" class="nav-logo flex items-center h-8 md:h-10 mr-auto">
        <img class="h-full" src="{{ asset('front/img/logo_c_light.svg') }}" alt="">
        <span class="hidden sm:inline sep vert"></span>
        <span class="hidden sm:inline">
            Tam güvənə <br>
            biləcəyiniz klinika
        </span>
    </a>
    <div class="relative inline-block lang-switch hidden md:inline" x-data="{ open: false }">
        <button class="btn btn-waterdrop" @click="open = !open">
            <i data-feather="globe"></i>AZE
        </button>
        <div x-show="open" @click.outside="open = false"
       class="absolute mt-2 w-full bg-white text-center rounded-full shadow-md">
            <a href="#" class="block px-4 py-2 rounded-full hover:bg-blue-700 hover:text-white">RUS</a>
        </div>
    </div>
    <div class="action-button hidden md:inline">
        <a href="" class="btn btn-primary font-light">
            <i data-feather="file-text"></i>E-Nəticə
        </a>
    </div>
    @include('front.layouts.mobnav')
</header>