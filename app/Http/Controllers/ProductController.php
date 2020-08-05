<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Product;

class ProductController extends Controller
{
    public function index($id)
    {
        $product = Product::find($id);
        return view('product', compact('product'));
    }
}
