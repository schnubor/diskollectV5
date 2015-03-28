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
      <!-- Feed content -->
    </div>
  @else
    <h1>Welcome</h1>
    <p>This is the homepage</p>
    <a href="{{ route('login') }}" class="btn btn-md btn-primary"><i class="fa fa-fw fa-sign-in"></i> Sign in</a>
    <a href="{{ route('register') }}" class="btn btn-md btn-primary"><i class="fa fa-fw fa-edit"></i> Register</a>
  @endif
@endsection
