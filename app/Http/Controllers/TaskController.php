<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    const MODULE = 'tasks';
    const MODEL = '\Task';

    private function fields(){
        $fields = [
            'name'=>[
                'type'=>'text',
            ],
            'desc'=>[
                'type'=>'text',
                'editor'=>true
            ],
            'importance'=>[
                'type'=>'select',
                'list'=>['low','medium','high']
            ],
            'member_id'=>[
                'type'=>'select',
                'model'=>'\Member',
                'column'=>'first_name'
            ],  
            'deadline'=>[
                'type'=>'date',
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
                'type'=>'text',
            ],
            'importance'=>[
                'type'=>'text',
            ],
            'member_id'=>[
                'type'=>'text',
                'model'=>'\Member'
            ],
            'deadline'=>[
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
        $items = Task::get();

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
            'item'=> Task::find($id),
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
