@extends('app')

@section('title')
  Collectors
@endsection

@section('content')
  <div class="container" id="collectors">
    @foreach(array_chunk($users->all(), 4) as $userRow)
      <div class="row">
        @foreach($userRow as $user)
          <div class="col-sm-3 text-center collector">
            <a href="{{ route('user.show', $user->id) }}"><div class="avatar big" style="background-image: url('{{ $user->image }}');"></div></a>
            <p class="h4"><a href="{{ route('user.show', $user->id) }}"><strong>{{ $user->username }}</strong></a></p>
            <p>{{ $user->vinyls->count() }} Records</p>
            @include('user.partials.follow')
          </div>
        @endforeach
      </div>
    @endforeach
    
    <div class="text-center">
      {!! $users->render() !!}
    </div>
  </div>
@endsection