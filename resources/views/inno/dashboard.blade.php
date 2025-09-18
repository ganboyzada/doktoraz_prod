<x-innolayout::master>
    <div class="inno-title">
        <h2 class="mb-3">{{ __('Dashboard') }}</h2>
    </div>
    <div class="row g-3">
        {{--
        @php
            $categ_cols = [
                'name'=>[
                    'type'=>'trans',
                ],
                'slug'=>[
                    'type'=>'text',
                ],
                'photo'=>[
                    'type'=>'img',
                ],
            ];
            $prod_cols = [
                'name'=>[
                    'type'=>'trans',
                ],
                'price'=>[
                    'type'=>'text',
                ],
                'discount_toggle'=>[
                    'type'=>'toggle',
                ],
                'created_at'=>[
                    'type'=>'date',
                ],
            ];
            $order_cols = [
                'id'=>[
                    'type'=>'text',
                ],
                'customer_name'=>[
                    'type'=>'text',
                ],
                'customer_phone'=>[
                    'type'=>'text',
                ],
                'total_price'=>[
                    'type'=>'text',
                ],
                'status'=>[
                    'type'=>'text',
                ],
                'created_at'=>[
                    'type'=>'date',
                ],
            ];
        @endphp
        

        <x-inno::dashboard.list
            class="col-12"
            innotitle="Orders"
            :model="\App\Models\Order::class"
            module="orders"
            rows="6"
            color="#1654b8"
            :columns="json_encode($order_cols)">

        </x-inno::dashboard.list>

        <x-inno::dashboard.list 
            class="col-12 col-md-6 col-lg-6"
            innotitle="Categories"
            :model="\App\Models\Category::class"
            module="categories"
            rows="6"
            color="#1654b8"
            :columns="json_encode($categ_cols)">

        </x-inno::dashboard.list>
        
        <x-inno::dashboard.list 
                    class="col-12 col-md-6"
                    innotitle="Products"
                    :model="\App\Models\Product::class"
                    color="#cf8811"
                    rows="3"
                    module="products"
                    :columns="json_encode($prod_cols)"/>
        --}}
    </div>
</x-innolayout::master>