@extends('app')

@section('title')
  {{$user->username}}s Collection
@endsection

@section('content')
  @include('user.partials.sidebar')

  <div class="col-md-10 no-padding content-area">
    <div class="col-md-12 toolbar">
      The toolbar
    </div>
    <div class="col-md-12 content">
      @foreach($vinyls as $vinyl)
        <div class="col-md-3 vinyl">
          <div class="cover">
            <img src="{{$vinyl->artwork}}" alt="{{$vinyl->artist}} - {{$vinyl->title}}">
          </div>
          <div class="info">
            <span class="artist">{{$vinyl->artist}}</span><br>
            <span class="title">{{$vinyl->title}}</span>
          </div>
        </div>
      @endforeach
    </div>
  </div>
@endsection