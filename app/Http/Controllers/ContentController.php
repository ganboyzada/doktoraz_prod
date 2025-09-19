<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;

class ContentController extends Controller
{

    const MODULE = 'contents';
    const MODEL = '\Content';

    private function fields(){
        $fields = [
            'type'=>[
                'type'=>'select',
                'list'=>[
                    'section',
                    'mobile',
                    'phone',
                    'ambulance',
                    'address',
                    'email',
                    'gallery'
                ]
            ],
            'name'=>[
                'type'=>'text',
            ],
            'value'=>[
                'type'=>'trans',
                'editor'=>true
            ],
            'link'=>[
                'type'=>'text',
            ],
            'image'=>[
                'type'=>'img',
            ],
        ];

        return $fields;
    }

    private function columns(){
        $columns = [
            'id'=>[
                'type'=>'text',
            ],
            'type'=>[
                'type'=>'text',
            ],
            'name'=>[
                'type'=>'text',
            ],
            'value'=>[
                'type'=>'trans',
            ],
            'link'=>[
                'type'=>'link',
            ],
            'image'=>[
                'type'=>'img',
            ],
        ];

        return $columns;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Content::get();

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
            'item'=> Content::find($id),
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
