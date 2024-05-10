<header>
  <nav class="navbar navbar-expand-lg bg-body-tertiary" style="background-color: #0A0F15 !important">
    <div class="container d-flex justify-content-between">
     
        <a class="navbar-brand fw-semibold fs-3" href="http://localhost:5174/"><img src={{ asset("img/head-logo.png") }} style="max-height: 58px" alt=""></a>
   
      <button aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"
        class="navbar-toggler" data-bs-target="#navbarSupportedContent" data-bs-toggle="collapse" type="button">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse flex-row-reverse " id="navbarSupportedContent">
        <ul class="navbar-nav ">
          {{-- <li class="nav-item">
            <a @class(['nav-link', 'active' => Route::currentRouteName() == 'home']) aria-current="page" href="{{ route('home') }}">Home</a>
          </li> --}}
           @guest
            <li class="nav-item">
              <a class="nav-link" href="{{ route('login') }}">Login</a>
            </li>
            @if (Route::has('register'))
              <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">Registrati</a>
              </li>
            @endif
         
          @else
          <li class="nav-item">
            <a class="nav-link" href="{{ route('user.apartments.index') }}">I miei appartamenti</a>
          </li>
            <li class="nav-item dropdown">
              <a aria-expanded="false" aria-haspopup="true" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
                href="#" id="navbarDropdown" role="button" v-pre>
                @if(is_null( Auth::user()->name )) {{Auth::user()->email}}
                @else {{Auth::user()->name}}
                @endif
                
                
              </a>

              <div aria-labelledby="navbarDropdown" class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="{{ route('admin.dashboard') }}"> Dashboard</a>
                {{-- <a class="dropdown-item" href="{{ url('profile') }}"> Profile</a> --}}
                <a class="dropdown-item" href="{{ route('logout') }}" id="logout-link">
                  Logout
                </a>

                <form action="{{ route('logout') }}" class="d-none" id="logout-form" method="POST">
                  @csrf
                </form>
              </div>
            </li>
          @endguest
          </ul>
      </div>
    </div>
  </nav>
</header>
