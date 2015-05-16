@extends('app')

@section('title')
  {{$user->username}}s Jukebox
@endsection

@section('content')
  @include('user.partials.sidebar')

  <div class="col-md-10 no-padding content-area">
    <div class="col-md-12 toolbar">
      <div class="controls">
        <p class="lead"><strong>{{ $vinyls->count() }}</strong> Vinyls in the Jukebox</p>
      </div>
    </div>
    <div class="col-md-12 content">
        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading"><strong class="js-vinylTitle"></strong></div>
                <div class="panel-body">
                    <a href="" class="js-link"><img src="" alt="" class="thumbnail js-cover" width="100%"></a>
                    <button class="btn-block btn btn-success btn-lg js-skip"><i class="fa fa-fw fa-step-forward"></i> Skip</button>
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
  <script>$.jukebox({!! $vinyls !!});</script>
@endsection