@extends('app')

@section('title')
  Edit Vinyl
@endsection

@section('content')
  {!! Form::model($vinyl, ['route' => ['post.edit.vinyl', $vinyl->id], 'files' => true]) !!}
  <div class="content-area createVinyl">
    {{-- Toolbar --}}
    <div class="col-md-12 toolbar">
      <p class="lead">{{ $vinyl->artist }} - {{ $vinyl->title }}</p>
      {{-- Submit --}}
      {!! Form::submit('Save', array('class' => 'btn btn-primary pull-right')) !!}
    </div>

    {{-- Content --}}
    <div class="col-md-12 content">
      <div class="row col-md-12">
        {{-- Cover --}}
        <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading">Cover</div>
            <div class="panel-body">
              <img src="{{ $vinyl->artwork }}" class="cover thumbnail" id="vinylCover" width="100%">
              <div class="coverUrl">
                {!! Form::text('artwork', Input::old('artwork'), ['class' => 'form-control', 'placeholder' => 'Image URL (e.g. http://example.com/image.jpg)']) !!}
              </div>
              <p class="text-center">or upload an image</p>
              <div class="coverUrl" style="padding-bottom: 40px;">
                {!! Form::file('coverFile', ['class' => 'form-control']) !!}
              </div>
            </div>
          </div>
        </div>

        {{-- Vinyl Data --}}
        <div class="col-md-8">
          <div class="panel panel-default">
            <div class="panel-heading">Vinyl Details</div>
            <div class="panel-body">
              <div class="col-md-6">
                <div class="form-group">
                  <div class="input-group">
                    {!! Form::text('artist', Input::old('artist'), ['class' => 'form-control', 'placeholder' => 'Artist']) !!}
                    <span class="input-group-addon" id="basic-addon1">required</span>
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    {!! Form::text('title', Input::old('title'), ['class' => 'form-control', 'placeholder' => 'Title']) !!}
                    <span class="input-group-addon" id="basic-addon1">required</span>
                  </div>
                </div>
                <div class="form-group">
                  {!! Form::text('genre', Input::old('genre'), ['class' => 'form-control', 'placeholder' => 'Genre']) !!}
                </div>
                <div class="form-group">
                  {!! Form::text('label', Input::old('label'), ['class' => 'form-control', 'placeholder' => 'Label']) !!}
                </div>
                <div class="form-group">
                  {!! Form::text('releasedate', Input::old('releasedate'), ['class' => 'form-control', 'placeholder' => 'Release year']) !!}
                </div>
                <div class="form-group">
                  {!! Form::text('country', Input::old('country'), ['class' => 'form-control', 'placeholder' => 'Country (e.g. US, DE, ...']) !!}
                </div>
                <div class="form-group">
                  {!! Form::text('catno', Input::old('catno'), ['class' => 'form-control', 'placeholder' => 'Catalog No.']) !!}
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <div class="input-group">
                    {!! Form::text('price', Input::old('price'), ['class' => 'form-control', 'placeholder' => 'Price in '.$user->currency]) !!}
                    <span class="input-group-addon" id="basic-addon1">required</span>
                  </div>
                </div>
                <div class="form-group">
                  {!! Form::text('color', Input::old('color'), ['class' => 'form-control', 'placeholder' => '#000000']) !!}
                </div>
                <div class="form-group">
                  <div class="input-group">
                    {!! Form::text('weight', Input::old('weight'), ['class' => 'form-control', 'placeholder' => 'Weight']) !!}
                    <span class="input-group-addon" id="basic-addon1">gram</span>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-xs-3">
                    <select class="form-control" name="format">
                      <option selected>LP</option>
                      <option>EP</option>
                      <option>Single</option>
                    </select>
                  </div>
                  <div class="form-group col-xs-4">
                    <div class="input-group">
                      <select class="form-control" name="count">
                        <option selected>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                        <option>6</option>
                      </select>
                      <span class="input-group-addon" id="basic-addon1">x</span>
                    </div>
                  </div>
                  <div class="form-group col-xs-5">
                    <div class="input-group">
                      <select class="form-control" name="size">
                        <option selected>12</option>
                        <option>10</option>
                        <option>7</option>
                      </select>
                      <span class="input-group-addon" id="basic-addon1">inch</span>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="radio-inline">
                    <input type="radio" name="type" value="release" checked> Release
                  </label>
                  <label class="radio-inline">
                    <input type="radio" name="type" value="master"> Master
                  </label>
                  <label class="radio-inline">
                    <input type="radio" name="type" value="reissue"> Reissue
                  </label>
                </div>
                <div class="form-group">
                  <textarea class="form-control" placeholder="Additional notes (optional)" name="notes" style="resize: none;">{{$vinyl->notes}}</textarea>
                </div>
              </div>
            </div>
          </div>

          {{-- Spotify --}}
          <div class="panel panel-default">
            <div class="panel-heading">Spotify URI</div>
            <div class="panel-body">
              <div class="form-group">
                {!! Form::text('spotify_id', Input::old('spotify_id'), ['class' => 'form-control', 'placeholder' => 'Spotify ID. e.g. spotify:album:2b1HN0avZHrA8vNL0vP1Gw']) !!}
              </div>
            </div>
          </div>
          
          {{-- Tracklist --}}
          <div class="panel panel-default">
            <div class="panel-heading">Tracklist</div>
            <div class="panel-body">
              @if($tracks->count())
                {!! Form::hidden('trackCount', $tracks->count()) !!}
              @else
                {!! Form::hidden('trackCount', 1) !!}
              @endif
              <table class="table js-trackTable">
                @if($tracks->count())
                  @foreach($tracks as $key => $track)
                    <tr class="track{{ $key }}">
                      {!! Form::hidden('track_'.$key.'_id', $track->id) !!}
                      <td width="80px" style="padding-left: 0;">{!! Form::text('track_'.$key.'_position', $track->number, ['class' => 'form-control', 'placeholder' => 'A1']) !!}</td>
                      <td>{!! Form::text('track_'.$key.'_title', $track->title, ['class' => 'form-control', 'placeholder' => 'Title']) !!}</td>
                      <td width="100px">{!! Form::text('track_'.$key.'_duration', $track->duration, ['class' => 'form-control', 'placeholder' => '1:13']) !!}</td>
                      <td><button type="button" class="btn btn-md btn-default js-deleteTrack"><i class="fa fa-trash"></i></button></td>
                    </tr>
                  @endforeach
                @endif
              </table>
              <button type="button" class="js-add-track btn btn-md btn-default"><i class="fa fa-plus"></i> Add Track</button>
            </div>
          </div>
          
          {{-- Submit --}}
          {!! Form::submit('Save', array('class' => 'btn btn-lg btn-primary pull-right', 'style' => 'margin: 15px 0')) !!}
        </div>
      </div>
      {!! Form::close() !!}
    </div>
  </div>

  {{-- Sidebar --}}
  @include('user.partials.sidebar')
@endsection