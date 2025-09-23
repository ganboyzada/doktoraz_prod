<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{

    const MODULE = 'members';
    const MODEL = '\Member';

    private function fields(){
        $fields = [
            'classified'=>[
                'type'=>'toggle',
            ],
            'category_id'=>[
                'type'=>'select',
                'model'=>'\Category',
            ],
            'first_name'=>[
                'type'=>'text',
            ],
            'last_name'=>[
                'type'=>'text',
            ],
            'desc'=>[
                'type'=>'trans',
                'editor'=>true,
            ],
            'photo'=>[
                'type'=>'img',
            ],
            'photo_layer'=>[
                'type'=>'img',
            ],
            'designation'=>[
                'type'=>'trans',
            ],
            'phone'=>[
                'type'=>'text',
            ],
            'email'=>[
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
            'classified'=>[
                'type'=>'toggle',
            ],
            'first_name'=>[
                'type'=>'text',
            ],
            'last_name'=>[
                'type'=>'text',
            ],
            'photo'=>[
                'type'=>'img',
            ],
            'designation'=>[
                'type'=>'trans',
            ],
            'phone'=>[
                'type'=>'text',
            ],
            
        ];

        return $columns;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Member::get();

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
            'title'=> 'first_name',
            'module'=> self::MODULE,
            'item'=> Member::find($id),
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
