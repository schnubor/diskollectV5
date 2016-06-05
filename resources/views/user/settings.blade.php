@extends('app')

@section('title')
  Settings
@endsection

@section('content')
  <div class="content-area">
    <div class="col-md-12 toolbar">
      <p class="lead"><strong>Settings</strong></p>
    </div>

    <div class="col-md-12 content" id="settings">
      {{-- Flash messages --}}
      <div class="col-md-12">
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
      </div>

      <!-- Profile -->
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading">Edit profile</div>
          {!! Form::model(Auth::user(), ['route' => 'post.edit.user', 'files' => true, 'class' => 'form-horizontal']) !!}
          <div class="panel-body">

              <div class="row">
                  <div class="col-md-4 col-md-offset-4">
                    <div class="avatar center-block" style="background-image: url('{{ Auth::user()->image }}');"></div>
                  </div>
              </div>

              <!-- Avatar -->
              <div class="form-group">
                {!! Form::label('avatar', 'Avatar', ['class' => 'col-md-4 control-label']) !!}
                <div class="col-md-6">
                  {!! Form::file('avatar', ['class' => 'form-control']) !!}
                </div>
              </div>

              <!-- Full name -->
              <div class="form-group">
                {!! Form::label('name', 'Full name', ['class' => 'col-md-4 control-label']) !!}
                <div class="col-md-6">
                  {!! Form::text('name', Input::old('name'), ['class' => 'form-control', 'placeholder' => 'Optional']) !!}
                </div>
              </div>

              <!-- Location -->
              <div class="form-group">
                {!! Form::label('location', 'Location', ['class' => 'col-md-4 control-label']) !!}
                <div class="col-md-6">
                  {!! Form::text('location', Input::old('location'), ['class' => 'form-control', 'placeholder' => 'Optional']) !!}
                </div>
              </div>

              <!-- Website -->
              <div class="form-group">
                {!! Form::label('website', 'Website', ['class' => 'col-md-4 control-label']) !!}
                <div class="col-md-6">
                  {!! Form::text('website', Input::old('website'), ['class' => 'form-control', 'placeholder' => 'Optional']) !!}
                </div>
              </div>

              <!-- Description -->
              <div class="form-group">
                {!! Form::label('description', 'Description', ['class' => 'col-md-4 control-label']) !!}
                <div class="col-md-6">
                  {!! Form::text('description', Input::old('description'), ['class' => 'form-control', 'placeholder' => 'Optional']) !!}
                </div>
              </div>

              <!-- Currency -->
              <div class="form-group">
                {!! Form::label('currency', 'Currency', ['class' => 'col-md-4 control-label']) !!}
                <div class="col-md-6">
                  {!! Form::select('currency', [
                    'EUR' => '&euro; - Euro',
                    'USD' => '&#36; - United States Dollar',
                    'GBP' => '&pound; - Great Britain Pound'
                  ], Auth::user()->currency, ['class' => 'form-control']) !!}
                </div>
              </div>
          </div>
          <div class="panel-footer">
            {!! Form::submit('Update', array('class' => 'btn btn-md btn-primary pull-right')) !!}
            <div class="clearfix"></div>
          </div>
          {!! Form::close() !!}
        </div>
      </div>

      {{-- Password --}}
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading">Edit Password</div>
          {!! Form::open([ 'route' => 'post.edit.password', 'class' => 'form-horizontal']) !!}
          <div class="panel-body">
            <div class="form-group">
              {!! Form::label('old', 'Current password', ['class' => 'col-md-5 control-label']) !!}
              <div class="col-md-7">
                {!! Form::password('old', ['class' => 'form-control', 'placeholder' => 'Required']) !!}
              </div>
            </div>

            <div class="form-group">
              {!! Form::label('new', 'New password', ['class' => 'col-md-5 control-label']) !!}
              <div class="col-md-7">
                {!! Form::password('new', ['class' => 'form-control', 'placeholder' => 'Required']) !!}
              </div>
            </div>

            <div class="form-group">
              {!! Form::label('confirm', 'New password again', ['class' => 'col-md-5 control-label']) !!}
              <div class="col-md-7">
                {!! Form::password('confirm', ['class' => 'form-control', 'placeholder' => 'Required']) !!}
              </div>
            </div>
          </div>
          <div class="panel-footer">
            {!! Form::submit('Edit password', array('class' => 'btn btn-md btn-primary pull-right')) !!}
            <div class="clearfix"></div>
          </div>
          {!! Form::close() !!}
        </div>
      </div>

      {{-- Discogs Connection status --}}
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading">Discogs Connection Status</div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-4">
                <button class="btn btn-info btn-block js-connectionStatus disabled"><i class="fa fa-spin fa-refresh"></i> Checking...</button>
              </div>
              <div class="col-md-8">
                <a href="{{ route('get.oAuthDiscogs') }}" class="btn btn-primary hidden js-connectionAction"><i class="fa fa-fw fa-exchange"></i> Authorize</a>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- Email Notifications --}}
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading">Notifications</div>
          {!! Form::model(Auth::user(), ['route' => 'post.edit.notifications', 'class' => 'form-horizontal']) !!}
          <div class="panel-body">
            <div class="form-group">
              <div class="col-md-12">
                {!! Form::checkbox('email_new_follower', Input::old('email_new_follower'), ['class' => 'form-control']) !!}
                Email me on new followers
              </div>
            </div>

          </div>
          <div class="panel-footer">
            {!! Form::submit('Update', array('class' => 'btn btn-md btn-primary pull-right')) !!}
            <div class="clearfix"></div>
          </div>
          {!! Form::close() !!}
        </div>
      </div>

      {{-- Privacy --}}
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading">Privacy</div>
          {!! Form::model(Auth::user(), [ 'route' => 'post.edit.privacy', 'class' => 'form-horizontal']) !!}
          <div class="panel-body">
            <div class="form-group">
              {!! Form::label('collection_visibility', 'Who can see my collection', ['class' => 'col-md-5 control-label']) !!}
              <div class="col-md-7">
                {!! Form::select('collection_visibility', [
                      'everyone' => 'Everyone',
                      'noone' => 'Noone',
                      'follower' => 'Only follower'
                    ], Auth::user()->collection_visibility, ['class' => 'form-control']) !!}
              </div>
            </div>
            <div class="form-group">
              {!! Form::label('statistics_visibility', 'Who can see my statistics', ['class' => 'col-md-5 control-label']) !!}
              <div class="col-md-7">
                {!! Form::select('statistics_visibility', [
                      'everyone' => 'Everyone',
                      'noone' => 'Noone',
                      'follower' => 'Only follower'
                    ], Auth::user()->statistics_visibility, ['class' => 'form-control']) !!}
              </div>
            </div>
          </div>
          <div class="panel-footer">
            {!! Form::submit('Update', array('class' => 'btn btn-md btn-primary pull-right')) !!}
            <div class="clearfix"></div>
          </div>
          {!! Form::close() !!}
        </div>
      </div>

      {{-- Collection --}}
      <div class="col-md-6">
          <div class="panel panel-default">
              <div class="panel-heading">Collection</div>
              <div class="panel-body">
                  <button class="btn btn-danger" data-toggle="modal" data-target="#deleteCollectionModal"><i class="fa fa-trash-o"></i> Delete Collection</button>
              </div>
          </div>
      </div>
      @include('partials.deleteCollectionModal')

    </div>
  </div>

  {{-- Sidebar --}}
  @include('user.partials.sidebar')

@endsection

@section('scripts')
  <script>$.getStatus({{Auth::user()->id}});</script>
  <script src="/js/settings.js"></script>
@endsection
