@extends('app')

@section('title')
  Add Vinyl
@endsection

@section('content')
  @include('user.partials.sidebar')

  <div class="col-md-10 no-padding content-area">
    <div class="col-md-12 toolbar">
      {!! Form::open(['route' => 'post.search', 'class' => 'form-inline col-md-8']) !!}
        <div class="form-group">
          {!! Form::text('artist', Input::old('artist'), ['class' => 'form-control', 'placeholder' => 'Artist']) !!}
        </div>
        <div class="form-group">
          {!! Form::text('title', Input::old('title'), ['class' => 'form-control', 'placeholder' => 'Title']) !!}
        </div>
        <div class="form-group">
          {!! Form::text('catno', Input::old('catno'), ['class' => 'form-control', 'placeholder' => 'Cat. No.']) !!}
        </div>
        {!! Form::submit('Search', array('class' => 'btn btn-md btn-primary')) !!}
      {!! Form::close() !!}

      <a href="{{ route('get.create.vinyl') }}" class="btn btn-md btn-default pull-right">Add manually</a>
    </div>
  </div>
@endsection