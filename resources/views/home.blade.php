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
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Search"/>
                            <span class="input-group-btn">
                                <button class="btn btn-secondary" type="button">Go!</button>
                            </span>
                        </div>
                    </div>                    
                </div>
            </div>
            
        </div>
        <div class="col-md-12">          
            @foreach($data as $category)
            <div class="row">               
               <div class="col-md-12">  
                    <h2><i class="fa {{ $category->icon}}"></i>&nbsp;{{$category->name}}</h2>     
                   <div class="row">
                   @foreach($category->products as $product)
                        <div class="col-md-3">
                            <div class="card">
                                <img class="card-img-top" src="{{url('/storage/') .'/' . $product->images[0]->image}}" alt="Card image cap">
                                <div class="card-body">
                                    <h4 class="card-title"><a class="card-link" href="{{ route('home.detail',['product' => $product->id ])}}">{{$product->product_name}}</a></h4>
                                    <p class="card-text text-justify">{{ substr($product->description,0,40) }}</p>
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
