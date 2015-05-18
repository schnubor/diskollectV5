@extends('app')

@section('title')
  {{ $user->username }}
@endsection

@section('content')
  @include('user.partials.sidebar')

  <div class="col-md-10 no-padding content-area">
    <div class="col-md-12 toolbar">
      <p class="lead">Showing statistics for <strong>{{ $user->vinyls->count() }}</strong> vinyls</p>
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
          @if(isset($favArtist))
            <p class="h2">{{ $favArtist->artist }}</p>
          @else
            <p class="h2">-</p>
          @endif
          <p class="lead">Favourite Artist</p> 
        </div>
      </div>

      <div class="col-md-3">
        <div class="well">
          @if(isset($favLabel))
            <p class="h2">{{ $favLabel->label }}</p>
          @else
            <p class="h2">-</p>
          @endif
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
          <div class="panel-heading"><strong>Treasure</strong><span class="pull-right label label-success">
            @if(isset($valueVinyl))
              {{ $valueVinyl->price.' '.$user->currency }}
            @else
              0 {{ $user->currency }}
            @endif
          </span></div>
          <div class="panel-body">
            @if(isset($valueVinyl))
              <a href="{{ route('get.show.vinyl', $valueVinyl->id) }}"><img src="{{ $valueVinyl->artwork }}" alt="{{ $valueVinyl->artist }} - {{ $valueVinyl->title }}" class="thumbnail" width="100%"></a>
              <p style="margin-bottom: 0;">
                <strong>{{ $valueVinyl->artist }}</strong><br>
                <span>{{ $valueVinyl->title }}</span>
              </p>
            @else
              <img class="thumbnail" src="/images/PH_vinyl.svg" alt="empty vinyl" width="100%">
            @endif
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
  <script>$.getStats({{$user->id}});</script>
@endsection