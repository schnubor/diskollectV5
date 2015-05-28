@extends('app')

@section('title')
  {{ $user->username }}'s Followings
@endsection

@section('content')
  <div class="content-area">
    <div class="col-md-12 toolbar">
      {{-- Controls --}}
      @if(Auth::check())
        @if(Auth::user()->id == $user->id)
          <p class="lead"><strong>Collectors you are following</strong></p>
        @else
          <div class="avatar sm" style="background-image: url('{{ $user->image }}')"></div>
          <div class="lead dropdown">
            <strong class="toggle-dropdown" data-toggle="dropdown" aria-expanded="false" id="userDropdown" role="button">{{ $user->username }}<span class="caret"></span></strong>
            <ul class="dropdown-menu" role="menu" aria-labelledby="userDropdown">
              <li role="presentation"><a role="menuitem" tabindex="-1" href="{{ route('user.collection', $user->id) }}"><i class="fa fa-fw fa-database"></i> Collection</a></li>
              <li role="presentation"><a role="menuitem" tabindex="-1" href="{{ route('user.show', $user->id) }}"><i class="fa fa-fw fa-area-chart"></i> Statistics</a></li>
              <li role="presentation"><a role="menuitem" tabindex="-1" href="{{ route('user.jukebox', $user->id) }}"><i class="fa fa-fw fa-music"></i> Jukebox</a></li>
            </ul>
          </div>
          <div class="pull-right">@include('user.partials.follow')</div>
        @endif
      @else
        <div class="avatar sm" style="background-image: url('{{ $user->image }}')"></div>
        <div class="lead dropdown">
          <strong class="toggle-dropdown" data-toggle="dropdown" aria-expanded="false" id="userDropdown" role="button">{{ $user->username }}<span class="caret"></span></strong>
          <ul class="dropdown-menu" role="menu" aria-labelledby="userDropdown">
            <li role="presentation"><a role="menuitem" tabindex="-1" href="{{ route('user.collection', $user->id) }}"><i class="fa fa-fw fa-database"></i> Collection</a></li>
            <li role="presentation"><a role="menuitem" tabindex="-1" href="{{ route('user.show', $user->id) }}"><i class="fa fa-fw fa-area-chart"></i> Statistics</a></li>
            <li role="presentation"><a role="menuitem" tabindex="-1" href="{{ route('user.jukebox', $user->id) }}"><i class="fa fa-fw fa-music"></i> Jukebox</a></li>
          </ul>
        </div>
        <div class="pull-right">@include('user.partials.follow')</div>
      @endif
    </div>

    {{-- Content --}}
    <div class="col-md-12 content">
      @if($followings->count())
        @foreach(array_chunk($followings->all(), 4) as $followerRow)
          <div class="row col-md-12">
            @foreach($followerRow as $follower)
              <div class="col-sm-2 collector">
                <div class="thumbnail">
                  <a href="{{ route('user.show', $follower->id) }}"><div class="avatar" style="background-image: url('{{ $follower->image }}');"></div></a>
                  <div class="caption">
                    <p class="h4"><a href="{{ route('user.show', $follower->id) }}"><strong>{{ $follower->username }}</strong></a></p>
                    <p>{{ $follower->vinyls->count() }} Records</p>
                    <div class="text-left">@include('user.partials.follow')</div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        @endforeach
      @else
        <div class="col-md-12 text-center">
          <p class="placeholder">Following noone.</p>
          @if(Auth::user()->id == $user->id)
            <a href="{{ route('user.index') }}" class="btn btn-primary btn-lg"><i class="fa fa-fw fa-users"></i> Collectors</a>
          @endif
        </div>
      @endif
      
      <div class="text-center">
        {!! $followings->render() !!}
      </div>
    </div>
  </div>

  {{-- Sidebar --}}
  @include('user.partials.sidebar')
@endsection