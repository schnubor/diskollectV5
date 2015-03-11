<nav class="navbar navbar-inverse navbar-static-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle Navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="{{ route('home') }}">Diskollect</a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="">Collection</a></li>
      </ul>

      <ul class="nav navbar-nav navbar-right">
        @if (Auth::guest())
          <li><a href="{{ route('login') }}"><i class="fa fa-fw fa-sign-in"></i> Login</a></li>
          <li><a href="{{ route('register') }}"><i class="fa fa-fw fa-edit"></i> Register</a></li>
        @else
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
            <span class="profilePic" style="background-image: url('{{ Auth::user()->image }}')"></span> {{ Auth::user()->username }} <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
              <li><a href=""><i class="fa fa-fw fa-pencil"></i> Edit profile</a></li>
              <li><a href=""><i class="fa fa-fw fa-lock"></i> Change password</a></li>
              <li class="divider"></li>
              <li><a href="{{ route('get.logout') }}"><i class="fa fa-fw fa-sign-out"></i> Sign out</a></li>
            </ul>
          </li>
        @endif
      </ul>
    </div>
  </div>
</nav>