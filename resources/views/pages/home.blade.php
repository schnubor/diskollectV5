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
      
      <div class="container">
        <div class="intro row">
          <div class="col-md-4">
            <div class="text-center"><i class="fa fa-fw fa-line-chart"></i></div>
            <p>
              Dive into the numbers and keep track of your progress. We will create personlized statistics for your collection and yourself.
            </p>
          </div>
          <div class="col-md-4">
            <div class="text-center"><i class="fa fa-fw fa-cubes"></i></div>
            <p>
              FTR integrates with different APIs like Discogs or iTunes to get all the data you need. It also has its own API.
            </p>
          </div>
          <div class="col-md-4">
            <div class="text-center"><i class="fa fa-fw fa-share-alt"></i></div>
            <p>
              Share your own collection with anyone you know and follow other collectors to explore their music and discover new records.
            </p>
          </div>
        </div>
      </div>

      <div class="counter">
        <p>
          Tracking <span>{{$vinylCount}}</span> Vinyls of <span>{{$userCount}}</span> Collectors.
        </p>
      </div>

      <div class="latestVinyls">
        <div class="container">
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
      </div>

      <div class="latestMembers">
        <div class="container">
          @foreach($latestMembers as $member)
            <div class="col-sm-2">
              <a href="{{ route('user.show', $member->id) }}"><div class="avatar sm" style="background-image: url('{{ $member->image }}');"></div></a>
              <p><a href="{{ route('user.show', $member->id) }}">{{ $member->username }}</a></p>
            </div>
          @endforeach
        </div>
      </div>

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
