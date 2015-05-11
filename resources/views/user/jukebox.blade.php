@extends('app')

@section('title')
  {{$user->username}}s Jukebox
@endsection

@section('content')
  @include('user.partials.sidebar')

  <div class="col-md-10 no-padding content-area">
    <div class="col-md-12 toolbar">
      <div class="controls">
          <button class="btn btn-default btn-sm"><i class="fa fa-fw fa-play"></i></button>
          <button class="btn btn-default btn-sm"><i class="fa fa-fw fa-pause"></i></button>
          <button class="btn btn-default btn-sm"><i class="fa fa-fw fa-step-forward"></i> Skip</button>
      </div>
    </div>
    <div class="col-md-12 content">
        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading">Vinyl</div>
                <div class="panel-body">
                    <img src="" alt="" class="thumbnail">
                </div>
            </div>
            
        </div>
        <div class="col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Daft Punk - Around the world
                </div>
                <div class="panel-body">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe id="player" class="embed-responsive-item" src=""></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
@endsection