@extends('layouts.admin')
@section('content')
    <div class="container">
        <h2>Edit {{$category->name}}</h2>       
        <form class="form-inline" method="POST" action="{{ route('category.update',[$category->id]) }}">
            {{ csrf_field() }}      
            {{ method_field('PUT') }}      
            <div class="form-group">
                <label>Category Name</label>
                <input type="text" name="name" value="{{$category->name}}" />
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