@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-8 mx-auto border">
                <h2 class="text-center">Login</h2>
                <hr/>
                <div class="row">
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Login with Email</h4>
                                <form class="form-vertical" method="POST" action="{{ route('login') }}">
                                    {{ csrf_field() }}

                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label for="email" class="control-label">E-Mail Address</label>                                    
                                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                        
                                    </div>

                                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                        <label for="password" class="control-label">Password</label>

                                        
                                            <input id="password" type="password" class="form-control" name="password" required>

                                            @if ($errors->has('password'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                        
                                    </div>

                                    <div class="form-group">                                    
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                                </label>
                                            </div>                                    
                                    </div>

                                    <div class="form-group">                                   
                                            <button type="submit" class="btn btn-primary btn-block">
                                                Login
                                            </button>

                                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                                Forgot Your Password?
                                            </a>                                    
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Login With Social Media</h4>
                                <hr/>
                                <a href="{{ route('social',['service' => 'google']) }}" class="btn btn-outline-danger btn-block"><i class="fa fa-google"></i>&nbsp;Login with Google</a>
                                <a href="{{route('social',['service' => 'github'])}}" class="btn btn-outline-dark btn-block"><i class="fa fa-github"></i>&nbsp;Login with Github</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row"><hr/></div>
            </div>
               
        </div>
        <!-- <div class="card mx-auto col-md-6">
            <div class="card-body">
                
            </div>
        </div> -->

        
    </div>
</div>
@endsection
