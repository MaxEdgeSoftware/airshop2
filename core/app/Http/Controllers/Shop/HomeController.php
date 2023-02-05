<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index($domain){
        $domain = $domain.'.'.env('APP_CDN');
        $shop = Shop::where("domain", $domain)->first();
        return redirect(env("APP_URL")."/seller/{$shop->seller_id}-".slug($shop->name));
        return view("shop.index",[
            "pageTitle" => $shop->name,
        ]);
    }
}
