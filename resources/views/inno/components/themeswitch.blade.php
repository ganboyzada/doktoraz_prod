<div {!! $attributes->merge(['class' => 'inno-themeswitch btn-group']) !!} role="group">
  @foreach (['Light', 'Dark'] as $theme)
    <a href="{{ route('inno.themeswitch', strtolower($theme)) }}" 
        class="btn btn-outline-light  
        @if(session('innotheme')==strtolower($theme) || (!session('innotheme') && strtolower($theme)=='dark')) 
          active
        @endif">
        
        
        @if(strtolower($theme)=='dark')
        <i class="bi bi-moon-fill"></i>
        @else
        <i class="bi bi-brightness-high-fill"></i>
        @endif
        {{ __($theme) }}
    </a>
  @endforeach
</div>