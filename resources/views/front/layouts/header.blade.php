<header class="relative z-[10] mb-4 md:mb-6 flex items-center gap-3 px-5 md:px-0">
    <a href="{{ loc_route('home') }}" class="nav-logo flex items-center h-8 md:h-10 mr-auto">
        <img class="h-full" src="{{ asset('front/img/logo_c_light.svg') }}" alt="">
        <span class="hidden sm:inline sep vert"></span>
        <span class="hidden sm:inline">
            Tam güvənə <br>
            biləcəyiniz klinika
        </span>
    </a>
    <div class="relative inline-block lang-switch hidden lg:inline" x-data="{ open: false }">
        <button class="btn btn-waterdrop uppercase" @click="open = !open">
            <i data-feather="globe"></i>{{ app()->getLocale() }}
        </button>
        <div x-show="open" @click.outside="open = false"
       class="absolute mt-2 bg-white text-center radius-x shadow-md">
            @foreach ($languages as $lang)
                @if($lang->code != app()->getLocale())
                <a href="{{ route('langswitch', $lang->code) }}" class="capitalize block px-4 py-2 rounded-full hover:bg-blue-700 hover:text-white">{{ $lang->title }}</a>
                @endif
            @endforeach
        </div>
    </div>
    <div class="action-button hidden lg:inline">
        <a href="" class="btn btn-primary font-light">
            <i data-feather="file-text"></i>E-Nəticə
        </a>
    </div>
    @include('front.layouts.mobnav')
</header>