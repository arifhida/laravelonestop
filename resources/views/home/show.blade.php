@extends('layouts.app')
@section('menu')
<div class="card">  
    <div class="list-group">
        @foreach($categories as $category)
        @if($category->id == $data->category_id)
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
        <div class="card col-md-8">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">               
                        <div id="carrouselImage" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                @foreach($data->images as $image)
                                @if($loop->first)
                                <div class="carousel-item active">
                                    <img class="d-block mx-auto img-fluid" src="{{url('/storage/') .'/' .  $image->image}}" alt="slide">
                                </div>
                                @else
                                <div class="carousel-item">
                                    <img class="d-block mx-auto img-fluid" src="{{url('/storage/') .'/' .  $image->image}}" alt="slide">
                                </div>
                                @endif
                                @endforeach
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#carrouselImage" role="button" data-slide="prev">
                            <span class="fa fa-arrow-circle-left btn btn-outline-success" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carrouselImage" role="button" data-slide="next">
                            <span class="fa fa-arrow-circle-right  btn btn-outline-success" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>        
                    </div>
                    <div class="col-md-6">               
                        <h2>{{$data->product_name}}</h2>                    
                        <span class="font-weight-bold">Rp. {{number_format($data->price,2,',','.')}}</span>
                        <hr/>
                        <p class="card-text">{{ $data->description }}</p>                     
                        <button class="btn btn-success">download</button>
                    </div>
                </div>
            </div>    
        </div>          
    </div>
</div>
@endsection