@extends('layouts.admin')
@section('content')
    <div class="container">
        <h2>{{ $data->product_name }}</h2>
        <div class="row">
            <div class="col-md-6">
                <form action="" method="post">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                    <div class="form-group">
                        <label for="category">Category</label>                        
                        <select class="form-control" name="category_id">
                            @foreach($categories as $category)
                                @if($category->id == $data->category_id)                                
                                    <option value="{{$category->id}}" selected>{{ $category->name }}</option>
                                @else
                                    <option value="{{$category->id}}">{{ $category->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Product Name</label>
                        <input type="text" name="product_name" class="form-control" value="{{$data->product_name}}" />
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" class="form-control">{{$data->description}}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Price</label>
                        <input type="number" step="any" name="price" class="form-control" value="{{$data->price}}"/>
                    </div>
                    <div class="form-group">
                        <label>files</label>
                        <input type="file" name="downloadurl" class="form-control"/>
                    </div>
                    <button class="btn btn-primary" type="submit">Save</button>
                </form>
            </div>
            <div class="col-md-6">
                <div class="row">
                    @foreach($data->images as $image)
                        <div class="col-md-4">
                            <img src="{{$image->image_url}}" class="img-fluid" alt=""/>
                            <button type="button" class="btn btn-danger btn-block"><i class="fa fa-trash"></i></button> 
                        </div>                                       
                    @endforeach
                </div>  
                <div class="row">
                    <div class="col-md">
                        <h2>Upload new Thumbnail</h2>
                        <form action="" method="post">
                            <div class="form-group">
                                <label>thumbnails</label>
                                <input type="file" name="image" class="form-control"/>
                            </div>
                        </form>
                    </div>                    
                </div>              
            </div>
        </div>
    </div>
@endsection