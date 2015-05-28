@extends('app')

@section('title')
  {{$user->username}}s Jukebox
@endsection

@section('content')
  @include('user.partials.sidebar')

  <div class="content-area">
    <div class="col-md-12 toolbar">
      @if(Auth::check())
        @if(Auth::user()->id == $user->id)
          <p class="lead"><strong>Your Jukebox</strong></p>
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

    <!-- Jukebox content -->
    <div class="col-md-12 content">
      @if($vinyls->count())
        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading"><strong class="js-vinylTitle"></strong></div>
                <div class="panel-body">
                    <a href="" class="js-link"><img src="" alt="" class="thumbnail js-cover" width="100%"></a>
                    <button class="btn-block btn btn-success btn-lg js-skip"><i class="fa fa-fw fa-step-forward"></i> Skip</button>
                </div>
            </div>
            
        </div>
        <div class="col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading js-videoTitle">
                    
                </div>
                <div class="panel-body">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe id="player" class="embed-responsive-item" src="" frameborder="0" enablejsapi="1"></iframe>
                    </div>
                </div>
            </div>
        </div>
      @else
        <div class="col-md-12 text-center">
          <p class="placeholder">Not enough vinyls in collection.</p>
          @if(Auth::check())
            @if(Auth::user()->id == $user->id)
              <a href="{{ route('get.search') }}" class="btn btn-primary btn-lg"><i class="fa fa-fw fa-plus"></i> Add vinyl</a>
            @endif
          @endif
        </div>
      @endif
    </div>
  </div>
@endsection

@section('scripts')
  <script>$.jukebox({!! $vinyls !!});</script>
@endsection