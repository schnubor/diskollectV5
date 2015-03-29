@extends('app')

@section('title')
  {{$user->username}}s Collection
@endsection

@section('content')
  @include('user.partials.sidebar')

  <div class="col-md-10">
    <div class="page-header">
      <p class="h1">Collection</p>
    </div>
  </div>
@endsection