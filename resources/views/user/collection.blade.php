@extends('app')

@section('title')
  {{$user->username}}s Collection
@endsection

@section('content')
  @include('user.partials.sidebar')

  <div class="col-md-10 no-padding content-area">
    <div class="col-md-12 toolbar">
      @if($vinyls->count())
        <div class="pages pull-right">
          @if($vinyls->previousPageUrl())
            <a href="{{ $vinyls->previousPageUrl() }}"><i class="fa fa-angle-left arrow"></i></a>
          @else
            <a href="{{ $vinyls->previousPageUrl() }}" class="disabled"><i class="fa fa-angle-left arrow"></i></a>
          @endif
              <span>{!! $vinyls->currentPage() !!}/{!! $vinyls->lastPage() !!}</span>
          @if($vinyls->nextPageUrl())
            <a href="{{ $vinyls->nextPageUrl() }}"><i class="fa fa-angle-right arrow"></i></a>
          @else
            <a href="{{ $vinyls->nextPageUrl() }}" class="disabled"><i class="fa fa-angle-right arrow"></i></a>
          @endif
        </div>
      @endif
    </div>
    <div class="col-md-12 content">
      @foreach($vinyls as $vinyl)
        <div class="col-md-3 vinyl">
          <div class="cover">
            <a href="{{ route('get.show.vinyl', $vinyl->id) }}"><img src="{{$vinyl->artwork}}" alt="{{$vinyl->artist}} - {{$vinyl->title}}"></a>
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