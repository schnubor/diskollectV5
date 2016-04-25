@extends('app')

@section('title')
  {{$user->username}}s Collection
@endsection

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

      @if($user->collection_visibility == 'everyone' || Auth::user()->id == $user->id)
        <vinyls userid="{{ $user->id }}"></vinyls>
      @else {{-- not everyone can the collection --}}
        @if($user->collection_visibility == 'follower')
          @if($user->isFollowedBy(Auth::user()))
            <vinyls userid="{{ $user->id }}"></vinyls>
          @else
            <div class="col-md-12 text-center">
              <p class="placeholder">This collection is only visible for followers.</p>
              {!! Form::open([ 'route' => 'follow' ]) !!}
                {!! Form::hidden('userIdToFollow', $user->id) !!}
                <button class="btn btn-md btn-success btn-follow" type="submit"><i class="fa fa-fw fa-plus"></i> Follow</button>
              {!! Form::close() !!}
            </div>
          @endif
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
