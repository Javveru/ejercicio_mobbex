@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                @foreach ($products as $product)
                <div class="card" style="width: 18rem; display: inline-block;">
                    <img src="@if ($product->photo)/storage/{{$product->photo}}.jpg @else/storage/imagenotfound.png @endif" class="card-img-top" alt="..." style="min-height: 225px;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->title }}</h5>
                        <h6>{{ $product->price }}$ ARS</h6>
                        <p class="card-text" style="max-height: 17ch;overflow: hidden;">{{ $product->description }}</p>
                        <a href="/product/{{$product->id}}" class="btn btn-primary">Buy now!</a>
                        <a href="#" class="btn btn-light">Add to cart</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
