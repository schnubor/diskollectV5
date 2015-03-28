@extends('app')

@section('title')
  {{ $user->username }}
@endsection

@section('content')
  @include('partials.sidebar')

  <div class="col-md-10">
    <div class="page-header">
      <p class="h1">Collection</p>
    </div>
  </div>
@endsection