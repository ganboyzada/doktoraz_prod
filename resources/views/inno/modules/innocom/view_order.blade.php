<x-innolayout::master>

<div class="inno-title mb-3 d-flex">
    <a href="{{ route('orders.index') }}" class="btn btn-secondary"><i class="me-2 bi bi-arrow-left"></i>{{ __('Back to orders') }}</a>
    <h2 class="mb-0 ms-3">{{ __('Order').': '.$order->order_id }}</h2>
</div>

<div class="details">
    <div class="row g-3">
        <div class="col-md-6 col-lg-4">
            <div class="card w-100 h-100" >
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-person me-2"></i>{{ __('Customer Details') }}</h5>
                    <h6 class="card-subtitle mb-2 text-body-secondary"></h6>
                    <p class="card-text">{{ $order->customer_name }}</p>

                    <div class="mb-4">   
                    @if($order->status == 'pending')
                    <span class="badge text-bg-warning"><i class="bi bi-clock"></i>{{ __('Order Pending') }}</span>
                    @elseif($order->status == 'completed')
                    <span class="badge text-bg-success"><i class="bi bi-check2-circle"></i>{{ __('Order Completed') }}</span>
                    @elseif($order->status == 'cancelled')
                    <span class="badge text-bg-danger"><i class="bi bi-x"></i>{{ __('Cancelled') }}</span>
                    @else
                    <span class="badge text-bg-light">{{ __('Status Error') }}</span>
                    @endif
                    </div>
                    
                    <div class="fs-6 mb-4"><i class="bi bi-clock me-2"></i>Created at:{{ $order->created_at }}</div>
                    <div class="fs-5"><i class="bi bi-calendar me-2"></i>Ordered for:{{ $order->order_date }}</div>

                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card w-100 h-100">
                <div class="card-body">
                    <h5 class="card-title">Additional Details</h5>
                    <p><strong>Whatsapp Number:</strong> {{ $order->customer_phone }}</p>
                    <p><strong>Custom Logo:</strong> {{ $order->has_custom_logo }}</p>
                    <p><strong>Country:</strong> {{ $order->country }}</p>
                    <p><strong>Instagram User:</strong> {{ $order->ig_username }}</p>
                </div>
            </div>
        </div>
        @if($order->customer_email)
        <div class="col-md-6 col-lg-4">
            <div class="row">
                <div class="col-12">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ __('Customer E-mail') }}</h5>
                        <h6 class="card-subtitle mb-2 text-body-secondary"></h6>
                        
                        <p class="card-text">{{ $order->customer_email }}</p>
                        <a href="mailto:{{ $order->customer_email }}" class="btn btn-warning card-link"><i class="bi bi-envelope me-2"></i>{{ __('Send e-mail') }}</a>
                    </div>
                </div>
                </div>
                <div class="col-12">
                <div class="card w-100 h-100">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-telephone me-2"></i>{{ __('Customer Whatsapp') }}</h5>
                        <h6 class="card-subtitle mb-2 text-body-secondary"></h6>
                        <p class="card-text">{{ $order->customer_phone }}</p>
                        @php
                            $wp_number = str_replace([' ', '+'], '', $order->customer_phone);
                        @endphp
                        <a href="https://wa.me/{{ $wp_number }}" target="_blank" class="btn btn-success card-link"><i class="bi bi-whatsapp me-2"></i>{{ __('Text Now') }}</a>
                    </div>
                </div>
                </div>
            </div>
            
           
        </div>
        @endif
        <div class="col-12">
            <div class="card w-100 h-100">
                <div class="card-body">
                    <h5 class="card-title">{{ __('Ordered Items') }}</h5>    
                    
                    <div class="row">
                        <div class="col-md-8 col-lg-10">
                            <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4">
                                @foreach($order->items as $item)
                                <div class="product">
                                    <div class="card w-100">
                                        <img height="140" src="{{ asset(media($item->product->photos, true)[0]) }}" class="card-img-top object-fit-contain" alt="...">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ translate($item->product->name) }}</h5>
                                            <p class="mb-0">{{ __('Stocks') }}: {{ $item->product->quantity }}</p>
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item"><i class="bi bi-stack me-2"></i>{{ __('Ordered Quantity') }}: {{ $item->quantity }}</li>
                                            <li class="list-group-item"><i class="bi bi-tag-fill me-2"></i>{{ __('Base Price') }}: {{ $item->product_price }}</li>
                                            <li class="list-group-item"><i class="bi bi-percent me-2"></i>{{ __('Discounted Price') }}: {{ $item->discounted_price }}</li>
                                            @isset($item->product_kind)
                                                @if($item->product_kind != 'null')
                                                <li class="list-group-item">{{ __('Kind') }}: {{ json_decode($item->product_kind, true)[session()->get('innolang')] }}</li>
                                                @endif
                                            @endisset
                                            @isset($item->variant)
                                            <li class="list-group-item">{{ __('Option') }}: {{ transBy($item->variant->title, session()->get('innolang')) }}</li>
                                            @endisset
                                        </ul>
                                        <div class="card-body">
                                            <a href="{{ route('store.show', $item->product->slug) }}" target="_blank" class="card-link">{{ __('Visit product') }}</a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-md-4 col-lg-2">
                            <div class="card w-100">
                                <div class="card-body">
                                    <h5 class="card-title">{{ __('Order Total') }}</h5>
                                    <p class="card-text fs-3">{{ $order->total_price }} AED</p>            
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    
</div>

</x-innolayout::master>