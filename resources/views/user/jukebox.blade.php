@extends('app')

@section('title')
  {{$user->username}}s Jukebox
@endsection

@section('content')
  @include('user.partials.sidebar')

  <div class="col-md-10">
    <div class="page-header">
      <p class="h1">Coming soon ...</p>
    </div>
  </div>
@endsection