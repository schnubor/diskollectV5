@extends('app')

@section('title')
	Reset Password
@endsection

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="container text-center margin-top-50">
			<a href="/"><img src="/images/logo_dark.png" alt="The Record Logo" width="100px"></a>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default margin-top">
				<div class="panel-heading">Reset Password</div>
				<div class="panel-body">
					@if (session('status'))
						<div class="alert alert-success">
							{{ session('status') }}
						</div>
					@endif

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

					{!! Form::open([ 'route' => 'post.password', 'class' => 'form-horizontal']) !!}
						<div class="form-group">
							{!! Form::label('email', 'E-Mail Address', ['class' => 'col-md-4 control-label']) !!}
							<div class="col-md-6">
								{!! Form::text('email', Input::old('email'), ['class' => 'form-control', 'placeholder' => 'Required']) !!}
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								{!! Form::submit('Send Password Reset Link', array('class' => 'btn btn-md btn-primary pull-right')) !!}
							</div>
						</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
