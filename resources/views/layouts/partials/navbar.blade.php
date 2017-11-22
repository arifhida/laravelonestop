<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="{{ url('/') }}">One Stop Click</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">               
        @if (Auth::guest())
            <li><a href="{{ route('login') }}" class="btn btn-success">Login</a></li>
            <li><a href="{{ route('register') }}" class="btn btn-success">Register</a></li>
        @else        
            <!-- <li>
                <a href="#" data-toggle="modal" data-target="#cartModal"><i class="fa fa-shopping-cart" style="color:#fff;font-size:1.7em"></i><span class="badge badge-danger" id="totalCart"></span></a>
            </li> -->
            <li class="nav-item">
            
            <div class="dropdown show">
            <a class="btn btn-secondary dropdown-toggle" href="#" id="userlink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ Auth::user()->name }}
            </a>

            <div class="dropdown-menu" aria-labelledby="userlink">
                <a class="dropdown-item" href="#">Setting</a>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">Logout</a>
            
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
          
            </div>
            </div>
            
        @endif
        </ul>
    </div>
</nav>