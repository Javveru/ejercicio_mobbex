<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Product;
use Illuminate\Support\Facades\Lang;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $products = Product::paginate(10);
        $vac = array('products' => $products);

        if ($request->code && $request->code == 2) {
            $vac['msg'] = 'The payment order could not be generated';
        } elseif ($request->code && $request->code == 1) {
            $vac['msg'] = 'The payment order has been generated correctly';
        }

        return view('home', compact('vac'));
    }
}
