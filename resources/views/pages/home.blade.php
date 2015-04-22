@extends('app')

@section('title')
  Diskollect
@endsection

@section('content')
  @if(Auth::check())
  {{-- Dashboard --}}
    @include('user.partials.sidebar')
    <div class="col-md-10 no-padding content-area">
      <div class="col-md-12 toolbar">
        <p class="lead">Latest news: The world is round.</p>
      </div>
      <div class="col-md-12 content">
        {{-- Activities --}}
        <div class="col-md-6 activities">
          <div class="panel panel-default">
            <div class="panel-heading"><strong>Activities</strong></div>
            <ul class="list-group">
              <li class="list-group-item">
                <div class="media">
                  <div class="media-left">
                    <a href="#">
                      <img class="media-object" src="/images/PH_user_large.png" alt="username" width="64px">
                    </a>
                  </div>
                  <div class="media-body">
                    <h4 class="media-heading"><a href="">Weltraum</a> added a new vinyl to his collection.</h4>
                    <p>Mon, 24.04.2015 - 12:45PM</p>
                    <div class="thumbnail">
                      <a href=""><img src="/images/PH_vinyl.svg" alt="artist" width="100%"></a>
                    </div>
                  </div>
                </div>
              </li>
              <li class="list-group-item">
                <div class="media">
                  <div class="media-left">
                    <a href="#">
                      <img class="media-object" src="/images/PH_user_large.png" alt="username" width="64px">
                    </a>
                  </div>
                  <div class="media-body">
                    <h4 class="media-heading"><a href="">Weltraum</a> added a new vinyl to his collection.</h4>
                    <p>Mon, 24.04.2015 - 12:45PM</p>
                    <div class="thumbnail">
                      <a href=""><img src="/images/PH_vinyl.svg" alt="artist" width="100%"></a>
                    </div>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>
        <div class="col-md-6">
          {{-- Latest Vinyls --}}
          <div class="panel panel-default">
            <div class="panel-heading"><strong>Latest Vinyls</strong></div>
            <div class="panel-body">
              <p>...</p>
            </div>
          </div>

          {{-- Latest Collectors --}}
          <div class="panel panel-default">
            <div class="panel-heading"><strong>Latest Collectors</strong></div>
            <div class="panel-body">
              <p>...</p>
            </div>
          </div>

        </div>
      </div>
    </div>
  @else
  {{-- Welcome Page --}}
    <div id="welcome">
      <div class="header">
        <h1>Your vinyls new home.</h1>
        <h2>Build. Manage. Rediscover.</h2>
        <div class="cta">
          <a href="{{ route('login') }}" class="btn btn-lg btn-primary btn-header">Start here.</a>
        </div>
      </div>
      
      <div class="container">
        <div class="intro row">
          <div class="col-md-4">
            <div class="text-center"><i class="fa fa-fw fa-line-chart"></i></div>
            <p>
              Dive into the numbers and keep track. We will create personlized statistics for your collection.
            </p>
          </div>
          <div class="col-md-4">
            <div class="text-center"><i class="fa fa-fw fa-cubes"></i></div>
            <p>
              Diskollect integrates with different APIs like Discogs or iTunes to get all the data you need. And has its own.
            </p>
          </div>
          <div class="col-md-4">
            <div class="text-center"><i class="fa fa-fw fa-share-alt"></i></div>
            <p>
              Easy to use. Build, manage, share and rediscover your collection at home or on the go.
            </p>
          </div>
        </div>
      </div>

      <div class="counter">
        <p>
          Tracking <span>{{$vinylCount}}</span> Vinyls of <span>{{$userCount}}</span> Collectors.
        </p>
      </div>
      
    </div>
  @endif
@endsection
