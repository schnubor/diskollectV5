@extends('app')

@section('title')
  {{ $user->username }}'s Followers
@endsection

@section('content')
  <div class="content-area">
    <div class="col-md-12">
      <a href="{{ route('user.show', $user->id) }}" class="btn btn-default back"><i class="fa fa-fw fa-chevron-left"></i> Back to profile</a>
      @foreach(array_chunk($followers->all(), 4) as $followerRow)
        <div class="row">
          @foreach($followerRow as $follower)
            <div class="col-sm-3 collector">
              <div class="thumbnail">
                <a href="{{ route('user.show', $follower->id) }}"><div class="avatar big" style="background-image: url('{{ $follower->image }}');"></div></a>
                <div class="caption">
                  <p class="h4"><a href="{{ route('user.show', $follower->id) }}"><strong>{{ $follower->username }}</strong></a></p>
                  <p>{{ $follower->vinyls->count() }} Records</p>
                  <hr>
                  <div class="text-left">@include('user.partials.follow')</div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      @endforeach
      
      <div class="text-center">
        {!! $followers->render() !!}
      </div>
    </div>
  </div>

  {{-- Sidebar --}}
  @include('user.partials.sidebar')
@endsection