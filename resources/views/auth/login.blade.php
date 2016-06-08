@extends('app')

@section('robots', 'all')
@section('title', 'Login')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="container text-center margin-top-50">
			<a href="/"><img src="/images/logo_dark.png" alt="The Record Logo" width="100px"></a>
		</div>
	</div>

	<div class="row">
		<div class="container">
			<div class="panel panel-default margin-top">
				<div class="panel-heading">Login</div>
				<div class="panel-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong> There were some problems with your input.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					{!! Form::open([ 'route' => 'post.login', 'class' => 'form-horizontal']) !!}

						<div class="form-group">
							{!! Form::label('username', 'Username', ['class' => 'col-md-4 control-label']) !!}
							<div class="col-md-6">
								{!! Form::text('username', Input::old('username'), ['class' => 'form-control']) !!}
							</div>
						</div>

						<div class="form-group">
							{!! Form::label('password', 'Password', ['class' => 'col-md-4 control-label']) !!}
							<div class="col-md-6">
								{!! Form::password('password', ['class' => 'form-control']) !!}
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<div class="checkbox">
									<label>
										<input type="checkbox" name="remember"> Remember Me
									</label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								{!! Form::submit('Login', array('class' => 'btn btn-md btn-primary')) !!}

								<a href="/password/email">Forgot Your Password?</a>
							</div>
						</div>
					{!! Form::close() !!}
				</div>
			</div>
			<p class="lead text-center">
				Don't have an account yet? <a href="{{route('register')}}">Sign up here!</a>
			</p>
		</div>
	</div>
</div>
@endsection
