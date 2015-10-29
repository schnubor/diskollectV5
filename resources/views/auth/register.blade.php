@extends('app')

@section('title')
	Register
@endsection

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="container text-center margin-top-50">
			<a href="/"><img src="/images/logo_dark.png" alt="For the Record Logo" width="100px"></a>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default margin-top">
				<div class="panel-heading">Register</div>
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

					{!! Form::open([ 'route' => 'post.register', 'class' => 'form-horizontal']) !!}
						<div class="form-group">
							{!! Form::label('username', 'Username', ['class' => 'col-md-4 control-label']) !!}
							<div class="col-md-6">
								{!! Form::text('username', Input::old('username'), ['class' => 'form-control', 'placeholder' => 'Required']) !!}
							</div>
						</div>

						<div class="form-group">
							{!! Form::label('email', 'E-Mail Address', ['class' => 'col-md-4 control-label']) !!}
							<div class="col-md-6">
								{!! Form::text('email', Input::old('email'), ['class' => 'form-control', 'placeholder' => 'Required']) !!}
							</div>
						</div>

						<div class="form-group">
	            {!! Form::label('currency', 'Currency', ['class' => 'col-md-4 control-label']) !!}
	            <div class="col-md-6">
	              {!! Form::select('currency', [
                    'EUR' => '&euro; - Euro', 
                    'USD' => '&#36; - United States Dollar', 
                    'GBP' => '&pound; - Great Britain Pound'
                  ], 'EUR', ['class' => 'form-control']) !!}
	            </div>
	          </div>

						<div class="form-group">
							{!! Form::label('password', 'Password', ['class' => 'col-md-4 control-label']) !!}
							<div class="col-md-6">
								{!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Required']) !!}
							</div>
						</div>

						<div class="form-group">
							{!! Form::label('password_confirmation', 'Confirm password', ['class' => 'col-md-4 control-label']) !!}
							<div class="col-md-6">
								{!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Required']) !!}
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								{!! Form::submit('Register', array('class' => 'btn btn-lg btn-primary pull-right')) !!}
							</div>
						</div>
					{!! Form::close() !!}
				</div>
			</div>
			<p class="lead text-center">
				Already have an account? <a href="{{route('login')}}">Sign in here!</a>
			</p>
		</div>
	</div>
</div>
@endsection
