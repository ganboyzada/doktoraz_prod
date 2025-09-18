<div id="inno_sidebar" class="inno-sidebar px-3 py-4">   
    <div class="d-flex justify-content-between align-items-center px-3 mb-3">
        <x-application-logo class="inno-logo"></x-application-logo>
        <button data-toggle="#inno_sidebar" class="btn btn-sm btn-outline-light fs-5 d-sm-none">
            <i class="bi bi-x-lg"></i>
        </button>
    </div> 
    <div class="px-3 d-flex flex-column">
        <div class="d-flex align-items-center">
            <x-inno::langswitch></x-inno::langswitch>
            <a href="{{ route('home') }}" class="ms-3 px-3 py-0 btn btn-outline-warning" target="_blank">
                <i class="bi bi-eye-fill"></i>
                {{-- {{ __('Preview site') }} --}}
            </a>
        </div>
        
        <x-inno::themeswitch class="mt-2 mb-1"></x-inno::themeswitch>
        
    </div>
    
    
    <nav>
        <ul>
            <li><a href="{{ route('dashboard') }}"><i class="bi bi-grid-1x2"></i>{{ __('Dashboard') }}</a></li>
            @foreach (config('app.inno_modules') as $module=>$icon)
            <li>
                {{-- <a href="{{ route($module.'.index') }}">
                    <i class="bi bi-{{ $icon }}"></i>
                    {{ ucwords($module) }}</a> --}}
                <a href="{{ route($module . '.index') }}">
                    <i class="bi bi-{{ $icon }}"></i>
                    {{ __(ucwords($module)) }}</a>
            </li>
            @endforeach
        </ul>
    </nav>
</div>