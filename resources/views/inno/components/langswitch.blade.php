<div {!! $attributes->merge(['class' => 'inno-langswitch btn-group']) !!} role="group">
  @foreach (\App\Models\Language::get() as $lang)
    <a href="{{ route('inno.langswitch', $lang->code) }}" 
        class="btn @if($lang->code == app()->getLocale()) btn-light @else btn-outline-light @endif">
        
        {{ strtoupper($lang->code) }}
    </a>
  @endforeach
</div>