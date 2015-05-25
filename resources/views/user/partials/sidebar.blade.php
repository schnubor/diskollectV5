<div class="text-center sidebar">

  <!-- Follow Button -->
  @if(Auth::check())
    @unless(Auth::user()->id == $user->id)
      @include('user.partials.follow')
    @endunless
  @else
    @include('user.partials.follow')
  @endif
  <small class="text-center"><a href="{{ route('user.followers', $user->id) }}">{{ $user->followers->count() }} Follower</a> &middot; <a href="{{ route('user.following', $user->id) }}">{{ $user->following->count() }} Following</a></small>
  
  <div class="navigation">
    @if(Auth::check())
      @if(Auth::user()->id == $user->id)
        <a href="{{ route('home') }}">
          @if(Request::url() == route('home'))
            <div class="button orange active">
          @else
            <div class="button orange">
          @endif
            <i class="fa fa-fw fa-th-large"></i>
          </div>
        </a>
      @endif
    @endif

    <a href="{{ route('user.collection', $user->id) }}">
      @if(Request::url() == route('user.collection', $user->id))
        <div class="button blue active">
      @else
        <div class="button blue">
      @endif
        <i class="fa fa-fw fa-database"></i>
      </div>
    </a>

    <a href="{{ route('user.show', $user->id) }}">
      @if(Request::url() == route('user.show', $user->id))
        <div class="button green active">
      @else
        <div class="button green">
      @endif
        <i class="fa fa-fw fa-area-chart"></i>
      </div>
    </a>

    <a href="{{ route('user.jukebox', $user->id) }}">
      @if(Request::url() == route('user.jukebox', $user->id))
        <div class="button purple active">
      @else
        <div class="button purple">
      @endif
        <i class="fa fa-fw fa-music"></i>
      </div>
    </a>

    <!-- Settings -->
    <a href="{{ route('get.edit.user', $user->id) }}">
      @if(Request::url() == route('get.edit.user', $user->id))
        <div class="button grey active">
      @else
        <div class="button grey">
      @endif
        <i class="fa fa-fw fa-cogs"></i>
      </div>
    </a>
  </div>

  <!-- Avatar -->
  <a href="{{ route('user.show', $user->id) }}"><div class="avatar sb center-block edgy" style="background-image: url('{{ $user->image }}')"></div></a>

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