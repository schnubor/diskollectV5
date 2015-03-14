@extends('app')

@section('title')
  Edit Password
@endsection

@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">Edit Password</div>
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

            {!! Form::open([ 'route' => 'post.edit.password', 'class' => 'form-horizontal']) !!}

              <div class="form-group">
                {!! Form::label('old', 'Current password', ['class' => 'col-md-4 control-label']) !!}
                <div class="col-md-6">
                  {!! Form::password('old', ['class' => 'form-control', 'placeholder' => 'Required']) !!}
                </div>
              </div>

              <div class="form-group">
                {!! Form::label('new', 'New password', ['class' => 'col-md-4 control-label']) !!}
                <div class="col-md-6">
                  {!! Form::password('new', ['class' => 'form-control', 'placeholder' => 'Required']) !!}
                </div>
              </div>

              <div class="form-group">
                {!! Form::label('confirm', 'Current password again', ['class' => 'col-md-4 control-label']) !!}
                <div class="col-md-6">
                  {!! Form::password('confirm', ['class' => 'form-control', 'placeholder' => 'Required']) !!}
                </div>
              </div>

              <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                  {!! Form::submit('Edit password', array('class' => 'btn btn-md btn-primary pull-right')) !!}
                </div>
              </div>

            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection