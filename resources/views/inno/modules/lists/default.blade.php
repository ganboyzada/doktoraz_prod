<table class="table table-striped">
    <thead>
        <tr>
            @foreach ($columns as $data=>$config)
            <th>
                @if($config['type']=='trans')
                <span class="me-2 fi fi-{{ app()->getLocale() }} fis"></span>{{ __(ucfirst($data)) }}
                @else
                {{ __(ucfirst($data)) }}
                @endif
            </th>
            @endforeach
            <th>
                {{ __('Functions') }}
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($items as $item)
        <tr>
            @foreach ($columns as $data=>$config)
            <td>
                @if ($config['type'] == 'text') 
                    @if(isset($config['model']) && $item->{$data})
                        @php
                            $model = '\App\Models'.$config['model'];
                            $belong = $model::find($item->{$data});
                        @endphp
                        {!! translate($belong->name) !!}
                    @else
                        @isset($config['notag'])
                        {{ strip_tags($item->{$data}) }}
                        @else
                        {{ $item->{$data} }}
                        @endisset
                    @endif
                @elseif ($config['type'] == 'trans') 
                    {!! Str::limit(strip_tags(translate($item->{$data})), 40) !!}                
                @elseif ($config['type'] == 'img') 
                    @isset($config['multiple'])
                        @if($temp_media=media($item->{$data}, true)) 
                            <img class="inno-list-img" src="{{ asset($temp_media[0]) }}"> 
                        @endif
                    @else
                        @if(media($item->{$data})) 
                            <img class="inno-list-img" src="{{ media($item->{$data}) }}"> 
                        @endif
                    @endif
                @elseif ($config['type'] == 'link') 
                    <a href="{{ $item->{$data} }}" class="btn">
                        {{ $item->{$data} }}
                    </a>

                @elseif ($config['type'] == 'date')      
                   {{ \Carbon\Carbon::parse($item->{$data})->format('d M, Y') }}

                @elseif ($config['type'] == 'toggle')
                    @if($item->{$data}) <i class="text-success bi bi-check-circle-fill"></i>
                    @else <i class="text-secondary bi bi-dash-circle-fill"></i> @endif

                @elseif ($config['type'] == 'icon')
                    {!! str_replace('icon', $item->{$config['column']}, $config['template']) !!}
                
                @elseif ($config['type'] =='indicator')
                    <span class="badge text-bg-{{ $config['indicate'][$item->{$data}] }}">{{ ucfirst($item->{$data}) }}</span>

                @elseif ($config['type'] =='color')
                    <span style="display: inline-block; width: 16px; height: 16px; background: {{ $item->{$data} }};"></span>
                @endif
            </td>
            @endforeach
            <td>
                @if(isset($options['view']))
                    <a href="{{ route($options['view']['route'], $item->id) }}" class="btn btn-secondary"><i class="bi bi-eye"></i></a>
                @endif
                @if(!isset($options['noedit']))
                <button type="button" data-edit="{{ $item->id }}" class="btn btn-editor"
                    data-bs-toggle="modal" data-bs-target="#editor_modal">
                    <i class="bi bi-pencil-square"></i>
                </button>
                @endif
                @if(!isset($options['nodelete']))
                <button data-delete="{{ $item->id }}" class="btn text-danger">
                    <i class="bi bi-trash3-fill"></i>
                </button>
                @endif
                
            </td>
        </tr>
        @endforeach
    </tbody>
</table>