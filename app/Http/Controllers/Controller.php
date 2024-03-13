<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Product_Master;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    function show(){
        Product_Master::all();
        return view('index');
    }

}
