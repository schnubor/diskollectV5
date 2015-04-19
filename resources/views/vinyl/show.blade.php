@extends('app')

@section('title')
  {{ $vinyl->artist }} - {{ $vinyl->title }}
@endsection

@section('content')
  @if($user->id == $owner->id)
    @include('user.partials.sidebar')
  @else
    @include('vinyl.partials.sidebar')
  @endif
@endsection