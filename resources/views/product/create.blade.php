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
            <select class="form-control" name="category_id" id="category_id">
                <option disabled selected value="">--Select Category--</option>
                @foreach($categories as $category)
                    <option value="{{$category->id}}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Sub Category</label>
            <select class="form-control" name="sub_category_id" id="subcategory">
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
    </script>
@endsection