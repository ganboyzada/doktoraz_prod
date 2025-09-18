<div class="inno-mob-nav container-fluid" id="mobile-nav">
    
    <div class="dropdown lang-switch">
        <button class="btn btn-sec rounded-pill dropdown-toggle" type="button" id="triggerId"
            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="bi bi-globe me-2"></i>
            {{ strtoupper(app()->getLocale()) }}
        </button>
        @if(count($languages)>1)
        <div class="dropdown-menu" aria-labelledby="triggerId">
            @foreach ($languages as $lang)
                @if($lang->code != app()->getLocale())
                <a class="dropdown-item" href="{{ route('langswitch', $lang->code) }}">
                    {{ strtoupper($lang->title) }}
                </a>
                @endif
            @endforeach 
        </div>
        @endif
    </div>
    
    <button class="btn toggler" data-toggle="#mobile-nav"><i class="bi bi-x-lg"></i></button>
    <nav>
        <ul class="row row-cols-2 g-3">
            @if($settings['store']->status)
            <li><a href="{{ route('store') }}">
                {{ s_trans('Store') }}
                <span>
                    <i class="bi bi-cart"></i>
                </span>
            </a></li>
            @endif

            <li><a href="{{ request()->routeIs('home') ? '#section_about' : route('home') . '#section_about' }}" class="toggler" data-toggle="#mobile-nav">{{ s_trans('About us') }}
                <span>
                    <i class="bi bi-info-circle"></i>
                </span>
            </a></li>

            @if($settings['articles']->status)
            <li><a href="{{ route('blog') }}">{{ s_trans('Articles') }}
                <span>
                    <i class="bi bi-chat-left-text"></i>
                </span>
            </a></li>
            @endif
            
            <li><a href="{{ request()->routeIs('home') ? '#section_contact' : route('home') . '#section_contact' }}" class="toggler" data-toggle="#mobile-nav">{{ s_trans('Contact') }}
                <span>
                    <i class="bi bi-geo"></i>
                </span>
            </a></li>
        </ul>
    </nav>
    <!-- <div class="customer-support">
        <div>
            <h5>{{ s_trans('nav_mobile_caller_heading') }}</h5>
            <span>{{ s_trans('nav_mobile_caller_sub') }}</span>
        </div>
        <a href="tel:+994103150003" class="btn"><i class="bi bi-telephone"></i></a>
    </div> -->
</div>