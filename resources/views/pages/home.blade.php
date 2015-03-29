@extends('app')

@section('title')
  Diskollect
@endsection

@section('content')
  @if(Auth::check())
    <div class="col-md-2 text-center sidebar">
      <div class="avatar md center-block" style="background-image: url('{{ Auth::user()->image }}')"></div>
      <p class="lead">{{ Auth::user()->username }}</p>
      <div class="navigation">
        <a href="">
          <div class="button active">
            <i class="fa fa-fw fa-bars orange"></i>
            <span>Feed</span>
            <div class="triangle"></div>
          </div>
        </a>
        <a href="">
          <div class="button">
            <i class="fa fa-fw fa-database blue"></i>
            <span>Collection</span>
            <div class="triangle"></div>
          </div>
        </a>
        <a href="">
          <div class="button">
            <i class="fa fa-fw fa-area-chart green"></i>
            <span>Statistics</span>
            <div class="triangle"></div>
          </div>
        </a>
        <a href="">
          <div class="button">
            <i class="fa fa-fw fa-music purple"></i>
            <span>Jukebox</span>
            <div class="triangle"></div>
          </div>
        </a>
      </div>
    </div>
    <div class="col-md-10">
      <div class="page-header">
        <p class="h1">Feed</p>
      </div>
    </div>
  @else
    <div id="welcome">
      <div class="header">
        <h1>Your vinyls new home.</h1>
      </div>

      <a href="{{ route('login') }}" class="btn btn-md btn-primary"><i class="fa fa-fw fa-sign-in"></i> Sign in</a>
      <a href="{{ route('register') }}" class="btn btn-md btn-primary"><i class="fa fa-fw fa-edit"></i> Register</a>
    </div>
  @endif
@endsection
