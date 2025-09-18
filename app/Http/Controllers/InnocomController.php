<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Language;
use App\Models\Product;
use App\Models\Order;
use App\Models\PageMeta;
use App\Models\ProductVariant;
use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\OrderConfirmationMail;
use App\Mail\AdminOrderNotificationMail;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderCancelledMail;
use App\Models\Setting;

class InnocomController extends Controller
{
    //This is the main controller of InnoCom module

    public function setOrderDate(Request $request)
    {
        // Validate the date input
        $request->validate([
            'date' => 'required|date',
        ]);

        $date = $request->input('date');

        if(session()->has('failed_order')){
            $order = Order::where('order_id', session()->get('failed_order'))->first();

            $order->order_date = $date;
            $order->save();

            session()->forget('failed_order');
            session(['order_date' => $date]);

            Mail::to($order->customer_email)->send(new OrderConfirmationMail($order, app()->getLocale()));

            // Notify admin
            Mail::to('admin@obsequio.ae')->send(new AdminOrderNotificationMail($order));

            return response()->json([
                'status' => 'success',
                'redirect' => route('checkout.success', $order->order_id),
            ]);
        }

        // Count the orders for the given date
        $orderCount = Order::whereDate('created_at', $date)->whereIn('status', ['pending', 'completed'])->count();

        // Check if there are more than 7 orders
        if ($orderCount >= 7) {
            return back()->with(['success'=>'The given date has more than 7 orders. Please select another date.']);
        }

        // Set the date in the session
        session(['order_date' => $date]);

        return response()->json([
            'status' => 'success',
            'redirect' => 'reload',
        ]);
    }

    public function clearOrderDate(){
        session()->forget('order_date');

        return back();

    }

    public function index(Request $request){
        $categories = Category::get()->keyBy('id');
        $page_meta = PageMeta::where('title', 'store')->first();

        $translatables = ['name', 'description', 'meta_tags', 'meta_desc'];

        $orderedBy = $request->query('ordered_by', 'default');
        $category = $request->query('category');
        $query = Product::query();

        $query->where('out_of_stock', '!=', true);

        if($category){
            $query->where('category_id', $category);
        }

        switch ($orderedBy) {
            case 'price_low_to_high':
                $query->orderBy('price', 'asc');
                break;

            case 'price_high_to_low':
                $query->orderBy('price', 'desc');
                break;

            default:
                // Default sorting logic, e.g., sort by name
                $query->orderBy('created_at', 'desc');
                break;
        }
        
        $products = $query->get();

        $trans_ids = [];
        foreach($products as $product){
            foreach($translatables as $field){
                $trans_ids[] = $product->{$field};
            }
        }
        foreach($categories as $cat){
            $trans_ids[] = $cat->name;
        }

        $trans_ids[]=$page_meta->meta_tags;
        $trans_ids[]=$page_meta->meta_desc;

        $translations_temp = Translation::select(['trans_id', 'value'])->whereIn('trans_id', $trans_ids)->where('lang', app()->getLocale())->get()->toArray();
        
        $translations = array_combine(array_column($translations_temp, 'trans_id'), array_column($translations_temp, 'value'));
        

        return view('front.innocom.products', compact(['products', 'categories', 'translations', 'page_meta']));
    }

    public function show($product){
        $categories = Category::get()->keyBy('id');
        $product = Product::where('slug', $product)->first();

        $translatables = ['name', 'description', 'meta_tags', 'meta_desc', 'product_kinds'];

        $trans_ids = [];
        
        foreach($translatables as $field){
            $trans_ids[] = $product->{$field};
        }
        foreach($categories as $cat){
            $trans_ids[] = $cat->name;
        }
        $translations_temp = Translation::select(['trans_id', 'value'])->whereIn('trans_id', $trans_ids)->where('lang', app()->getLocale())->get()->toArray();
        
        $translations = array_combine(array_column($translations_temp, 'trans_id'), array_column($translations_temp, 'value'));
        
        return view('front.innocom.product', compact(['product', 'translations', 'categories']));
    }

    public function addToBasket(Request $request)
    {
        $productId = $request->product_id;
        // Retrieve the product by ID
        $product = Product::find($productId);
        $variant = null;

        $moq = Setting::where('label', 'minimum_order_quantity')->first();

        $min_order_qty = $moq ? $moq->value : null ;

        $discountedPrice = $product->price - ($product->price * ($product->discount / 100));

        if($subprod_id = $request->product_variant){
            $subprod = ProductVariant::find($subprod_id);

            $variant = [
                'id' => $subprod->id,
                'title' => $subprod->title,
                'price' => $subprod->price,
            ];

            if($variant['price']){
                $discountedPrice = $variant['price'];
            }
        } 

        // Get the current basket from the session or initialize it
        $basket = session()->get('basket', []);

        // Calculate the discounted price
        
        // Kind
        $kind = [];

        if($request->product_kind != null){
            foreach(Language::get() as $lang){
                $kind[$lang->code] = array_filter(explode('|', transBy($product->product_kinds, $lang->code)), fn($item) => strpos($item, '$') === false)[$request->product_kind];
            }
        }

        $uniqueKey = 'B_'. $productId . '-' . (isset($variant) ? $variant['id'] : 0) . '-' . ($request->product_kind==null ? 'X' : $request->product_kind);

        // Check if the product already exists in the basket
        if (isset($basket[$uniqueKey])) {
            // Increase the quantity
            $basket[$uniqueKey]['quantity'] += $request->quantity;
        } else {
            // Add new product to the basket
            $basket[$uniqueKey] = [
                'productID'     => $product->id,
                'name'           => $product->name,
                'slug'           => $product->slug,
                'photos'          => media($product->photos, true),
                'price'          => isset($variant['price']) && $variant['price'] ? $variant['price'] : $product->price,
                'discount'       => $product->discount,   // Store the discount percentage
                'discountedPrice'=> $discountedPrice,     // Store the discounted price
                'quantity'       => $min_order_qty ? ($request->quantity < $min_order_qty ? $min_order_qty : $request->quantity ) : $request->quantity,
                'variant'        => $variant,
                'kind'           => count($kind) ? $kind : null,
            ];
        }

        // Save the updated basket to the session
        session()->put('basket', $basket);

        // Redirect back with a success message
        return redirect()->back()->with('success', s_trans('Product added to basket'));
    }

    public function updateBasket(Request $request)
    {
        // Get the current basket from the session
        $basket = session()->get('basket', []);

        // Loop through submitted quantities
        foreach ($request->quantities as $productId => $quantity) {
            if (isset($basket[$productId])) {
                // Update the quantity
                $basket[$productId]['quantity'] = $quantity;

                // Optionally, recalculate discounted price if discount can change
                // If the discount is dynamic, fetch the latest discount
                /*
                $product = Product::find($productId);
                $basket[$productId]['discount'] = $product->discount;
                $basket[$productId]['discountedPrice'] = $product->price - ($product->price * ($product->discount / 100));
                */
            }
        }

        // Save the updated basket to the session
        session()->put('basket', $basket);

        // Redirect back with success message
        return redirect()->back()->with('success', 'Basket updated successfully!');
    }

    public function removeFromBasket($productId)
    {
        // Get the current basket from the session
        $basket = session()->get('basket', []);

        // Remove the product from the basket
        if (isset($basket[$productId])) {
            unset($basket[$productId]);
        }

        // Save the updated basket to the session
        session()->put('basket', $basket);

        // Redirect back with success message
        return redirect()->back()->with('success', s_trans('Product removed from basket'));
    }

    public function viewBasket() {
        return view('front.innocom.basket_full');
    }

    public function order(){
        return view('front.innocom.checkout');
    }

    public function checkout(Request $request)
    {

        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:9|confirmed',
            'ig_username' => 'required|string|max:255',
            'country' => 'required|string|max:100',
            'has_custom_logo' => 'required|in:yes,no,not_yet_ready',
            'payment_method' => 'required|in:bank,cash,card',
        ]);

        $basket = session()->get('basket', []);
        $order_date = session()->get('order_date', []);

        // Calculate the total price of the order
        $totalPrice = array_sum(array_map(function($item) {
            return $item['discountedPrice'] * $item['quantity'];
        }, $basket));

        $orderId = 'OBS-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5));

        // Create a new order
        $order = Order::create([
            'order_id' => $orderId,
            'customer_name' => $request->input('customer_name'),
            'customer_email' => $request->input('customer_email'),
            'customer_phone' => $request->input('country_code').$request->input('customer_phone'),
            'total_price' => $totalPrice,
            'status' => 'pending',
            'ig_username' => $request->input('ig_username'),
            'country' => $request->input('country'),
            'has_custom_logo' => $request->input('has_custom_logo'),
            'payment_method' => $request->input('payment_method'),
            'terms_accepted' => true,
            'order_date' => $order_date,
        ]);

        // Add each item in the basket as an order item
        foreach ($basket as $id => $item) {
            $order->items()->create([
                'product_id' => $item['productID'],
                'product_name' => $item['name'],
                'product_price' => $item['price'],
                'discounted_price' => $item['discountedPrice'],
                'quantity' => $item['quantity'],
                'variant_id' => isset($item['variant']) ? $item['variant']['id'] : null,
                'product_kind' => $item['kind'] ? json_encode($item['kind']) : null,
            ]);
        }

        $orderCount = Order::where('order_date', $order_date)->count();
        if ($orderCount > 7) {
            session()->put('failed_order', $orderId);
            session()->forget('order_date');
            return redirect()->route('checkout.date_unavailable');
        } 

        // Clear the basket after checkout
        session()->forget('basket');

        // Send confirmation email to customer
        Mail::to($order->customer_email)->send(new OrderConfirmationMail($order, app()->getLocale()));

        // Notify admin
        Mail::to('admin@obsequio.ae')->send(new AdminOrderNotificationMail($order));

        // Redirect to a success page or back with a success message
        return redirect()->route('checkout.success', $orderId);
        
    }

    public function checkoutSuccess($orderId){
        $order = Order::where('order_id', $orderId)->firstorfail();

        return view('front.innocom.checkout_success', compact('order'));
    }

    public function cancelOrder($orderId)
    {
        $order = Order::findOrFail($orderId);

        // Send cancellation email to customer
        Mail::to($order->customer_email)->send(new OrderCancelledMail($order, $order->locale));

        return true;
    }

    public function downloadInvoice($lang='en', $orderId)
    {
        $order = Order::with('items')->where('order_id', $orderId)->first();

        if($lang == 'ar'){
            $pdf = Pdf::loadView('front.innocom.invoice_rtl', ['order' => $order]);
        } else{
            $pdf = Pdf::loadView('front.innocom.invoice', ['order' => $order]);
        }
        return $pdf->download("invoice-{$lang}-{$order->order_id}.pdf");
    }

    public function view_order($id){
        $order = Order::with('items')->find($id);

        return view('inno.modules.innocom.view_order', compact(['order']));
    }

}
