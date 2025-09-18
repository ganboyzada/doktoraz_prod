<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    const MODULE = 'orders';
    const MODEL = '\Order';
    
    private $options;

    public function __construct()
    {
        $this->options = [
            // 'nodelete'=> true,
            'nocreate'=> true,
            // 'noedit'=> true,
            'view'=>[
                'route' => 'orders.view',
            ],
            'invokers' => [
                'status'=>[
                    'condition'=>'cancelled',
                    'function'=>'\App\Http\Controllers\InnocomController::cancelOrder',
                    'parameter'=>'id',
                ]
            ]
        ];
    }

    private function filter(){
        return [
            'orderBy' => [
                'column'=>'order_date',
                'parameter'=>'desc',
            ],
        ];
    }

    private function fields(){
        $fields = [
            'status'=>[
                'type'=>'select',
                'list'=> [
                    'pending', 'completed', 'cancelled'
                ]
            ],
            'customer_name'=>[
                'type'=>'text',
            ],
            'customer_email'=>[
                'type'=>'text',
            ],
            'customer_phone'=>[
                'type'=>'text',
            ],

        ];

        return $fields;
    }

    private function columns(){
        $columns = [
            'id'=>[
                'type'=>'text',
            ],
            'customer_name'=>[
                'type'=>'text',
            ],
            'customer_email'=>[
                'type'=>'text',
            ],
            'customer_phone'=>[
                'type'=>'text',
            ],
            'total_price'=>[
                'type'=>'text',
            ],
            'status'=>[
                'type'=>'indicator',
                'indicate'=>[
                    'pending'=>'warning',
                    'completed'=>'success',
                    'cancelled'=>'danger',
                ]
            ],
            'order_date'=>[
                'type'=>'date',
            ],
            
        ];

        return $columns;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // orderByRaw("
        //             CASE 
        //                 WHEN status = 'pending' THEN 1 
        //                 WHEN status = 'cancelled' THEN 2 
        //                 WHEN status = 'completed' THEN 3 
        //                 ELSE 4
        //             END
        //         ")
        $items = ObjectController::list("\App\Models".self::MODEL, $this->filter());

        $module = self::MODULE;

        $fields = $this->fields();
        $columns = $this->columns();

        return view('inno.modules.default', compact(['fields', 'module', 'items','columns']))
                ->with(['options' => $this->options]);
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

        return ObjectController::store($request, $fields, $columns, self::MODEL, $this->filter(), $this->options);
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
            'item'=> Order::find($id),
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

        return ObjectController::update($request, $id, $fields, $columns, self::MODEL, $this->filter(), $this->options);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $columns =  $this->columns();

        return ObjectController::destroy($id, self::MODEL, $columns, $this->filter(), $this->options);
    }
}
