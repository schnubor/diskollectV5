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
      </div>

      <a href="{{ route('login') }}" class="btn btn-md btn-primary"><i class="fa fa-fw fa-sign-in"></i> Sign in</a>
      <a href="{{ route('register') }}" class="btn btn-md btn-primary"><i class="fa fa-fw fa-edit"></i> Register</a>
    </div>
  @endif
@endsection
