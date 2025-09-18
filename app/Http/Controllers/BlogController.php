<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{

    const MODULE = 'blogs';
    const MODEL = '\Blog';

    private function fields(){
        $fields = [
            'published'=>[
                'type'=>'toggle',
            ],
            
            'title'=>[
                'type'=>'trans',
            ],
            'slug'=>[
                'type'=>'text',
                'parse'=>'title',
                'delimiter'=>'-',
                'lang'=> 'en',
            ],
            'desc'=>[
                'type'=>'trans',
                'editor'=>true
            ],
            'excerpt'=>[
                'type'=>'trans',
                'editor'=>true
            ],
            'photo'=>[
                'type'=>'img',
            ],
            'created_at'=>[
                'type'=>'date',
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
            'published'=>[
                'type'=>'toggle',
            ],
            'title'=>[
                'type'=>'trans',
            ],
            'excerpt'=>[
                'type'=>'trans',
            ],
            'photo'=>[
                'type'=>'img',
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
        $items = Blog::get();

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
            'item'=> Blog::find($id),
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
