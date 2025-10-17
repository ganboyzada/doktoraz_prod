<?php

use App\Models\Media;
use App\Models\Translation;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;

if (!function_exists('media')) {
    /**
     * This function uploads files to the filesystem of your choice
     * @param \Illuminate\Http\UploadedFile $file The File to Upload
     * @param string|null $filename The file name
     * @param string|null $folder A specific folder where the file will be stored
     * @param string $disk Your preferred Storage location(s3,public,gcs etc)
     */

    function media($id, $multiple = false)
    {
        if (!$id) return false;

        $cacheKey = $multiple
            ? 'media_multiple_' . md5(json_encode($id))
            : 'media_single_' . $id;

        // Cache raw path(s) — NOT the full asset() URL
        $cached = Cache::rememberForever($cacheKey, function () use ($id, $multiple) {
            if ($multiple) {
                $ids = is_array($id) ? $id : json_decode($id, true);
                if (empty($ids)) return false;

                // store raw DB value(s)
                $media = Media::whereIn('id', $ids)->get()->pluck('url')->toArray();
                return $media ?: false;
            } else {
                $media = Media::find($id);
                return $media ? $media->url : false; // store relative path or DB url field
            }
        });

        if (!$cached) {
            return false;
        }

        // Resolve to absolute URLs at read-time using current APP_URL
        if ($multiple) {
            return array_map(fn($path) => asset($path), $cached);
        }

        return asset($cached);
    }


    if (!function_exists('translate')) {
        function translate($trans_id)
        {
            if ($trans_id === null) {
                return 'N/A';
            }

            $lang = app()->getLocale() ?: config('app.locale');
            $cacheKey = "translation.id.{$lang}.{$trans_id}";

            // Cache for 24 hours — model events can flush it sooner
            return Cache::rememberForever($cacheKey, function () use ($trans_id, $lang) {
                $translation = Translation::where('trans_id', $trans_id)
                    ->where('lang', $lang)
                    ->first(['value']);

                return $translation ? $translation->value : null;
            }) ?? '';
        }
    }

    if (!function_exists('s_trans')) {
        function s_trans($key, $tagged = false)
        {
            if ($key === null) {
                return '';
            }

            $lang = app()->getLocale();

            // create a unique cache key for this translation & language
            $cacheKey = "translation.{$lang}.{$key}";

            // attempt to get from cache, otherwise fetch from DB once
            $translation = Cache::rememberForever($cacheKey, function () use ($key, $lang) {
                $record = Translation::where('static', true)
                    ->where('key', $key)
                    ->where('lang', $lang)
                    ->first(['value']);
                return $record ? $record->value : null;
            });

            if (!empty($translation)) {
                return $tagged ? $translation : strip_tags($translation);
            }

            // fallback if translation not found
            return $key;
        }
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

    if (!function_exists('loc_route')) {
        function loc_route($name, $params = []) {
            $locale = app()->getLocale();
            return route($name.'.'.$locale, $params);
        }
    }
}