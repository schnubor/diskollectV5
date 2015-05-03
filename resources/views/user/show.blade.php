@extends('app')

@section('title')
  {{ $user->username }}
@endsection

@section('content')
  @include('user.partials.sidebar')

  <div class="col-md-10 no-padding content-area">
    <div class="col-md-12 toolbar">

    </div>
    
    <div class="col-md-12 content">

      <div class="col-md-3">
        <div class="well">
          <p class="h2">{{ $value }} {{ $user->currency }}</p>
          <p class="lead">Overall Value</p> 
        </div>
      </div>

      <div class="col-md-3">
        <div class="well">
          <p class="h2">{{ $weight }} kg</p>
          <p class="lead">Overall Weight</p> 
        </div>
      </div>

      <div class="col-md-3">
        <div class="well">
          <p class="h2">{{ $favArtist }}</p>
          <p class="lead">Favourite Artist</p> 
        </div>
      </div>

      <div class="col-md-3">
        <div class="well">
          <p class="h2">{{ $favLabel }}</p>
          <p class="lead">Favourite Label</p> 
        </div>
      </div>

      {{-- Genres --}}
      <div class="col-md-9">
        <div class="panel panel-default">
          <div class="panel-heading"><strong>Genre Distribution</strong></div>
          <div class="panel-body">
            <div id="genreChart"></div>
          </div>
        </div>
      </div>

      {{-- Genres --}}
      <div class="col-md-3">
        <div class="panel panel-default valueVinyl">
          <div class="panel-heading"><strong>Most valueable Vinyl</strong><span class="pull-right label label-success">{{ $valueVinyl->price.' '.$user->currency }}</span></div>
          <div class="panel-body">
            <a href="{{ route('get.show.vinyl', $valueVinyl->id) }}"><img src="{{ $valueVinyl->artwork }}" alt="{{ $valueVinyl->artist }} - {{ $valueVinyl->title }}" class="thumbnail" width="100%"></a>
            <p style="margin-bottom: 0;">
              <strong>{{ $valueVinyl->artist }}</strong><br>
              <span>{{ $valueVinyl->title }}</span>
            </p>
          </div>
        </div>
      </div>

      {{-- Sizes --}}
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading"><strong>Vinyl sizes</strong></div>
          <div class="panel-body">
            <div id="sizeChart"></div>
          </div>
        </div>
      </div>

      {{-- Times --}}
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading"><strong>Release dates</strong></div>
          <div class="panel-body">
            <div id="timeChart"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script>getStats({{$user->id}});</script>
@endsection