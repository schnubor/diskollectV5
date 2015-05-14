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
          <button class="btn btn-default btn-sm js-skip"><i class="fa fa-fw fa-step-forward"></i> Skip</button>
      </div>
    </div>
    <div class="col-md-12 content">
        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading js-vinylTitle"></div>
                <div class="panel-body">
                    <img src="" alt="" class="thumbnail js-cover" width="100%">
                </div>
            </div>
            
        </div>
        <div class="col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading js-videoTitle">
                    
                </div>
                <div class="panel-body">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe id="player" class="embed-responsive-item" src="" frameborder="0" enablejsapi="1"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script src="/js/yt.js"></script>
  <script>$.jukebox({!! $vinyls !!});</script>
@endsection