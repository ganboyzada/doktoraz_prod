<header class="relative z-[999] mb-4 md:mb-6 flex items-center gap-3 px-5 md:px-0">
    <a href="{{ loc_route('home') }}" class="nav-logo flex items-center h-8 md:h-10 mr-auto">
        <img class="h-full" src="{{ asset('front/img/logo_c_light.svg') }}" alt="">
        <span class="hidden sm:inline sep vert"></span>
        <div class="hidden sm:inline">
            {!! s_trans('Sloqan', true) !!}
        </div>
    </a>
    <div class="relative inline-block lang-switch hidden lg:inline" x-data="{ open: false }">
        <button class="btn btn-waterdrop uppercase font-medium" @click="open = !open">
            <i data-feather="globe"></i>{{ app()->getLocale() }}
        </button>
        <div x-show="open" @click.outside="open = false"
       class="absolute mt-2 bg-white text-center radius-x shadow-md">
            @foreach (config('app.available_locales') as $lang)
                @if($lang != app()->getLocale())
                <a href="{{ route('langswitch', $lang) }}" class="capitalize block px-4 py-2 rounded-full hover:bg-blue-700 hover:text-white">{{ $lang }}</a>
                @endif
            @endforeach
        </div>
    </div>
    {{-- <div class="action-button hidden lg:inline">
        <a href="" class="btn btn-primary font-light">
            <i data-feather="file-text"></i>E-Nəticə
        </a>
    </div> --}}
    <div class="action-button hidden lg:inline">
        <a href="{{ loc_route('news') }}" class="btn btn-waterdrop font-medium">
            <i data-feather="bell"></i>{{s_trans('Yeniliklər')}}
        </a>
    </div>
    <div class="action-button hidden lg:inline">
        <a href="{{ loc_route('about_us') }}" class="btn btn-primary font-medium">
            <i data-feather="info"></i>{{s_trans('Haqqımızda')}}
        </a>
    </div>
    @include('front.layouts.mobnav')
</header>