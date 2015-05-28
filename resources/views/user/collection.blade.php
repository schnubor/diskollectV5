@extends('app')

@section('title')
  {{$user->username}}s Collection
@endsection

@section('content')
  <div class="content-area">
    <div class="col-md-12 toolbar">
      {{-- Pagination --}}
      @if($vinyls->count())
        <div class="pages pull-right">
          @if($vinyls->previousPageUrl())
            <a href="{{ $vinyls->previousPageUrl() }}"><i class="fa fa-angle-left arrow"></i></a>
          @else
            <a href="{{ $vinyls->previousPageUrl() }}" class="disabled"><i class="fa fa-angle-left arrow"></i></a>
          @endif
              <span>{!! $vinyls->currentPage() !!}/{!! $vinyls->lastPage() !!}</span>
          @if($vinyls->nextPageUrl())
            <a href="{{ $vinyls->nextPageUrl() }}"><i class="fa fa-angle-right arrow"></i></a>
          @else
            <a href="{{ $vinyls->nextPageUrl() }}" class="disabled"><i class="fa fa-angle-right arrow"></i></a>
          @endif
        </div>
      @endif

      {{-- Controls --}}
      @if(Auth::check())
        @if(Auth::user()->id == $user->id)
          <p class="lead"><strong>Your Collection</strong></p>
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
    <div class="col-md-12 content">
      @if($vinyls->count())
        @foreach(array_chunk($vinyls->all(), 4) as $vinylRow)
          <div class="row">
            @foreach($vinylRow as $vinyl)
              <div class="col-md-3 vinyl">
                <div class="cover">
                  <a href="{{ route('get.show.vinyl', $vinyl->id) }}"><img src="{{$vinyl->artwork}}" alt="{{$vinyl->artist}} - {{$vinyl->title}}"></a>
                </div>
                <div class="info">
                  <span class="artist">{{$vinyl->artist}}</span><br>
                  <span class="title">{{$vinyl->title}}</span>
                </div>
              </div>
            @endforeach
          </div>
        @endforeach
      @else
        <div class="col-md-12 text-center">
          <p class="placeholder">No vinyls in the collection yet.</p>
          @if(Auth::user()->id == $user->id)
            <a href="{{ route('get.search') }}" class="btn btn-primary btn-lg"><i class="fa fa-fw fa-plus"></i> Add vinyl</a>
          @endif
        </div>
      @endif

      <div class="text-center">
        {!! $vinyls->render() !!}
      </div>
    </div>
  </div>

  {{-- Sidebar --}}
  @include('user.partials.sidebar')
@endsection