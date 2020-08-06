<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;

use App\Product;
use App\Order;

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

        $description = "Orden de pago para la compra de un/una $product->title por $product->price $ ARS. Para recibir la orden de pago por email vuelva a la página anterior e inicie sesión.";

        $postfields = array("total" => $product->price, "description" => $description, "return_url" => route('home', ['code' => 1]));
        
        if (auth()->user()) {
            $postfields["description"] = "Orden de pago para la compra de un/una $product->title por $product->price $ ARS.";
            $email = auth()->user()->email;
            $postfields["email"] = $email;
        } 

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.mobbex.com/p/payment_order",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($postfields),
        CURLOPT_HTTPHEADER => array(
            "x-api-key: zJ8LFTBX6Ba8D611e9io13fDZAwj0QmKO1Hn1yIj",
            "x-access-token: d31f0721-2f85-44e7-bcc6-15e19d1a53cc",
            "Content-Type: application/json"
        ),
        ));

        $response = json_decode(curl_exec($curl));

        curl_close($curl);

        if ($response->result) {
            return redirect($response->data->url);
        } else {
            return redirect('/?code=2');
        }
        
    }
    
    public function checkout($id)
    {
        $product = Product::find($id);

        $order = new Order();
        $order->product_id = $product->id;
        $order->user_id = auth()->user()->id;
        $order->status = 'Nuevo';
        $order->total_price = $product->price;
        $order->save();
        
        $reference = $order->id;

        $description = "Compra de un/una $product->title por $product->price $ ARS.";

        $postfields = array("total" => $product->price,"currency" => "ARS", "description" => $description, "return_url" => route('home'), "reference" => $reference, "test" => true);

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.mobbex.com/p/checkout",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS =>json_encode($postfields),
        CURLOPT_HTTPHEADER => array(
            "x-api-key: zJ8LFTBX6Ba8D611e9io13fDZAwj0QmKO1Hn1yIj",
            "x-access-token: d31f0721-2f85-44e7-bcc6-15e19d1a53cc",
            "Content-Type: application/json"
        ),
        ));

        $response = json_decode(curl_exec($curl));

        curl_close($curl);

        if ($response->result) {
            return redirect($response->data->url);
        } else {
            return redirect('/?code=3');
        }
    }
}
