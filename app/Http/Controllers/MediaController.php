<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Media::get();

        return view('inno.modules.media', compact(['items']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $destination = 'uploads';

        $item = new Media;    
        $file = $request->file;
        $extension = $file->getClientOriginalExtension();
        $orig_name = $file->getClientOriginalName();

        $photo_exts = ['jpg', 'png', 'jpeg', 'webp', 'gif'];
        $video_exts = ['mov', 'mp4', 'avi'];
        $doc_exts = ['pdf', 'doc', 'xlsx', 'docx'];

        if(in_array($extension, $photo_exts)){
            $item->type = 'photo';
        } else if(in_array($extension, $video_exts)){
            $item->type = 'video';
        } else if(in_array($extension, $doc_exts)){
            $item->type = 'doc';
        } else{
            $item->type = 'file';
        }

        if($item->type == 'photo'){
            $name = 'photo_'.time().'_'.$orig_name;
            $url = $destination.'/'.$name;

            $img = Image::make($file->getRealPath());
            $compress = $request->compress;

            if($extension=='gif'){
                $img->save(public_path($url));
            } else {
                if($compress){
                    $query = $img->resize($compress, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });

                    $query->save(public_path($url));
                } else{
                    $img->save(public_path($url));
                }
            }   
            $item->url = $url;
        } else {
            if($item->type == 'doc'){
                $name = 'doc_'.time().'_'.$orig_name;
            } else{
                $name = 'file_'.time().'_'.$orig_name;
            }
            if(!Storage::disk('public_uploads')->put($name, file_get_contents($file))) {
                return false;
            }

            $item->url = $destination.'/'.$name;
        }

        $item->name = $orig_name;
        $item->extension = $extension;
        $item->save();

        $items = Media::get();

        return response()->json([
            'success' => true,
            'html' => view('inno.components.media_list', compact('items'))->render(),
            'message' => 'Media uploaded successfully!'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Media $media)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Media $media)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Media $media)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Media $media)
    {
        //
    }
}
