@extends('app')

@section('robots', 'all')
@section('title'){{$user->username}}s Jukebox @endsection
@section('ogimage'){{ $user->avatar }}@endsection
@section('description')Check out {{ $user->username }}s jukebox on therecord.de @endsection
@section('keywords', ', jukebox, community')

@section('content')
  <div class="content-area">
    <div class="col-md-12 toolbar">
      @if(Auth::check())
        @if(Auth::user()->id == $user->id)
          <p class="lead"><strong>Your Jukebox</strong></p>
        @else
          @include('user.partials.dropdown')
        @endif
      @else
        @include('user.partials.dropdown')
      @endif
    </div>

    <!-- Jukebox content -->
    <div id="jukebox" data-userid="{{ $user->id }}">
      @if($vinyls->count())
        <div v-if="loading" class="col-md-12 content">
          <div class="loading text-center"><i class="fa fa-circle-o-notch fa-spin"></i></div>
        </div>
        <div class="jukeboxPlayer" v-else>
            <div class="videoBg">
                <youtube :video-id="videoId" @paused="paused()" @buffering="buffering()"  @queued="queued()" @playing="playing()" @error="newRecord(vinyls)" @ended="newRecord(vinyls)" @ready="playerReady" player-width="100%" player-height="100%" :player-vars="{autoplay: 1, controls: 0, iv_load_policy: 3, autohide: 1}"></youtube>
            </div>
            <div class="vinylDetails">
                <div class="row">
                    <div class="col-sm-2">
                        <a href="/vinyl/@{{ vinyl.id }}"><img :src="vinyl.cover" alt="" class="js-cover" width="100%"></a>
                    </div>
                    <div class="col-sm-10">
                        <span class="vinylTitle">@{{ vinyl.artist }} - @{{ vinyl.title }}</span><br/>
                        <span class="vinylMeta">@{{ vinyl.label }}, @{{ vinyl.country }}, @{{ vinyl.year }}</span></br></br>
                        <button class="btn btn-default btn-md js-skip" @click="newRecord(vinyls)"><i class="fa fa-fw fa-step-forward"></i> Skip</button>
                    </div>
                </div>
            </div>
        </div>
      @else
        <div class="col-md-12 content">
            <div class="col-md-12 text-center">
              <p class="placeholder">Not enough vinyls in collection.</p>
              @if(Auth::check())
                @if(Auth::user()->id == $user->id)
                  <a href="{{ route('get.search') }}" class="btn btn-primary btn-lg"><i class="fa fa-fw fa-plus"></i> Add vinyl</a>
                @endif
              @endif
            </div>
        </div>
      @endif
    </div>
  </div>
  {{-- Sidebar --}}
  @include('user.partials.sidebar')
@endsection

@section('scripts')
  <script src="/js/jukebox.js"></script>
@endsection
