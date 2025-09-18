<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    const MODULE = 'products';
    const MODEL = '\Product';

    private $options;

    public function __construct()
    {
        $this->options = [
            'buttons'=> [
                'link'=>[
                    'label'=>'Product Variants',
                    'route'=>'product_variants.index'
                ]
            ],
        ];
    }

    private function fields(){
        $fields = [
            'featured'=>[
                'type'=>'toggle',
            ],
            'category_id'=>[
                'type'=>'select',
                'model'=>'\Category'
            ],
            'name'=>[
                'type'=>'trans',
            ],
            'slug'=>[
                'type'=>'text',
                'parse'=>'name',
                'delimiter'=>'-',
                'lang'=> 'en',
            ],
            'product_kinds'=>[
                'type'=>'trans',
            ],
            'description'=>[
                'type'=>'trans',
                'editor'=>true
            ],
            'price'=>[
                'type'=>'number'
            ],
            'discount'=>[
                'type'=>'number'
            ],
            'discount_toggle'=>[
                'type'=>'toggle',
                'uncheck'=>true,
            ],
            'quantity'=>[
                'type'=>'number',
            ],
            'out_of_stock'=>[
                'type'=>'toggle'
            ],
            'photos'=>[
                'type'=>'img',
                'multiple'=>true,
            ],
            'meta_tags'=>[
                'type'=>'trans'
            ],
            'meta_desc'=>[
                'type'=>'trans'
            ],
        ];

        return $fields;
    }

    private function columns(){
        $columns = [
            'id'=>[
                'type'=>'text',
            ],
            'name'=>[
                'type'=>'trans',
            ],
            'featured'=>[
                'type'=>'toggle',
            ],
            'out_of_stock'=>[
                'type'=>'toggle',
            ],
            'price'=>[
                'type'=>'text',
            ],
            'discount_toggle'=>[
                'type'=>'toggle',
            ],
            'photos'=>[
                'type'=>'img',
                'multiple'=>true
            ],
            'created_at'=>[
                'type'=>'date',
            ],
            'meta_tags'=>[
                'type'=>'trans',
            ],
        ];

        return $columns;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Product::get();

        $module = self::MODULE;

        $fields = $this->fields();
        $columns = $this->columns();

        return view('inno.modules.default', compact(['fields', 'module', 'items','columns']))->with(['options' => $this->options]);;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $fields = $this->fields();
        return ObjectController::create(self::MODULE, $fields);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $this->fields();
        $columns =  $this->columns();

        return ObjectController::store($request, $fields, $columns, self::MODEL);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $fields = $this->fields();

        $editor = [
            'title'=> 'name',
            'module'=> self::MODULE,
            'item'=> Product::find($id),
        ];

        return ObjectController::edit($fields, $editor);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $fields = $this->fields();
        $columns =  $this->columns();

        return ObjectController::update($request, $id, $fields, $columns, self::MODEL);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $columns =  $this->columns();

        return ObjectController::destroy($id, self::MODEL, $columns);
    }
}
