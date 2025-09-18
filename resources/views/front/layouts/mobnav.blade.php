<div class="md:hidden mobile-menu opened" :class="{ 'opened': open }" x-data="{ open: false }">
    <button id="mob-menu-toggle" class="btn btn-toggle" @click="open = !open">
        <i data-feather="menu" stroke-width=2></i>
        <i data-feather="x" stroke-width=2></i>
    </button>
    <div class="mob-menu-frame flex flex-col">
        <div class="flex gap-2">
            <a class="btn px-3 bg-trans shadow-lg">
                <i data-feather="home"></i>
            </a>
            <div class="lang-switch relative z-[5]" x-data="{ open: false }">
                <button class="btn bg-trans shadow-lg" @click="open = !open">
                    <i data-feather="globe"></i>AZE
                </button>
                <div x-show="open" @click.outside="open = false"
            class="absolute mt-2 bg-white text-center rounded-full shadow-md">
                    <a href="#" class="block px-4 py-2 rounded-full">RUS</a>
                </div>
            </div>
        </div>
        

        <div class="mt-6 mb-auto grid grid-cols-2 gap-2 auto-rows-[90px]">
            @php
                $links = [
                    'Xidmətlər'=>[
                        'route'=>'services',
                        'icon'=>'grid',   
                    ],
                    'Həkimlər' => [
                        'route'=>'doctors',
                        'icon'=>'users',   
                    ],
                    'Haqqımızda' => [
                        'route' => 'about_us',
                        'icon' => 'info',   
                    ],
                    'Xəbərlər' => [
                        'route'=>null,
                        'icon'=>'radio',   
                    ]
                ];
            @endphp
            @foreach ($links as $title=>$detail)
            <a href="{{ $detail['route'] ? route($detail['route']) : '' }}" class="tile shadow-lg bg-trans py-3 px-4">
                <i class="absolute bottom-3 right-4 text-white-500 opacity-50" width=40 height=40 stroke-width=0.5 data-feather="{{ $detail['icon'] }}"></i>
                <span class="font-semibold">{{ $title }}</span>
            </a>
            @endforeach
            <a href="#" class="tile shadow-lg bg-brand text-white py-3 px-4 h-[60px]">
                <i class="absolute bottom-3 right-4" width=40 height=40 stroke-width=0.5 data-feather="file-text"></i>
                <span class="font-semibold">E-nəticə</span>
            </a>
        </div>

        <div class="grid grid-cols-1">
            <div class="grid gap-2 grid-cols-12 mb-2">
                <a href="tel:0555247839" class="col-span-6 py-3 btn !min-h-0 radius-x btn-green justify-center"><i data-feather="smartphone" stroke-width=2></i><span>Zəng et</span></a>
                <a href="tel:0186458060" class="col-span-3 py-3 btn !min-h-0 radius-x btn-green justify-center"><i data-feather="phone-call" stroke-width=2></i></a>
                <a href="#" target="_blank" class="col-span-3 py-3 btn !min-h-0 radius-x btn-adaptive justify-center" style="background: #128c7e !important;">
                    {{-- <i data-feather="message-circle" stroke-width=2></i> --}}
                    <svg class="h-6" xmlns="http://www.w3.org/2000/svg" shape-rendering="geometricPrecision" text-rendering="geometricPrecision" image-rendering="optimizeQuality" fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 509 511.514"><path fill="#fff" d="M434.762 74.334C387.553 26.81 323.245 0 256.236 0h-.768C115.795.001 2.121 113.696 2.121 253.456l.001.015a253.516 253.516 0 0033.942 126.671L0 511.514l134.373-35.269a253.416 253.416 0 00121.052 30.9h.003.053C395.472 507.145 509 393.616 509 253.626c0-67.225-26.742-131.727-74.252-179.237l.014-.055zM255.555 464.453c-37.753 0-74.861-10.22-107.293-29.479l-7.72-4.602-79.741 20.889 21.207-77.726-4.984-7.975c-21.147-33.606-32.415-72.584-32.415-112.308 0-116.371 94.372-210.743 210.741-210.743 56.011 0 109.758 22.307 149.277 61.98a210.93 210.93 0 0161.744 149.095c0 116.44-94.403 210.869-210.844 210.869h.028zm115.583-157.914c-6.363-3.202-37.474-18.472-43.243-20.593-5.769-2.121-10.01-3.202-14.315 3.203-4.305 6.404-16.373 20.593-20.063 24.855-3.69 4.263-7.401 4.815-13.679 1.612-6.278-3.202-26.786-9.883-50.899-31.472a192.748 192.748 0 01-35.411-43.867c-3.712-6.363-.404-9.777 2.82-12.873 3.224-3.096 6.363-7.381 9.48-11.092a41.58 41.58 0 006.357-10.597 11.678 11.678 0 00-.508-11.09c-1.718-3.18-14.444-34.357-19.534-47.06-5.09-12.703-10.37-10.603-14.272-10.901-3.902-.297-7.911-.19-12.089-.19a23.322 23.322 0 00-16.964 7.911c-5.707 6.298-22.1 21.673-22.1 52.849s22.671 61.249 25.852 65.532c3.182 4.284 44.663 68.227 108.288 95.649 15.099 6.489 26.891 10.392 36.053 13.403a87.504 87.504 0 0025.216 3.718c4.905 0 9.82-.416 14.65-1.237 12.174-1.782 37.453-15.291 42.776-30.073s5.303-27.57 3.711-30.093c-1.591-2.524-5.704-4.369-12.088-7.615l-.038.021z"/></svg>
                </a>
            </div>
            <a href="https://maps.app.goo.gl/pMisGExkSL8yZFq98" class="tile shadow-lg relative bg-trans p-3 pl-12">
                <i class="absolute top-3 left-4" stroke-width=2 data-feather="map-pin"></i>
                <span>Sumqayıt ş. S.Bədəlbəyli 42H</span>
            </a>
            <div class="tile mt-2 items-center p-2 px-4 bg-trans gap-3 shadow-lg">
                <i stroke-width=2 data-feather="share-2"></i> Bizi izləyin
                <div class="ml-auto socials flex gap-2">
                    <a href="#" class="p-1 rounded-full bg-trans">
                        <i data-feather="instagram"></i>
                    </a>
                    <a href="#" class="p-1 rounded-full bg-trans">
                        <i data-feather="facebook"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>