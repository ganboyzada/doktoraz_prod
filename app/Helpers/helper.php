<?php

use App\Models\Media;
use App\Models\Translation;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

if (!function_exists('media')) {
    /**
     * This function uploads files to the filesystem of your choice
     * @param \Illuminate\Http\UploadedFile $file The File to Upload
     * @param string|null $filename The file name
     * @param string|null $folder A specific folder where the file will be stored
     * @param string $disk Your preferred Storage location(s3,public,gcs etc)
     */

    function media($id, $multiple=false)
    {
        if($id){
            if($multiple){
                $media = Media::whereIn('id', json_decode($id))->get()->pluck('url')->toArray();
            } else{
                $media = Media::find($id);
            }
        } else{
            $media = null;
        }

        if($media){
            if($multiple){
                return $media;
            } else{
                return asset($media->url);
            }
        } else{
            return false;
        }
    }

    function translate($trans_id){
        if($trans_id == null){
            return 'N/A';
        }

        $translation = Translation::where('trans_id', $trans_id)->where('lang', app()->getLocale())->first();

        if(!empty($translation)){
            return $translation->value;
        }

        return 'N/A';
    }

    function s_trans($key, $tagged = false){
        
        if(true){
        // if(!session()->has('dictionary')){
            $db_dict = Translation::select(['id', 'key', 'lang', 'value'])->where('static', true)->get()->toArray();
            session()->put('dictionary', json_encode($db_dict));
        }
        
        if($key == null){
            return 'N/A';
        }

        $lang = app()->getLocale();

        // $translation = Translation::where('key', $key)->where('lang', app()->getLocale())->first();
        foreach(json_decode(session('dictionary')) as $dict_item){
            if($dict_item->key==$key && $dict_item->lang==$lang){
                $translation = $dict_item->value;
            }
        }

        if(!empty($translation)){
            return $tagged ? $translation : strip_tags($translation);
        }

        return $key;
    }

    function transBy($trans_id, $lang){
        $translation = Translation::where('trans_id', $trans_id)->where('lang', $lang)->first();

        if(!empty($translation)){
            return $translation->value;
        }

        return 'N/A';
    }

    function transAll($trans_id){
        $translations = Translation::select(['lang', 'value'])->where('trans_id', $trans_id)->get();

        $arr = [];

        foreach($translations as $trans){
            $arr[$trans->lang] = $trans->value;
        }

        if(!empty($arr)){
            return $arr;
        }

        return 'N/A';
    }
}