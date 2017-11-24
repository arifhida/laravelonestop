@extends('layouts.app')

@section('menu')
<div class="card">  
    <div class="list-group">
        @foreach($categories as $category)
        @if($category->id == $id)
            <a class="list-group-item list-group-item-action active" href="{{ route('home.category', ['category' => $category->id])}}">
            <i class="fa {{ $category->icon}}"></i>&nbsp;{{ $category->name }}</a>
        @else
            <a class="list-group-item list-group-item-action" href="{{ route('home.category', ['category' => $category->id])}}">
            <i class="fa {{ $category->icon}}"></i>&nbsp;{{ $category->name }}</a>
        @endif
        @endforeach
    </div>
</div>
@endsection
@section('content')
    <div class="container">
        <div class="row">            
            @foreach($data as $product)
                <div class="col-md-3">
                    <div class="card">
                        <img class="card-img-top" src="{{url('/storage/') .'/' . $product->images[0]->image}}" alt="Card image cap">
                        <div class="card-body">
                            <h4 class="card-title">{{$product->product_name}}</h4>
                            <p class="card-text">{{$product->description}}</p>
                        </div>
                        <div class="card-footer text-muted text-right">
                            <label>Rp. {{number_format($product->price,2,',','.')}}</label>                                    
                        </div>
                    </div>
                </div>
            @endforeach            
        </div>
    </div>
@endsection