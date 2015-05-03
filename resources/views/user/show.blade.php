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
          <p class="h2">1283€</p>
          <p class="lead">Overall Value</p> 
        </div>
      </div>

      <div class="col-md-3">
        <div class="well">
          <p class="h2">1283€</p>
          <p class="lead">Overall Value</p> 
        </div>
      </div>

      <div class="col-md-3">
        <div class="well">
          <p class="h2">1283€</p>
          <p class="lead">Overall Value</p> 
        </div>
      </div>

      <div class="col-md-3">
        <div class="well">
          <p class="h2">1283€</p>
          <p class="lead">Overall Value</p> 
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
        <div class="panel panel-default">
          <div class="panel-heading"><strong>Most valueable Vinyl</strong></div>
          <div class="panel-body">
            <a href=""><img src="/images/PH_vinyl.svg" alt="" class="thumbnail" width="100%"></a>
            <p>
              <strong>Daft Punk</strong><br>
              <span>Homework</span>
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