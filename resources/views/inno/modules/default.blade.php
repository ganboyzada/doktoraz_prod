<x-innolayout::master>

@include('inno.modules.forms.creator')
@include('inno.modules.forms.editor')

<div class="inno-title">
    <h2 class="mb-3 me-auto">{{ __(ucfirst($module)) }}</h2>
    @if(!isset($options['nocreate']))
    <button type="button" class="btn-creator btn btn-primary"
        data-bs-toggle="modal" data-bs-target="#creator_modal">
        <i class="bi bi-plus-circle"></i>
        {{ __('Create') }}
    </button>
    @endif

    @if(isset($options['buttons']))
        @foreach($options['buttons'] as $type=>$button)
            @if($type=='link')
            <a href="{{ route($button['route']) }}" class="btn btn-secondary">
                {{ __($button['label']) }}
            </a>
            @endif
        @endforeach
    @endif
</div>

<div class="inno-list" id="inno_list" data-module="{{ $module }}">
@include('inno.modules.lists.default')
</div>
</x-innolayout::master>
