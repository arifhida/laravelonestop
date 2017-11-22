@extends('layouts.admin')
@section('content')
    <div class="container">
        <h2>Add new Category</h2>       
        <form class="form-inline" method="POST" action="/category">
            {{ csrf_field() }}
            <div class="form-group">
                <label>Category Name</label>
                <input type="text" name="name" />
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>    
        @if($errors->any()) 
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error}}</li>
                    @endforeach
                </ul>
            </div>    
        @endif   
    </div>
@endsection