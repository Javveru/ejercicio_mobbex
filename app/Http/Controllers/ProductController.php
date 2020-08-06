<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;

use App\Product;

class ProductController extends Controller
{
    public function index($id)
    {
        $product = Product::find($id);
        return view('product', compact('product'));
    }

    public function order($id)
    {
        $product = Product::find($id);

        $description = "Compra de un/una $product->title por $product->price $ ARS.";

        $email = auth()->user()->email;

        if ($email == null) {
            $description = $description . "Para recibir la orden de pago por email primero debe iniciar sesión.";
        }

        $response = Curl::to('https://api.mobbex.com/p/payment_order')
        ->withHeaders( array( 'x-api-key' => 'zJ8LFTBX6Ba8D611e9io13fDZAwj0QmKO1Hn1yIj', 'x-access-token' => 'd31f0721-2f85-44e7-bcc6-15e19d1a53cc' ) )
        ->withContentType('application/json');
        if ($email == null) {
            $response->withData( array( 'total' => $product->price, 'description' => $description ) );
        } else {
            $response->withData( array( 'total' => $product->price, 'description' => $description, 'email' => $email ) );
        }
        $response->asJson( true )
        ->post();

        if ($response->status = 200) {
            $msg = 'Order successfully generated';
            $products = Product::paginate(10);
            $vac = array('msg' => $msg, 'products' => $products);
            return view('home', compact('vac'));
        } else {
            $msg = 'an unexpected error has occurred';
            $products = Product::paginate(10);
            $vac = array('msg' => $msg, 'products' => $products);
            return view('home', compact('vac'));
        }
    }
    
    public function checkout($id)
    {
        $product = Product::find($id);
        
        $description = "Compra de un/una $product->title por $product->price $ ARS.";

        $response = Curl::to('https://api.mobbex.com/p/payment_order')
        ->withHeaders( array( 'x-api-key' => 'zJ8LFTBX6Ba8D611e9io13fDZAwj0QmKO1Hn1yIj', 'x-access-token' => 'd31f0721-2f85-44e7-bcc6-15e19d1a53cc' ) )
        ->withContentType('application/json')
        ->withData( array( 'total' => $product->price, 'currency' => 'ARS', 'return_url' => '', 'description' => $description ) )
        ->asJson( true )
        ->post();
    }
}
