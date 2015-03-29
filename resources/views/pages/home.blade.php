@extends('app')

@section('title')
  Diskollect
@endsection

@section('content')
  @if(Auth::check())
    @include('user.partials.sidebar')
    <div class="col-md-10">
      <div class="page-header">
        <p class="h1">Feed</p>
      </div>
    </div>
  @else
    <div id="welcome">
      <div class="header">
        <h1>Your vinyls new home.</h1>
        <h2>Build. Manage. Rediscover.</h2>
        <div class="cta">
          <a href="{{ route('register') }}" class="btn btn-lg btn-primary btn-header">Start here.</a>
        </div>
      </div>
      
    </div>
  @endif
@endsection
