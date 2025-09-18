<?php

namespace App\Http\Controllers;

use App\Models\PageMeta;
use Illuminate\Http\Request;

class PageMetaController extends Controller
{

    const MODULE = 'page_metas';
    const MODEL = '\PageMeta';

    private $options;

    public function __construct()
    {
        $this->options = [
            'nodelete'=> true,
        ];
    }

    private function fields(){
        $fields = [
            'title'=>[
                'type'=>'text',
                'permanent'=>true,
                'editable'=>false,
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
            'title'=>[
                'type'=>'text',
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
        $items = PageMeta::get();

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
            'item'=> PageMeta::find($id),
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
