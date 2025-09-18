<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    const MODULE = 'projects';
    const MODEL = '\Project';

    private function fields(){
        $fields = [
            'featured'=>[
                'type'=>'toggle',
            ],
            'category_id'=>[
                'type'=>'select',
                'model'=>'\Category'
            ],
            'client_id'=>[
                'type'=>'select',
                'model'=>'\Client'
            ],
            'name'=>[
                'type'=>'trans',
            ],
            'desc'=>[
                'type'=>'trans',
                'editor'=>true
            ],
            'color'=>[
                'type'=>'text',
            ],
            'photo'=>[
                'type'=>'img',
            ],
            'video'=>[
                'type'=>'text',
            ],
            'photos'=>[
                'type'=>'img',
                'multiple'=>true
            ],
        ];

        return $fields;
    }

    private function columns(){
        $columns = [
            'id'=>[
                'type'=>'text',
            ],
            'featured'=>[
                'type'=>'toggle',
            ],
            'name'=>[
                'type'=>'trans',
            ],
            'photo'=>[
                'type'=>'img',
            ],
            'category_id'=>[
                'type'=>'text',
                'model'=>'\Category'
            ],
        ];

        return $columns;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Project::get();

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
            'item'=> Project::find($id),
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
