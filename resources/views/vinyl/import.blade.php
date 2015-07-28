@extends('app')

@section('title')
  Import from Discogs
@endsection

@section('content')
  <div class="content-area">
    <div class="col-md-12 toolbar">
      <p class="lead">Import from Discogs</p>
    </div>
    <div class="col-md-12 content">
      <div class="col-md-12 js-importResults">
        @if(Auth::user()->discogs_username)
          <button class="btn btn-primary js-startImport"><i class="fa fa-fw fa-download"></i> Scan Discogs</button>
        @else
          <a href="{{ route('get.oAuthDiscogs') }}" class="btn btn-lg btn-primary"><i class="fa fa-fw fa-exchange"></i> Authorize with Discogs</a>
        @endif
      </div>
      <div class="col-md-12">
        <table class="table table-striped js-importTable" style="display: none;">
          <thead>
            <tr>
              <th>Discogs ID</th>
              <th>Artist</th>
              <th>Title</th>
            </tr>
          </thead>
          <tbody>
            
          </tbody>
        </table>
      </div>
    </div>
  </div>
  
  {{-- Sidebar --}}
  @include('user.partials.sidebar')

@endsection

@section('scripts')
  <script>
    $('.js-startImport').click(function(){
      $.getReleases('{{ Auth::user()->discogs_username }}')
    });
  </script>
@endsection