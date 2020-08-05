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
                @for ($i = 0; $i < 5; $i++)
                <div class="card" style="width: 18rem; display: inline-block;">
                    <img src="..." class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Product title</h5>
                        <h6>Product Price</h6>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a href="#" class="btn btn-primary">Buy now!</a>
                        <a href="#" class="btn btn-light">Add to cart</a>
                    </div>
                </div>
                @endfor
            </div>
        </div>
    </div>
</div>
@endsection
