<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Media;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ObjectController extends Controller
{
    public static function create($module, $fields){  
        $method = 'POST';
        return view('inno.modules.forms.default', compact(['module', 'method', 'fields']));
    }

    public static function store(Request $request, $fields, $columns, $model, $filter = null, $options = null){

        $model_path = "\App\Models".$model;
        $item = new $model_path;
        
        foreach($fields as $field=>$config){
            if($config['type'] == 'trans'){
                $item->{$field} = TranslationController::store_translation($field, $request);
            } 
            else if($config['type'] == 'toggle'){
                $item->{$field} = $request->{$field}=='on';
            }
            elseif($config['type']=='hidden'){    
                $item->{$field} = $config['default'];
            }
            else{
                if(isset($config['parse'])){
                    if(isset($config['lang'])){
                        $parsableText = $request->{$config['parse'].'_'.$config['lang']};
                    }else{
                        $parsableText = $request->{$config['parse']};
                    }
                    $item->{$field} = Str::slug($parsableText, $config['delimiter']);
                } else{
                $item->{$field} = $request->{$field};
                }
            }
        }

        $item->save();

        $items = self::list($model_path, $filter);

        return response()->json([
            'success' => true,
            'html' => view('inno.modules.lists.default', compact('items', 'columns', 'options'))->render(),
            'message' => 'Item uploaded successfully!'
        ]);
    }

    public static function update(Request $request, $id, $fields, $columns, $model, $filter = null, $options = null){

        $model_path = "\App\Models".$model;
        $item = $model_path::find($id);
        
        foreach($fields as $field=>$config){
            if($config['type'] == 'trans'){
                $item->{$field} = TranslationController::update_translation($item->{$field}, $field, $request);
            } 
            else if($config['type'] == 'toggle'){
                $item->{$field} = $request->{$field}=='on';
            }
            elseif($config['type']=='hidden'){
                $item->{$field} = $config['default'];
            }
            else{
                if($request->{$field}){
                    if(isset($config['multiple']) && $config['multiple']){
                        $old_val = json_decode($item->{$field});
                        $new_val = json_decode($request->{$field});

                        $item->{$field} =  json_encode(array_merge(($old_val==null ? [] :$old_val), $new_val));
                    } else{
                        $item->{$field} = $request->{$field};
                    }
                }
            }
        }

        $item->save();

        if (isset($options['invokers']) && $options['invokers']) {
            if($invokers = $options['invokers']){
                foreach($invokers as $watched=>$invoker){
                    try {
                        if($item->{$watched}==$invoker['condition']){
                            if(str_contains($invoker['function'], '::')){
                                [$class, $method] = explode('::', $invoker['function']);
      
                                if (class_exists($class) && method_exists($class, $method)) {
                                    $controllerInstance = new $class();
      
                                    $result = call_user_func_array([$controllerInstance, $method], [$item->{$invoker['parameter']}]);
                                } 
                            } 
                        }
                    } catch (\Throwable $th) {
                        Log::error('Invoker execution failed: ' . $th->getMessage(), ['exception' => $th]);
                    }
                }
            }
        }

        $items = self::list($model_path, $filter);

        return response()->json([
            'success' => true,
            'html' => view('inno.modules.lists.default', compact('items', 'columns', 'options'))->render(),
            'message' => 'Item updated successfully!'
        ]);
    }

    public static function edit($fields, $editor=null){

        if(!isset($editor)){
            $editor = [
                'title'=> 'Object',
                'module'=> null,
                'item'=> null,
            ];
        }

        $method = 'POST';

        return response()->json([
            'success' => true,
            'html' => view('inno.modules.forms.editor_ajax', compact(['editor', 'method', 'fields']))->render(),
        ]);
    }

    public static function destroy($id, $model, $columns, $filter=null, $options = null){
        $model_path = "\App\Models".$model;
        $item = $model_path::find($id);

        $item->delete();

        $items = self::list($model_path, $filter);

        return response()->json([
            'success' => true,
            'html' => view('inno.modules.lists.default', compact('items', 'columns', 'options'))->render(),
            'message' => 'Deleted.'
        ]);

    }

    public static function list($model_path, $filter=null){
        if($filter){
            
            $query = $model_path::query();

            foreach($filter as $func=>$config){
                $query->{$func}($config['column'], $config['parameter']);
            }
            
            $items = $query->get();
            
        } else{
            $items = $model_path::get();
        }

        return $items;
    }
}
