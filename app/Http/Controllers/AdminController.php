<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;


class AdminController extends Controller
{
    public function dashboard(){
        return view('inno.dashboard');
    }

    public function switchLang($code){
        if(in_array($code, Language::pluck('code')->toArray())){
            session()->put('innolang', $code);
            
            return back();
        }
        else{
            return back();
        }
    }

    public function switchTheme($code){
        if(in_array($code, ['dark', 'light'])){
            session()->put('innotheme', $code);
            
            return back();
        }
        else{
            return back();
        }
    }
}
