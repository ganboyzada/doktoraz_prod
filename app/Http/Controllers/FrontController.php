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
use Illuminate\Support\Facades\Cache;


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
        $page_meta = Cache::remember("page_meta.home", now()->addHours(6), function () {
            return PageMeta::where('title', 'home')->first();
        });
        $slides = Slide::where('featured', true)->get();
        
        return view('front.home', compact(['slides', 'page_meta']));
        
    }

    public function services(){
        $page_meta = Cache::remember("page_meta.xidmetler", now()->addHours(6), function () {
            return PageMeta::where('title', 'xidmetler')->first();
        });
        $departments = Department::with('categories')->get();
        return view('front.services', compact(['departments', 'page_meta']));
    }

    public function service($slug){
        $service = Category::where('slug', $slug)->first();
        $related_services = Category::where('parent_id', $service->parent_id)->get();

        return view('front.service', compact(['service', 'related_services']));
    }

    public function doctors(){
        $page_meta = Cache::remember("page_meta.hekimler", now()->addHours(6), function () {
            return PageMeta::where('title', 'hekimler')->first();
        });

        $active_service = request('service'); 
        $services = Category::get();
        $featured_doctors = Member::where('classified', true)->get();
        
        $doctors_query = Member::query();

        if($active_service){
            $doctors_query->where('category_id', $active_service);
        }

        $doctors = $doctors_query->get();

        return view('front.doctors', compact(['doctors', 'featured_doctors', 'services', 'active_service', 'page_meta']));
    }

    public function doctor($slug){
        $doctor = Member::where('slug', $slug)->first();

        return view('front.doctor', compact(['doctor']));
    }

    public function about_us(){
        
        $page_meta = Cache::remember("page_meta.haqqimizda", now()->addHours(6), function () {
            return PageMeta::where('title', 'haqqimizda')->first();
        });
        
        return view('front.about_us', compact(['page_meta']));
    }

    public function blog($deparment = null){
        $page_meta = Cache::remember("page_meta.xeberler", now()->addHours(6), function () {
            return PageMeta::where('title', 'xeberler')->first();
        });
        
        $blogposts = Blog::paginate(12);

        return view('front.blog', compact(['blogposts', 'page_meta']));
    }

    public function blogpost($slug){
        $blogpost = Blog::where('slug', $slug)->firstOrFail();
        $related_posts = Blog::where('slug', '!=', $slug)->orderBy('created_at', 'desc')->get();
        
        return view('front.blogpost', compact(['blogpost','related_posts']));
    }

    public function contact_us(){
        $page_meta = PageMeta::where('title', 'contact-us')->first();
        
        $branches = Branch::get();
        
        return view('front.contact_us', compact(['branches', 'page_meta']));
    }
}
