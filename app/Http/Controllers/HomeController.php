<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class HomeController extends Controller
{
    //
    public function contact(){
        return view('contact');
    }

    public function category($category){

        $category = Category::with('products')->where('slug', $category)->first();
        if(empty($category)){
            abort(404);
        }
        return view('category',compact('category'));
    }
}
