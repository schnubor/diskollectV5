@extends('app')

@section('title')
  Diskollect
@endsection

@section('content')
	<div class="jumbotron" style="margin-top: -50px;">
		<div class="container">
			<h1>Welcome</h1>
			<p>This is the homepage</p>
      <a href="{{ route('login') }}" class="btn btn-md btn-primary"><i class="fa fa-fw fa-sign-in"></i> Sign in</a>
      <a href="{{ route('register') }}" class="btn btn-md btn-primary"><i class="fa fa-fw fa-edit"></i> Register</a>
		</div>
	</div>
@endsection
