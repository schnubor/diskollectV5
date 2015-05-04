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
            <a href="{{ route('user.show', $user->id) }}"><div class="avatar big"style="background-image: url('{{ $user->image }}');"></div></a>
            <p class="h4"><a href="{{ route('user.show', $user->id) }}"><strong>{{ $user->username }}</strong></a></p>
            @if($user->location)
              <p>{{ $user->location }}</p>
            @else
              <p><em>unknown location</em></p>
            @endif
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