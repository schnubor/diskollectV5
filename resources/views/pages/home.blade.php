@extends('app')

@section('title')
  Diskollect
@endsection

@section('content')
  @if(Auth::check())
    @include('user.partials.sidebar')
    <div class="col-md-10">
      <div class="page-header">
        <p class="h1">Dashboard</p>
      </div>
    </div>
  @else
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
