<div class="breadcrumb-area breadcrumb-bg-2 pt-50 pb-20">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h1 class="breadcrumb-title">{{ $section }}</h1>

				<!--=======  breadcrumb list  =======-->

				<ul class="breadcrumb-list">
                    <li class="breadcrumb-list__item"><a href="{{ route('home') }}">{{ s_trans('Home') }}</a></li>
                    @isset($sublinks)
                        @foreach($sublinks as $sublink=>$label)
                        <li class="breadcrumb-list__item"><a href="{{ $sublink }}">{{ $label }}</a></li>
                        @endforeach
                    @endif					
					<li class="breadcrumb-list__item breadcrumb-list__item--active">{{ $title }}</li>
				</ul>

				<!--=======  End of breadcrumb list  =======-->

			</div>
		</div>
	</div>
</div>