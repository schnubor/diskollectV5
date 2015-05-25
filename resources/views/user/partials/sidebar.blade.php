<div class="text-center sidebar">

  <!-- Follow Button -->
  @if(Auth::check())
    @unless(Auth::user()->id == $user->id)
      @include('user.partials.follow')
    @endunless
  @else
    @include('user.partials.follow')
  @endif

  <div class="sb-logo">
    <img src="/images/logo.png" alt="Dashboard">
  </div>
  {{--
  <small class="text-center"><a href="{{ route('user.followers', $user->id) }}">{{ $user->followers->count() }} Follower</a> &middot; <a href="{{ route('user.following', $user->id) }}">{{ $user->following->count() }} Following</a></small>
  --}}
  <div class="navigation">
    <!-- Avatar -->
    <a href="{{ route('user.show', $user->id) }}"><div class="avatar sb center-block edgy" style="background-image: url('{{ $user->image }}')"></div></a>

    <a href="{{ route('home') }}" data-toggle="tooltip" data-placement="right" title="Dashboard" data-original-title="Dashboard">
      @if(Request::url() == route('home'))
        <div class="button orange active">
      @else
        <div class="button orange">
      @endif
        <i class="fa fa-fw fa-th-large"></i>
      </div>
    </a>

    <a href="{{ route('user.collection', $user->id) }}" data-toggle="tooltip" data-placement="right" title="Collection" data-original-title="Collection">
      @if(Request::url() == route('user.collection', $user->id))
        <div class="button blue active">
      @else
        <div class="button blue">
      @endif
        <i class="fa fa-fw fa-database"></i>
      </div>
    </a>

    <a href="{{ route('user.show', $user->id) }}" data-toggle="tooltip" data-placement="right" title="Statistics" data-original-title="Statistics">
      @if(Request::url() == route('user.show', $user->id))
        <div class="button green active">
      @else
        <div class="button green">
      @endif
        <i class="fa fa-fw fa-area-chart"></i>
      </div>
    </a>

    <a href="{{ route('user.jukebox', $user->id) }}" data-toggle="tooltip" data-placement="right" title="Jukebox" data-original-title="Jukebox">
      @if(Request::url() == route('user.jukebox', $user->id))
        <div class="button purple active">
      @else
        <div class="button purple">
      @endif
        <i class="fa fa-fw fa-music"></i>
      </div>
    </a>
  </div>

  <div class="bottom-nav">
    <!-- Settings -->
    <a href="{{ route('get.edit.user', $user->id) }}" data-toggle="tooltip" data-placement="right" title="Settings" data-original-title="Settings">
      @if(Request::url() == route('get.edit.user', $user->id))
        <div class="button grey active">
      @else
        <div class="button grey">
      @endif
        <i class="fa fa-fw fa-cogs"></i>
      </div>
    </a>

    <!-- Avatar -->
    <a href="{{ route('get.search') }}" data-toggle="tooltip" data-placement="right" title="Add record" data-original-title="Add record">
      <div class="button add"><i class="fa fa-fw fa-plus"></i></div>
    </a>
  </div>

  @if(Auth::check())
    @unless(Auth::user()->id == $user->id)
      @if($user->name || $user->location || $user->website || $user->description)
        <p>
          @if($user->name)
            <span class="info">{{ $user->name }}</span><br>
          @endif
          @if($user->location)
            <span class="info">{{ $user->location }}</span><br>
          @endif
          @if($user->website)
            <span class="info"><a href="{{ $user->website }}" target="_blank">{{ $user->website }}</a></span><br>
          @endif
          @if($user->description)
            <hr><span>{{ $user->description }}</span>
          @endif
        </p>
      @endif
    @endunless
  @else
    @if($user->name || $user->location || $user->website || $user->description)
      <p>
        @if($user->name)
          <span class="info">{{ $user->name }}</span><br>
        @endif
        @if($user->location)
          <span class="info">{{ $user->location }}</span><br>
        @endif
        @if($user->website)
          <span class="info"><a href="{{ $user->website }}" target="_blank">{{ $user->website }}</a></span><br>
        @endif
        @if($user->description)
          <hr><span>{{ $user->description }}</span>
        @endif
      </p>
    @endif
  @endif
</div>