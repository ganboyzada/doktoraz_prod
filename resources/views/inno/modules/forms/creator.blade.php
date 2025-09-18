<div class="modal creator-modal fade" id="creator_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Add new</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="rounded-lg px-6 py-4 w-96">
                    <form action="{{ route($module.'.store') }}" id="inno_creator_form" method="POST" enctype="multipart/form-data">
                        @csrf
                        @foreach ($fields as $field=>$config)
                        @if($config['type']!='hidden' && !isset($config['parse']))
                        <div class="mb-4 flex flex-col">
                            <label class="mb-3" for="{{ $field }}">{{ ucfirst($field) }}</label>

                            @if($config['type']=='trans')

                                @php
                                    $langs = \App\Models\Language::get();
                                @endphp
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    @foreach ($langs as $k=>$lang)
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link @if($k==0) active @endif" data-bs-toggle="tab"
                                            data-bs-target="#{{ $field.'_'.$lang->code }}" type="button"
                                            role="tab">
                                            <span class="me-2 fi fi-{{ $lang->code }} fis"></span>
                                            {{ strtoupper($lang->code) }}</button>
                                    </li>
                                    @endforeach
                                </ul>
                                <div class="tab-content">
                                    @foreach ($langs as $k=>$lang)
                                        <div class="tab-pane fade @if($k==0) show active @endif" id="{{ $field.'_'.$lang->code }}"
                                            role="tabpanel">
                                            @if(isset($config['editor']) && $config['editor'])
                                                <textarea class="form-control editor" name="{{ $field.'_'.$lang->code }}"></textarea>
                                            @else
                                                <input type="text" class="form-control" name="{{ $field.'_'.$lang->code }}">
                                            @endif
                                        </div>
                                    @endforeach
                                </div>

                            @elseif($config['type']=='text')

                                @if(isset($config['editor']) && $config['editor'])
                                    <textarea class="form-control editor" name="{{ $field }}"></textarea>
                                @else
                                    <input type="text" class="form-control" name="{{ $field }}">
                                @endif

                            @elseif($config['type']=='number')
                                <input type="number" class="form-control" name="{{ $field }}">
                            
                            @elseif ($config['type']=='img')
                                
                                <input type="hidden" name="{{ $field }}">
      
                                <button type="button" class="media-selector btn btn-primary" @isset($config['multiple']) data-multiple @endif data-field="{{ $field }}"
                                    data-bs-toggle="modal" data-bs-target="#media_upload_modal">
                                    @isset($config['multiple'])
                                    {{ __('Choose files') }}
                                    @else
                                    {{ __('Choose a file') }}
                                    @endif
                                </button>

                            @elseif ($config['type']=='select')
                                @if(isset($config['model']))
                                    @php
                                        $model = '\App\Models'.$config['model'];
                                    @endphp
                                    <select class="form-select" name="{{ $field }}">
                                        <option value="">{{ __('none') }}</option>
                                        @foreach ($model::get() as $selectable)
                                            <option value="{{ $selectable->id }}">
                                                {{ isset($config['column']) ? $selectable->{$config['column']} : translate($selectable->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                @elseif(isset($config['list']))
                                    <select class="form-select" name="{{ $field }}">
                                        <option value="">{{ __('None') }}</option>
                                        @foreach ($config['list'] as $selectable)
                                        <option value="{{ $selectable }}">{{ $selectable }}</option>
                                        @endforeach
                                    </select>
                                @else
                                @endif
                            
                            @elseif ($config['type']=='date')
                                <input type="date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="form-control" name="{{ $field }}">
                            
                            @elseif ($config['type']=='toggle')
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="{{ $field }}" id="inno_switch_{{ $field }}" @if(!isset($config['uncheck'])) checked @endif>
                                    <label class="form-check-label" for="inno_switch_{{ $field }}"></label>
                                </div>
                            @endif
                        </div>
                        @endif
                        @endforeach
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" class="modal_closer" data-bs-dismiss="modal">{{ __('Close') }}</button>
                <button type="button" onclick="$('#inno_creator_form').trigger('submit')" 
                    class="btn btn-primary">{{ __('Save') }}</button>
            </div>
        </div>
    </div>
</div>

@include('inno.components.media')
