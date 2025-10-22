<footer class="flex items-center flex-col md:flex-row pt-4 pb-4 md:pb-3 mt-2 md:mt-1 text-sm">
    <div class="footer-logo flex items-center flex-wrap h-6 md:mr-auto">
        <img class="h-full" src="{{ asset('front/img/logo_light.svg') }}" alt="">
        <span class="hidden xl:inline sep vert"></span>
        <span  class="hidden xl:inline">© {{ \Carbon\Carbon::now()->year }} - {{ s_trans('Copyright') }}.</span>
    </div>
    <ul class="footer-links flex flex-wrap justify-center mt-3 md:mt-0 gap-3">
        <li><a href="{{ loc_route('services') }}" class="underline">{{s_trans('xidmetler-basliq')}}</a></li>
        <li><a href="{{ loc_route('doctors') }}" class="underline">{{ s_trans('hekimler-basliq')}}</a></li>
        <li><a href="{{ loc_route('news') }}" class="underline">{{s_trans('Xəbərlər')}}</a></li>
        <li class="ml-3"><a href="https://nexastudio.az" class="inline-flex gap-2 font-semibold items-center">Designed by <img src="{{ asset('inno/img/nexa_for_light.svg') }}" class="h-4" alt="nexa_logo"></a></li>
    </ul>
</footer>