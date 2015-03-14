@extends('app')

@section('title')
  Edit profile
@endsection

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading">Edit profile</div>
        <div class="panel-body">
          
          <div class="row">
            <div class="col-md-4 col-md-offset-4">
              <div class="avatar center-block" style="background-image: url('{{ Auth::user()->image }}');"></div>
            </div>
          </div>

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
          
          <div class="row">
            <form class="form-horizontal" role="form" method="POST" action="{{ route('post.edit.user', Auth::user()->id) }}" enctype="multipart/form-data">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">

              <div class="form-group">
                <label class="col-md-4 control-label">Avatar</label>
                <div class="col-md-6">
                  <input type="file" class="form-control" name="avatar">
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-4 control-label">Full name</label>
                <div class="col-md-6">
                  <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}" placeholder="optional">
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-4 control-label">Location</label>
                <div class="col-md-6">
                  <input type="text" class="form-control" name="location" value="{{ Auth::user()->location }}" placeholder="optional">
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-4 control-label">Website</label>
                <div class="col-md-6">
                  <input type="text" class="form-control" name="website" value="{{ Auth::user()->website }}" placeholder="optional">
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-4 control-label">Description</label>
                <div class="col-md-6">
                  <input type="text" class="form-control" name="description" value="{{ Auth::user()->description }}" placeholder="optional">
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-4 control-label">Currency</label>
                <div class="col-md-6">
                  <select class="form-control" id="currency" name="currency">
                    <option value="EUR" selected="selected">€ - Euro</option>
                    <option value="USD">$ - United States Dollar</option>
                    <option value="GBP">£ - Great Britain Pound</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                  <button type="submit" class="btn btn-primary">
                    Update profile
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
