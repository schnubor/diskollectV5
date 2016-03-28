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
          <button class="btn btn-lg btn-primary js-startImport"><i class="fa fa-fw fa-download"></i> Scan Discogs</button>
        @else
          <a href="{{ route('get.oAuthDiscogs') }}" class="btn btn-lg btn-primary"><i class="fa fa-fw fa-exchange"></i> Authorize with Discogs</a>
        @endif
      </div>
      <div class="col-md-12 js-importFetchResults" style="display: none;">
          <div class="row">
              <div class="col-md-4">
                  <div class="well well-lg">
                      In Discogs Collection:
                      <p class="placeholder js-vinylsFound">5</p>
                  </div>
              </div>
              <div class="col-md-4">
                  <div class="well well-lg">
                      Already in your collection:
                      <p class="placeholder js-alreadyInCollection">3</p>
                  </div>
              </div>
              <div class="col-md-4">
                  <div class="well well-lg">
                      Vinyls to import:
                      <p class="placeholder js-vinylsToImport">2</p>
                  </div>
              </div>
          </div>
          <div class="row js-startImportButton">
              <div class="col-md-12">
                  <hr>
                  <div class="col-md-4 col-md-offset-4">
                      <button class="btn btn-primary btn-lg btn-block js-startMapping">Start import</button>
                  </div>
              </div>
          </div>
          <div class="row js-importProgress" style="display: none;">
              <div class="col-md-12">
                  <div class="progress">
                      <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">0%</div>
                  </div>
                  <p class="placeholder js-currentImportVinyl"></p>
              </div>
              <div class="col-md-12 js-importComplete" style="display: none;">
                  <div class="col-md-4 col-md-offset-4">
                      <a href="{{ route('user.collection', Auth::user()->id) }}" class="btn btn-success btn-lg btn-block"><i class="fa fa-fw fa-database"></i> To your collection</a>
                  </div>
              </div>
          </div>
      </div>
    </div>
  </div>

  {{-- Sidebar --}}
  @include('user.partials.sidebar')

@endsection

@section('scripts')
  <script>
    $('.js-startImport').click(function(event){
      $.getReleases('{{ Auth::user()->discogs_username }}', {{ Auth::user()->id }})
    });
  </script>
@endsection
