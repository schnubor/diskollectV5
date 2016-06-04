@extends('app')

@section('robots', 'all')
@section('title'){{$user->username}}s Collection @endsection
@section('ogimage'){{ 'http://'.Request::server ("HTTP_HOST") }}{{ $user->image }}@endsection
@section('description')Check out {{ $user->username }}s vinyl collection on therecord.de @endsection
@section('keywords', ', collection, community')

@section('content')
  <div class="content-area" id="collection">
    <div class="col-md-12 toolbar">
      {{-- Controls --}}
      @if(Auth::check())
        @if(Auth::user()->id == $user->id)
          <p class="lead"><strong>Your Collection</strong></p>
        @else
          @include('user.partials.dropdown')
        @endif
      @else
        @include('user.partials.dropdown')
      @endif
    </div>
    <div class="col-md-12 content">
        @if(Auth::check())
            @if($user->collection_visibility == 'everyone' || Auth::user()->id == $user->id)
              <vinyls userid="{{ $user->id }}"></vinyls>
            @else {{-- not everyone can the collection --}}
              @if($user->collection_visibility == 'follower')
                @if($user->isFollowedBy(Auth::user()))
                  <vinyls userid="{{ $user->id }}"></vinyls>
                @else
                  <div class="col-md-12 text-center">
                    <p class="placeholder">This collection is only visible for followers.</p>
                  </div>
                @endif
              @else
                <div class="col-md-12 text-center">
                  <p class="placeholder">This collection is private.</p>
                </div>
              @endif
            @endif
        @else
            @if($user->collection_visibility == 'everyone')
                <vinyls userid="{{ $user->id }}"></vinyls>
            @elseif($user->collection_visibility == 'follower')
                <div class="col-md-12 text-center">
                  <p class="placeholder">This collection is only visible for followers.</p>
                </div>
            @else
                <div class="col-md-12 text-center">
                  <p class="placeholder">This collection is private.</p>
                </div>
            @endif
        @endif
    </div>
  </div>

  {{-- Sidebar --}}
  @include('user.partials.sidebar')

  {{-- Templates --}}
  @include('templates.collectionVinyls')
@endsection

@section('scripts')
  <script src="/js/collection.js"></script>
@endsection
