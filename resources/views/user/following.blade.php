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
          @include('user.partials.dropdown')
        @endif
      @else
        @include('user.partials.dropdown')
      @endif
    </div>

    {{-- Content --}}
    <div class="container content">
      @if($followings->count())
        @foreach(array_chunk($followings->all(), 6) as $followerRow)
          <div class="row padding15">
            @foreach($followerRow as $follower)
              <div class="col-sm-4 collector">
                <div class="thumbnail">
                  <a href="{{ route('user.show', $follower->id) }}"><div class="avatar big edgy pull-left" style="background-image: url('{{ $follower->image }}');"></div></a>
                  <div class="caption pull-left">
                    <p class="h4"><a href="{{ route('user.show', $follower->id) }}"><strong class="username">{{ $follower->username }}</strong></a></p>
                    <p>{{ $follower->vinyls->count() }} Records</p>
                    <div class="text-left">@include('user.partials.follow', ['user' => $follower])</div>
                    <div class="section-buttons">
                        <hr>
                        <a href="{{ route('user.show', $follower->id) }}" class="button statistics sm" data-toggle="tooltip" data-placement="bottom" title="Statistics" data-original-title="Statistics"><i class="fa fa-area-chart"></i></a>
                        <a href="{{ route('user.collection', $follower->id) }}" class="button collection sm" data-toggle="tooltip" data-placement="bottom" title="Collection" data-original-title="Collection"><i class="fa fa-database"></i></a>
                        <a href="{{ route('user.jukebox', $follower->id) }}" class="button jukebox sm" data-toggle="tooltip" data-placement="bottom" title="Jukebox" data-original-title="Jukebox"><i class="fa fa-play"></i></a>
                        <a href="{{ route('user.following', $follower->id) }}" class="button friends sm" data-toggle="tooltip" data-placement="bottom" title="Friends" data-original-title="Friends"><i class="fa fa-users"></i></a>
                    </div>
                  </div>
                  <div style="clear: both;"></div>
                </div>
              </div>
            @endforeach
          </div>
        @endforeach
      @else
        <div class="col-md-12 text-center">
          <p class="placeholder">Not following anyone yet.</p>
          @if(Auth::check())
              @if(Auth::user()->id == $user->id)
                <a href="{{ route('user.index') }}" class="btn btn-primary btn-lg"><i class="fa fa-fw fa-users"></i> Collectors</a>
              @endif
          @endif
        </div>
      @endif

      <div class="row text-center">
        {!! $followings->render() !!}
      </div>
    </div>
  </div>

  {{-- Sidebar --}}
  @include('user.partials.sidebar')
@endsection
