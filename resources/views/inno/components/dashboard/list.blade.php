<div {!! $attributes->merge(['class' => 'col']) !!}>
    <div class="mb-3 p-3 bg-primary rounded inno-dashboard-component" @isset($color) style="background-color: {{ $color }} !important;" @endisset>
        <div class="mb-3 d-flex align-items-center">
            <h3 class="fs-5 fw-medium text-white mb-0 pe-3">{{ __($innotitle) }}</h3>
            <div class="fs-6 ms-auto btn btn-sm btn-outline-light">
                <i class="me-2 bi bi-{{ config('app.inno_modules')[$module] }}"></i>
                <span class="fw-bold">{{ $model::count() }}</span>x
            </div>
            <a class="fs-6 ms-2 btn btn-sm btn-outline-light" href="{{ route($module.'.index') }}">
                <i class="bi bi-grid-3x3-gap-fill"></i>
            </a>
        </div>
        
        <div class="rounded overflow-auto">
            <table class="table mb-0">
                <thead>
                    <tr>
                        @foreach (json_decode($columns, true) as $column=>$config)
                        <th>{{ __(ucfirst($column)) }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($model::take($rows)->get() as $item)
                    <tr>
                        @foreach (json_decode($columns, true) as $column=>$config)
                        <td>
                            @if($config['type']=='trans')
                                {{ translate($item->{$column}) }}
                            
                            @elseif ($config['type']=='date')
                                {{ \Carbon\Carbon::parse($item->{$column})->format('d M, Y') }} 
                                
                            @else
                                @if(isset($config['model']) && $item->{$column}!=null)
                                {{ translate($config['model']::find($item->{$column})->name) }}
                                @else
                                {{ $item->{$column} }}
                                @endif
                            @endif
                        </td>
                        @endforeach 
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{ $slot }}
</div>