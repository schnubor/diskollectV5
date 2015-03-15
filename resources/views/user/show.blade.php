@extends('app')

@section('title')
  {{ $user->username }}
@endsection

@section('content')
  <div class="container">
    <div class="row">
    
      @include('partials.sidebar')

      <div class="col-md-8">
        
      </div>
    </div>
  </div>
@endsection