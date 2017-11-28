@extends('layouts.admin')
@section('content')
    <div class="container">
        <h2>{{ $data->product_name }}</h2>
        <div class="row">
            <div class="col-md-6">
                <form action="{{ route('product.update',['product' => $data->id])}}" class="form-horizontal" id="frmEdit" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                    <div class="form-group">
                        <label for="category">Category</label>                        
                        <select class="form-control" name="category_id" id="category_id">
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
                        <label>Sub Category</label>
                        <select name="sub_category_id" id="subcategory" class="form-control">
                        @foreach($subcategories as $subcategory)
                            @if($subcategory->id == $data->sub_category_id)                                
                                <option value="{{$subcategory->id}}" selected>{{ $subcategory->name }}</option>
                            @else
                                <option value="{{$subcategory->id}}">{{ $subcategory->name }}</option>
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
                            <button type="submit" class="btn btn-danger btn-block" onclick="deleteImage({{$image->id}})"><i class="fa fa-trash"></i></button> 
                        </div>                                       
                    @endforeach
                </div>  
                <div class="row">
                    <div class="col-md">
                        <h2>Upload new Thumbnail</h2>
                        <form method="post" action="{{ route('Image.store') }}" enctype="multipart/form-data" id="frmUpload">
                            <div class="form-group">
                                <label>thumbnails</label>
                                <input type="file" name="image" class="form-control" required/>
                            </div>
                            {{ csrf_field() }}
                            <input type="hidden" name="product_id" value="{{$data->id}}"/>
                            <button type="submit" class="btn btn-primary">upload</button>
                        </form>
                    </div>                    
                </div>              
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function(){
            $('#category_id').change(function(e){
                var $cat_id = e.target.value;
                getSub($cat_id);
            });
            $categoryid = $('#category_id').val();          
            
        });

            

        function getSub($id){
            $('#subcategory').empty();
            axios.get("{{ url('subcategory/parent/') }}" + "/"+ $id).then(function(response){
                $.each(response.data,function(idx,c){
                    $('#subcategory').append('<option value="'+ c.id+'">'+ c.name + '</option>')
                });
            }).catch(function(errors){
                console.log(errors);
            });
        }

        function deleteImage($id){
            axios.delete("{{ url('Image/')}}" + "/" + $id).then(function(response){
                location.reload(true);
            }).catch(function(errors){
                console.log(errors);
            });
        }
    </script>
@endsection