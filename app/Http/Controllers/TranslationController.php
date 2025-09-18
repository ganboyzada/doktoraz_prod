<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\Translation;
use Illuminate\Http\Request;

class TranslationController extends Controller
{
    const MODULE = 'translations';
    const MODEL = '\Translation';

    private function fields(){
        $fields = [
            'trans_id'=>[
                'type'=>'hidden',
                'default'=>Translation::max('trans_id')+1,
            ],
            'static'=>[
                'type'=>'hidden',
                'default'=>true,
            ],
            'lang'=>[
                'type'=>'select',
                'list'=>Language::pluck('code')->toArray(),
            ],
            'key'=>[
                'type'=>'text',
            ],
            'value'=>[
                'type'=>'text',
                'editor'=>true,
            ],
        ];

        return $fields;
    }

    private function columns(){
        $columns = [
            'id'=>[
                'type'=>'text',
            ],
            'lang'=>[
                'type'=>'icon',
                'column'=>'lang',
                'template'=> '<span class="fi fi-icon fis"></span>',
            ],
            'key'=>[
                'type'=>'text',
            ],
            'value'=>[
                'type'=>'text',
                'notag'=>true,
            ],
        ];

        return $columns;
    }

    private function filter(){
        return [
            'where' => [
                'column'=>'static',
                'parameter'=>true,
            ],
            'orderBy' => [
                'column'=>'trans_id',
                'parameter'=>'desc',
            ],
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = ObjectController::list("\App\Models".self::MODEL, $this->filter());

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
            'item'=> Translation::find($id),
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

        return ObjectController::destroy($id, self::MODEL, $columns, $this->filter());
    }

    public static function store_translation($name, $request){
        $max_id = Translation::max('trans_id');

        foreach(Language::get() as $lang){
            $trans = new Translation;

            $trans->trans_id = $max_id + 1;
            $trans->lang = $lang->code;
            $trans->value = $request->{$name.'_'.$lang->code};

            $trans->save();
        }

        return $max_id + 1;

    }

    public static function import_translation($value){
        $max_id = Translation::max('trans_id');

        foreach(Language::get() as $lang){
            $trans = new Translation;

            $trans->trans_id = $max_id + 1;
            $trans->lang = $lang->code;
            $trans->value = $value;

            $trans->save();
        }

        return $max_id + 1;

    }

    public static function store_all_translations($name, $request){
        $max_id = Translation::max('trans_id');

        foreach(Language::get() as $lang){
            $trans = new Translation;

            $trans->trans_id = $max_id + 1;
            $trans->lang = $lang->code;
            $trans->value = $request->{$name.'_'.$lang->code};

            $trans->save();
        }

        return $max_id + 1;

    }

    public static function update_translation($trans_id, $name, $request){

        if($trans_id == null){
            return self::store_translation($name, $request);
        }

        $translations = Translation::where('trans_id', $trans_id)->get();
        
        $langs = [];

        foreach(Language::get()->pluck('code')->toArray() as $lang){
            $langs[$lang] = false;
        }

        foreach($translations as $trans){
            $trans->value = $request->{$name.'_'.$trans->lang};
            $trans->save();
            
            $langs[$trans->lang] = true;
        }

        foreach($langs as $lang=>$status){
            if(!$status){
                $trans = new Translation;

                $trans->trans_id = $trans_id;
                $trans->lang = $lang;
                $trans->value = $request->{$name.'_'.$lang};

                $trans->save();
            }
        }

        return $trans_id;
    }

    public static function delete_translation($trans_id){
        Translation::where('trans_id', $trans_id)->delete();
    }
}
