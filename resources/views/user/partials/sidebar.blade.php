<div class="text-center sidebar">

  <div class="sb-logo">
    <a href="{{ route('home') }}"><img src="/images/logo.png" alt="Dashboard"></a>
  </div>

  {{--
  <small class="text-center"><a href="{{ route('user.followers', $user->id) }}">{{ $user->followers->count() }} Follower</a> &middot; <a href="{{ route('user.following', $user->id) }}">{{ $user->following->count() }} Following</a></small>
  --}}
  
@if(Auth::check())
  <div class="navigation">
    <!-- Avatar -->
    <a href="{{ route('user.show', Auth::user()->id) }}"><div class="avatar sb center-block edgy" style="background-image: url('{{ Auth::user()->image }}')"></div></a>

    <a href="{{ route('home') }}" data-toggle="tooltip" data-placement="right" title="Dashboard" data-original-title="Dashboard">
      @if(Request::url() == route('home'))
        <div class="button orange active">
      @else
        <div class="button orange">
      @endif
        <i class="fa fa-fw fa-th-large"></i>
      </div>
    </a>

    <a href="{{ route('user.collection', Auth::user()->id) }}" data-toggle="tooltip" data-placement="right" title="Collection" data-original-title="Collection">
      @if(Request::url() == route('user.collection', Auth::user()->id))
        <div class="button blue active">
      @else
        <div class="button blue">
      @endif
        <i class="fa fa-fw fa-database"></i>
      </div>
    </a>

    <a href="{{ route('user.show', Auth::user()->id) }}" data-toggle="tooltip" data-placement="right" title="Statistics" data-original-title="Statistics">
      @if(Request::url() == route('user.show', Auth::user()->id))
        <div class="button green active">
      @else
        <div class="button green">
      @endif
        <i class="fa fa-fw fa-area-chart"></i>
      </div>
    </a>

    <a href="{{ route('user.jukebox', Auth::user()->id) }}" data-toggle="tooltip" data-placement="right" title="Jukebox" data-original-title="Jukebox">
      @if(Request::url() == route('user.jukebox', Auth::user()->id))
        <div class="button purple active">
      @else
        <div class="button purple">
      @endif
        <i class="fa fa-fw fa-music"></i>
      </div>
    </a>
  </div>
@endif

  <div class="bottom-nav">
    @if(Auth::check())
      <!-- Settings -->
      <a href="{{ route('user.settings', Auth::user()->id) }}" data-toggle="tooltip" data-placement="right" title="Settings" data-original-title="Settings">
        @if(Request::url() == route('user.settings', Auth::user()->id))
          <div class="button grey active">
        @else
          <div class="button grey">
        @endif
          <i class="fa fa-fw fa-cogs"></i>
        </div>
      </a>

      <!-- Add vinyl -->
      <a href="{{ route('get.search') }}" data-toggle="tooltip" data-placement="right" title="Add record" data-original-title="Add record">
        <div class="button add"><i class="fa fa-fw fa-plus"></i></div>
      </a>
    @else
      <!-- Register -->
      <a href="{{ route('register') }}" data-toggle="tooltip" data-placement="right" title="Register" data-original-title="Register">
        @if(Request::url() == route('register'))
          <div class="button grey active">
        @else
          <div class="button grey">
        @endif
          <i class="fa fa-fw fa-edit"></i>
        </div>
      </a>

      <!-- Login -->
      <a href="{{ route('login') }}" data-toggle="tooltip" data-placement="right" title="Login" data-original-title="Login">
        <div class="button add"><i class="fa fa-fw fa-sign-in"></i></div>
      </a>
    @endif
  </div>
</div>