<div {!! $attributes->merge(['class' => 'col']) !!}>
    <div class="inno-dashboard-component p-3 bg-primary d-flex align-items-center rounded" @isset($color) style="background-color: {{ $color }} !important;" @endisset>
        <h3 class="fw-medium fs-5 text-white mb-0 pe-3">{{ __($innotitle) }}</h3>
        <div class="fs-6 ms-auto btn btn-sm btn-outline-light">
            <i class="me-1 bi bi-{{ config('app.inno_modules')[$module] }}"></i>
            <span class="fw-bold">{{ $model::count() }}</span>x
        </div>
        <a class="fs-6 ms-2 btn btn-sm btn-outline-light" href="{{ route($module.'.index') }}">
            <i class="bi bi-grid-3x3-gap-fill"></i>
        </a>
    </div>
</div>