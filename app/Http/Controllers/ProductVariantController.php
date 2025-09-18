<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{

    const MODULE = 'product_variants';
    const MODEL = '\ProductVariant';

    private function fields(){
        $fields = [
            'active'=>[
                'type'=>'toggle',
            ],
            'product_id'=>[
                'type'=>'select',
                'model'=>'\Product',
            ],
            'title'=>[
                'type'=>'trans',
            ],
            'price'=>[
                'type'=>'text',
            ],
            'stocks'=>[
                'type'=>'number',
            ],
            'photos'=>[
                'type'=>'img',
                'multiple'=>true,
            ],
        ];

        return $fields;
    }

    private function columns(){
        $columns = [
            'active'=>[
                'type'=>'toggle',
            ],
            'product_id'=>[
                'type'=>'text',
                'model'=>'\Product',
            ],
            'title'=>[
                'type'=>'trans',
            ],
            'price'=>[
                'type'=>'text',
            ],
            'stocks'=>[
                'type'=>'number',
            ],
            'photos'=>[
                'type'=>'img',
                'multiple'=>true,
            ],
        ];

        return $columns;
    }

    private function filter(){
        return [
            'orderBy' => [
                'column'=>'product_id',
                'parameter'=>'desc',
            ],
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = ProductVariant::orderBy('product_id', 'desc')->get();

        $module = self::MODULE;

        $fields = $this->fields();
        $columns = $this->columns();

        return view('inno.modules.default', compact(['fields', 'module', 'items','columns']));
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

        return ObjectController::store($request, $fields, $columns, self::MODEL, $this->filter());
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
            'item'=> ProductVariant::find($id),
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

        return ObjectController::update($request, $id, $fields, $columns, self::MODEL, $this->filter());
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
