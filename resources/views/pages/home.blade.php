@extends('app')

@section('title')
  Welcome
@endsection

@section('content')
  {{-- Welcome Page --}}
  <div id="welcome">
    <div class="header">
      <video autoplay="" loop="" poster="/images/header_BG.jpg" id="bgvid">
        <source src="/images/bg_clip.webm" type="video/webm">
        <source src="/images/bg_clip.mp4" type="video/mp4">
      </video>
      <div class="header-menu container">
        <div class="logo">
          <img src="/images/logo.png" alt="For the record">
        </div>

      </div>
      <div class="header-content container">
        <h1>Your vinyls new home.</h1>
        <h2>Manage, rediscover and analyse your collection.</h2>
        <div class="cta">
          <a href="{{ route('login') }}" class="btn btn-lg btn-primary btn-header">Start here.</a>
        </div>
      </div>
      <div class="header-stats">
        <div class="stat">
          <span>{{$vinylCount}}</span><br>
          <small>vinyls</small>
        </div>
        <div class="stat">
          <span>{{$weight}}kg</span><br>
          <small>in weight</small>
        </div>
        <div class="stat">
          <span>{{$userCount}}</span><br>
          <small>collectors</small>
        </div>
      </div>
    </div>
    
    
    <div class="row feature">
      <div class="container">
        <div class="col-md-4 col-md-offset-1">
          <p class="h3">Collection Statistics.</p>
          <p class="description">
            Dive into the numbers and keep track of your progress. We will create personlized statistics for your collection, covering overall value, genre distribution, favourites and much more.
          </p>
        </div>
        <div class="col-md-5 col-md-offset-1">
          <img src="/images/welcome/browser-stats.png" alt="Statistics" width="100%">
        </div>
      </div>
    </div>

    <div class="row feature">
      <div class="container">
        <div class="col-md-5 col-md-offset-1">
          <img src="/images/welcome/browser-vinyl.png" alt="Statistics" width="100%">
        </div>
        <div class="col-md-4 col-md-offset-1">
          <p class="h3">Open Data. Minimal effort.</p>
          <p class="description">
            For The Record is part of the Open Data Movement and integrates with different APIs like Discogs, iTunes or Youtube to automatically fetch all the data for your records. It also has its own API.
          </p>
        </div>
      </div>
    </div>

    <div class="row feature">
      <div class="container">
        <div class="col-md-4 col-md-offset-1">
          <p class="h3">Collect and connect.</p>
          <p class="description">
            Share your collection with anyone you know and follow other collectors to explore their music and discover new records. For The Record turns collecting into an collective experience. 
          </p>
        </div>
        <div class="col-md-5 col-md-offset-1">
          <img src="/images/welcome/browser-dashboard.png" alt="Statistics" width="100%">
        </div>
      </div>
    </div>

    <div class="latestVinyls">
      <div class="container">
        <p class="lead headline text-center">
          Latest records
        </p>
        <p class="subheadline text-center">
          They just keep flying in.
        </p>
        <div class="row">
        @foreach($latestVinyls as $vinyl)
          <div class="col-sm-3">
            <a href="{{ route('get.show.vinyl', $vinyl->id) }}"><img src="{{ $vinyl->artwork }}" alt="{{ $vinyl->artist }} - {{ $vinyl->title }}" class="thumbnail" width="100%"></a>
            <p>
              <strong>{{ $vinyl->artist }}</strong><br>
              <span>{{ $vinyl->title }}</span>
            </p>
          </div>
        @endforeach
        </div>

        <div class="cta row">
          <a href="{{ route('login') }}" class="btn btn-lg btn-primary btn-header dark">Add a record.</a>
        </div>
      </div>
    </div>
    
    {{-- Latest members --}}
    <div class="latestMembers">
      <div class="container">
        <p class="lead headline text-center">
          Latest collectors
        </p>
        <p class="subheadline text-center">
          You could be one of them.
        </p>
        @foreach($latestMembers as $member)
          <div class="col-sm-2 collector">
            <div class="thumbnail">
              <a href="{{ route('user.show', $member->id) }}"><div class="avatar" style="background-image: url('{{ $member->image }}');"></div></a>
              <div class="caption">
                <p class="h4"><a href="{{ route('user.show', $member->id) }}"><strong class="username">{{ $member->username }}</strong></a></p>
              </div>
            </div>
          </div>
        @endforeach

        <div class="cta row">
          <a href="{{ route('login') }}" class="btn btn-lg btn-primary btn-header">Get on board.</a>
        </div>
      </div>
    </div>
    

    {{-- Footer --}}
    <div class="footer">
      <div class="container">
        <p class="text-center">
          The site owner is not responsible for uploaded images. You can only upload images for which you own the copyright. <br>
          Made by <a href="http://twitter.com/schnubor" target="_blank">@schnubor</a> using <a href="http://laravel.com" target="_blank">Laravel</a> and the <a href="http://discogs.com" target="_blank">Discogs</a> API. <br><br>
          <img src="/images/made-in-berlin-badge.png" alt="Made in Berlin" width="100">
          <br><br>
        </p>
        
      </div>
    </div>
    
  </div>
@endsection

@section('scripts')
  <script src="/js/welcome.js"></script>
@endsection
