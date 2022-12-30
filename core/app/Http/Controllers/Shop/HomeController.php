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
        return view("shop.index",[
            "pageTitle" => $shop->name,
        ]);
    }
}
