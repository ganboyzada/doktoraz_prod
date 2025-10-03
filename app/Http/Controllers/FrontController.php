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
use App\Models\Slide;
use App\Models\PageMeta;
use App\Models\Translation;
use Spatie\Sitemap\SitemapGenerator;
use App\Models\Setting;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Route;


class FrontController extends Controller
{

    public function switchLang($code){
        $allowed = config('app.available_locales');

        if (!in_array($code, $allowed)) {
            return back();
        }

        session(['locale' => $code]);

        // Get previous URL
        $previousUrl = url()->previous();

        // Try to match previous URL to a named route
        $request = app('request')->create($previousUrl);
        $route = app('router')->getRoutes()->match($request);

        $routeName = $route->getName(); // previous route name
        $routeParams = $route->parameters(); // previous route parameters

        if ($routeName) {
            // Replace the lang in the route name if you use suffixes like home.az
            $newRouteName = $this->replaceLangInRouteName($routeName, $code);

            // Replace 'lang' param in route parameters
            if (isset($routeParams['lang'])) {
                $routeParams['lang'] = $code;
            }

            try {
                return redirect()->route($newRouteName, $routeParams);
            } catch (\Exception $e) {
                // fallback to previous URL if route generation fails
                return redirect($previousUrl);
            }
        }

        // fallback
        return redirect($previousUrl);
    }

    protected function replaceLangInRouteName(string $routeName, string $newLang): string
    {
        $pos = strrpos($routeName, '.');

        if ($pos === false) {
            return $routeName . '.' . $newLang;
        }

        return substr($routeName, 0, $pos + 1) . $newLang;
    }

    public function sitemap(){
        SitemapGenerator::create('https://doktoraz.az')->writeToFile('sitemap.xml');
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
        $page_meta = PageMeta::where('title', 'xeberler')->first();
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
        $related_posts = Blog::where('slug', '!=', $slug)->orderBy('created_at', 'desc')->get();
        $trans_ids = [];

        foreach(['title', 'excerpt', 'meta_tags', 'meta_desc', 'desc'] as $translatable){
            $trans_ids[] = $blogpost->{$translatable};
        }

        foreach($related_posts as $rpost){
            foreach(['title', 'excerpt'] as $translatable){
                $trans_ids[] = $rpost->{$translatable};
            }
        }

        $translations_temp = Translation::select(['trans_id', 'value'])->whereIn('trans_id', $trans_ids)->where('lang', app()->getLocale())->get()->toArray();
        $translations = array_combine(array_column($translations_temp, 'trans_id'), array_column($translations_temp, 'value'));
        
        return view('front.blogpost', compact(['blogpost','related_posts', 'translations']));
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
