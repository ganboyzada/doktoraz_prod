<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Content;
use App\Models\Department;
use App\Models\Faq;
use Illuminate\Http\Request;
use App\Models\Language;
use App\Models\Member;
use App\Models\Project;
use App\Models\Slide;
use App\Models\GalleryPost;
use App\Models\PageMeta;
use App\Models\Product;
use App\Models\Translation;
use Spatie\Sitemap\SitemapGenerator;
use Dymantic\InstagramFeed\InstagramFeed;
use App\Models\Setting;

class FrontController extends Controller
{

    public function switchLang($code){
        $lang_setting = Setting::where('label', 'languages')->first();
        if(isset($lang_setting) && $lang_setting->status){
            if(in_array($code, Language::pluck('code')->toArray())){
                session()->put('locale', $code);
                
                return back();
            }
            else{
                return back();
            }
        } 
        return back();
    }

    public function sitemap(){
        SitemapGenerator::create('https://obsequio.ae')->writeToFile('sitemap.xml');
    }

    public function home(){

        $page_meta = PageMeta::where('title', 'home')->first();
        $trans_ids = [];
        $trans_ids[]=$page_meta->meta_tags;
        $trans_ids[]=$page_meta->meta_desc;

        $slides = Slide::where('featured', true)->get();

        foreach($slides as $slide){
            foreach(['title'] as $translatable){
                $trans_ids[] = $slide->{$translatable};
            }
        }

        // $questions = Faq::where('published', true)->take(4)->get();
        // foreach($questions as $question){
        //     foreach(['question', 'answer'] as $translatable){
        //         $trans_ids[] = $question->{$translatable};
        //     }
        // }
        
        $translations_temp = Translation::select(['trans_id', 'value'])->whereIn('trans_id', $trans_ids)->where('lang', app()->getLocale())->get()->toArray();
        $translations = array_combine(array_column($translations_temp, 'trans_id'), array_column($translations_temp, 'value'));
        
        return view('front.home', compact(['slides','translations', 'page_meta']));
        
    }

    public function services(){
        $trans_ids = [];

        $departments = Department::with('categories')->get();

        foreach($departments as $dep){
            foreach(['name', 'meta_tags'] as $translatable){
                $trans_ids[] = $dep->{$translatable};
            }
            foreach($dep->categories as $service){
                $trans_ids[] = $service->name;
            }
        }

        $translations_temp = Translation::select(['trans_id', 'value'])->whereIn('trans_id', $trans_ids)->where('lang', app()->getLocale())->get()->toArray();
        $translations = array_combine(array_column($translations_temp, 'trans_id'), array_column($translations_temp, 'value'));

        return view('front.services', compact(['translations','departments']));
    }

    public function service($slug){
        $trans_ids = [];
        $service = Category::where('slug', $slug)->first();
        $related_services = Category::where('parent_id', $service->parent_id)->get();

        foreach(['name', 'desc'] as $translatable){
            $trans_ids[] = $service->{$translatable};
            $trans_ids[] = $service->department->{$translatable};
        }

        foreach($service->members as $member){
            foreach(['designation'] as $translatable){
                $trans_ids[] = $member->{$translatable};
            }
        }
        foreach($related_services as $rel_service){
            foreach(['name'] as $translatable){
                $trans_ids[] = $rel_service->{$translatable};
            }
        }

        $translations_temp = Translation::select(['trans_id', 'value'])->whereIn('trans_id', $trans_ids)->where('lang', app()->getLocale())->get()->toArray();
        $translations = array_combine(array_column($translations_temp, 'trans_id'), array_column($translations_temp, 'value'));

        return view('front.service', compact(['translations','service', 'related_services']));
    }

    public function doctors(){
        $trans_ids = [];
        $active_service = request('service'); 
        $services = Category::get();
        $featured_doctors = Member::where('classified', true)->get();
        
        $doctors_query = Member::query();

        if($active_service){
            $doctors_query->where('category_id', $active_service);
        }

        $doctors = $doctors_query->get();

        foreach(['designation'] as $translatable){
            foreach($doctors as $doctor){
                $trans_ids[] = $doctor->{$translatable};
            }
            foreach($featured_doctors as $fdoctor){
                $trans_ids[] = $fdoctor->{$translatable};
            }
        }
        foreach($services as $service){
            foreach(['name'] as $translatable){
                $trans_ids[] = $service->{$translatable};
            }
        }

        $translations_temp = Translation::select(['trans_id', 'value'])->whereIn('trans_id', $trans_ids)->where('lang', app()->getLocale())->get()->toArray();
        $translations = array_combine(array_column($translations_temp, 'trans_id'), array_column($translations_temp, 'value'));

        return view('front.doctors', compact(['translations','doctors', 'featured_doctors', 'services', 'active_service']));
    }

    public function doctor($slug){
        $trans_ids = [];
        $doctor = Member::where('slug', $slug)->first();

        foreach(['designation', 'desc'] as $translatable){
            $trans_ids[] = $doctor->{$translatable};
        }

        foreach(['name'] as $translatable){
            $trans_ids[] = $doctor->category->{$translatable};
        }

        $translations_temp = Translation::select(['trans_id', 'value'])->whereIn('trans_id', $trans_ids)->where('lang', app()->getLocale())->get()->toArray();
        $translations = array_combine(array_column($translations_temp, 'trans_id'), array_column($translations_temp, 'value'));

        return view('front.doctor', compact(['translations','doctor']));
    }

    public function about_us(){
        $page_meta = PageMeta::where('title', 'about-us')->first();
        $trans_ids = [];
        // $trans_ids[]=$page_meta->meta_tags;
        // $trans_ids[]=$page_meta->meta_desc;
        // $content = Content::where('type', 'section')->where('name','about_us')->first();
        // $trans_ids[]=$content->value;

        // $translations_temp = Translation::select(['trans_id', 'value'])->whereIn('trans_id', $trans_ids)->where('lang', app()->getLocale())->get()->toArray();
        // $translations = array_combine(array_column($translations_temp, 'trans_id'), array_column($translations_temp, 'value'));
        
        // return view('front.about_us', compact(['content', 'translations', 'page_meta']));
        return view('front.about_us');
    }

    public function blog($deparment = null){
        $page_meta = PageMeta::where('title', 'articles')->first();
        $trans_ids = [];
        $trans_ids[]=$page_meta->meta_tags;
        $trans_ids[]=$page_meta->meta_desc;

        $blogposts = Blog::paginate(12);
        foreach($blogposts as $blogpost){
            foreach(['title', 'excerpt'] as $translatable){
                $trans_ids[] = $blogpost->{$translatable};
            }
        }
        
        $translations_temp = Translation::select(['trans_id', 'value'])->whereIn('trans_id', $trans_ids)->where('lang', app()->getLocale())->get()->toArray();
        $translations = array_combine(array_column($translations_temp, 'trans_id'), array_column($translations_temp, 'value'));
        
        
        return view('front.blog', compact(['blogposts', 'translations', 'page_meta']));
    }

    public function blogpost($slug){
        $blogpost = Blog::where('slug', $slug)->firstOrFail();
        return view('front.blogpost', compact(['blogpost']));
    }

    public function contact_us(){
        $page_meta = PageMeta::where('title', 'contact-us')->first();
        $trans_ids = [];
        $trans_ids[]=$page_meta->meta_tags;
        $trans_ids[]=$page_meta->meta_desc;
        
        $branches = Branch::get();
        foreach($branches as $branch){
            foreach(['name', 'address'] as $translatable){
                $trans_ids[] = $branch->{$translatable};
            }
        }
        
        $translations_temp = Translation::select(['trans_id', 'value'])->whereIn('trans_id', $trans_ids)->where('lang', app()->getLocale())->get()->toArray();
        $translations = array_combine(array_column($translations_temp, 'trans_id'), array_column($translations_temp, 'value'));
        
        return view('front.contact_us', compact(['branches', 'translations', 'page_meta']));
    }

    // public function gallery($type){
    //     $gallery_posts = GalleryPost::where('type', $type)->get();
    //     return view('front.gallery', compact(['type','gallery_posts']));
    // }
}
