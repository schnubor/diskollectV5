@extends('app')

@section('title')
  Collectors
@endsection

@section('content')
  <div class="content-area">
    {{-- Toolbar --}}
    <div class="col-md-12 toolbar">
      <p class="lead"><strong>Collectors</strong></p>
    </div>

    <div class="col-md-12 content" id="collectors">
      @foreach(array_chunk($users->all(), 6) as $userRow)
        <div class="row padding15">
          @foreach($userRow as $user)
            @if(Auth::check())
              @unless(Auth::user()->id == $user->id)
                <div class="col-sm-2 collector">
                  <div class="thumbnail">
                    <a href="{{ route('user.show', $user->id) }}"><div class="avatar" style="background-image: url('{{ $user->image }}');"></div></a>
                    <div class="caption">
                      <p class="h4"><a href="{{ route('user.show', $user->id) }}"><strong class="username">{{ $user->username }}</strong></a></p>
                      <p>{{ $user->vinyls->count() }} Records</p>
                      <div class="text-left">@include('user.partials.follow')</div>
                    </div>
                  </div>
                </div>
              @endunless
            @else
              <div class="col-sm-2 collector">
                <div class="thumbnail">
                  <a href="{{ route('user.show', $user->id) }}"><div class="avatar" style="background-image: url('{{ $user->image }}');"></div></a>
                  <div class="caption">
                    <p class="h4"><a href="{{ route('user.show', $user->id) }}"><strong class="username">{{ $user->username }}</strong></a></p>
                    <p>{{ $user->vinyls->count() }} Records</p>
                    <div class="text-left">@include('user.partials.follow')</div>
                  </div>
                </div>
              </div>
            @endif
          @endforeach
        </div>
      @endforeach
      
      <div class="row text-center">
        {!! $users->render() !!}
      </div>
    </div>
  </div>

  {{-- Sidebar --}}
  @include('user.partials.sidebar')
@endsection