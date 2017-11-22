@extends('layouts.admin')
@section('content')
<div class="container">
    <h2>Create New Product</h2>
    <form method="POST" action="/product" enctype="multipart/form-data">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error}}</li>
                    @endforeach
                </ul>
            </div>  
        @endif
        {{ csrf_field() }}
        <div class="form-group">
            <label>Category</label>
            <select class="form-control" name="category_id">
                @foreach($categories as $category)
                    <option value="{{$category->id}}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Product Name</label>
            <input type="text" name="product_name" class="form-control" />
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label>Price</label>
            <input type="number" step="any" name="price" class="form-control"/>
        </div>
        <div class="form-group">
            <label>File</label>
            <input type="file" name="downloadurl" class="form-control"/>
        </div>
        <div class="form-group">
            <label>Thumbnail</label>
            <input type="file" name="images[]" multiple class="form-control" />
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>    
</div>

@endsection