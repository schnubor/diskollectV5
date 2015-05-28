@extends('app')

@section('title')
  Add Vinyl
@endsection

@section('content')
  <div class="content-area">
    <div class="col-md-12 toolbar">
      {!! Form::open(['route' => 'post.search', 'class' => 'form-inline col-md-8', 'id' => 'search-vinyl-form']) !!}
        <div class="form-group">
          {!! Form::text('artist', Input::old('artist'), ['class' => 'form-control', 'placeholder' => 'Artist']) !!}
        </div>
        <div class="form-group">
          {!! Form::text('title', Input::old('title'), ['class' => 'form-control', 'placeholder' => 'Title']) !!}
        </div>
        <div class="form-group">
          {!! Form::text('catno', Input::old('catno'), ['class' => 'form-control', 'placeholder' => 'Cat. No.']) !!}
        </div>
        @if($user->discogs_access_token)
          {!! Form::submit('Search', ['id' => 'submit-search', 'class' => 'btn btn-md btn-primary']) !!}
        @else
          {!! Form::submit('Search', ['id' => 'submit-search', 'class' => 'btn btn-md btn-primary', 'disabled' => 'disabled']) !!}
        @endif
      {!! Form::close() !!}

      <a href="{{ route('get.create.vinyl') }}" class="btn btn-md btn-default pull-right">Add manually</a>
    </div>
    <div class="col-md-12 content">
      @unless($user->discogs_access_token)
        <div class="help">
          <div class="col-md-12 text-center">
            <p class="placeholder">To search for vinyls you need to authorize with Discogs first.</p>
            <a href="{{ route('get.oAuthDiscogs') }}" class="btn btn-lg btn-primary"><i class="fa fa-fw fa-exchange"></i> Authorize</a>
          </div>
        </div>
      @else
        <div class="search-results row">
          <div class="loading text-center" style="display: none;">
            <i class="fa fa-refresh fa-spin"></i>
            <div><button id="cancel-search" class="btn btn-default">Cancel</button></div>
          </div>
          <div class="no-results text-center" style="display: none;">
            <p class="lead">No vinyls found.</p>
          </div>
          <table class="search-results-table table table-striped" style="display: none;">
            <thead>
              <tr>
                <th>Cover</th>
                <th>Artist</th>
                <th>Title</th>
                <th>Cat. No.</th>
                <th class="actions">Actions</th>
              </tr>
            </thead>
            <tbody>
              
            </tbody>
          </table>
        </div>
      @endunless
    </div>
  </div>
  
  {{-- Sidebar --}}
  @include('user.partials.sidebar')

  {{-- Modal --}}
  @include('vinyl.partials.modal')
@endsection