@extends('layouts.app')

@section('menu')
<div class="card">   
    <div class="list-group">
        @foreach($categories as $category)
        <a class="list-group-item list-group-item-action" href="{{ route('home.category', ['category' => $category->id])}}">
        <i class="fa {{ $category->icon}}"></i>&nbsp;{{ $category->name }}</a>
        @endforeach
    </div>
</div>

@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">          
            @foreach($data as $category)
            <div class="row">               
               <div class="col-md-12">  
                    <h2><i class="fa {{ $category->icon}}"></i>&nbsp;{{$category->name}}</h2>     
                   <div class="row">
                   @foreach($category->productshome as $product)
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
            </div>  
            @endforeach           
        </div>
    </div>
</div>
@endsection
