@extends('app')

@section('title')
  {{ $user->username }}
@endsection

@section('content')
  @include('user.partials.sidebar')

  <div class="col-md-10 no-padding content-area">
    <div class="col-md-12 toolbar">
        <div class="col-xs-4 text-center lead"><i class="fa fa-dot-circle-o"></i> 245</div>
        <div class="col-xs-4 text-center lead"><i class="fa fa-dollar"></i> 1245</div>
        <div class="col-xs-4 text-center lead"><i class="fa fa-dashboard"></i> 12kg</div>
    </div>
    
    <div class="col-md-12 mainStats">
      {{-- Genres --}}
      <div class="panel panel-default">
        <div class="panel-heading"><strong>Genre Distribution</strong></div>
        <div class="panel-body">
          <div id="genreChart">
            
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection