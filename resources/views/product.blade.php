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
                <div class="card" style="align-items: center;flex-flow: row;">
                    <aside style="width: 50%;border-right: #e4e4e4 1px solid;">
                        <img src="@if ($product->photo)/storage/{{$product->photo}}.jpg @else/storage/imagenotfound.png @endif" class="card-img-top" alt="...">
                    </aside>
                    <div class="card-body" style="width: 50%; flex-flow: wrap;">
                        <h2 class="card-title">{{ $product->title }}</h5>
                        <h5>{{ $product->price }}$ ARS</h6>
                        <p class="card-text">{{ $product->description }}</p>
                        <a href="/product/{{$product->id}}/checkout" class="btn btn-primary @guest only-users @endguest" style="margin: 4px;" @guest data-toggle="modal" data-target="#onlyUsersModal"@endguest>Checkout now!</a>
                        <a href="/product/{{$product->id}}/order" class="btn btn-secondary" style="margin: 4px;">Pay with bank transfer or deposit</a>
                        <a href="#" class="btn btn-light disabled" style="margin: 4px;">Add to cart</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@guest
<!-- Only-users Modal -->
<div class="modal fade" id="onlyUsersModal" tabindex="-1" role="dialog" aria-labelledby="onlyUsers" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">To use this function you must be logged in</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No thanks...</button>
        <a href="/login" type="button" class="btn btn-primary">Let's log in!</a>
      </div>
    </div>
  </div>
</div>
@endguest
@endsection
