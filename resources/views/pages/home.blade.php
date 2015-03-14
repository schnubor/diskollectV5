@extends('app')

@section('title')
  Diskollect
@endsection

@section('content')
	<div class="container">
    @if(Auth::check())
  		<div class="row">
        <div class="col-md-4 text-center">
          <div class="avatar-big center-block" style="background-image: url('{{ Auth::user()->image }}')"></div>
          <h1>{{ Auth::user()->username }}</h1>
          @if(Auth::user()->name || Auth::user()->location || Auth::user()->website || Auth::user()->description)
            <hr>
            <p class="lead">
              @if(Auth::user()->name)
                <span>{{ Auth::user()->name }},</span>
              @endif
              @if(Auth::user()->location)
                <span>{{ Auth::user()->location }},</span>
              @endif
              @if(Auth::user()->website)
                <span><a href="{{ Auth::user()->website }}" target="_blank">{{ Auth::user()->website }}</a></span>
              @endif
              @if(Auth::user()->description)
                <hr><span class="lead">{{ Auth::user()->description }}</span>
              @endif
            </p>
          @endif
        </div>
        <div class="col-md-8">
          
        </div>
      </div>
    @else
      <h1>Welcome</h1>
      <p>This is the homepage</p>
      <a href="{{ route('login') }}" class="btn btn-md btn-primary"><i class="fa fa-fw fa-sign-in"></i> Sign in</a>
      <a href="{{ route('register') }}" class="btn btn-md btn-primary"><i class="fa fa-fw fa-edit"></i> Register</a>
    @endif
	</div>
@endsection
