@extends('app')

@section('title')
  Add Vinyl
@endsection

@section('content')
  @include('user.partials.sidebar')

  <div class="col-md-10 no-padding content-area createVinyl">
    <div class="col-md-12 content full-height no-padding">
      {!! Form::open(['route' => 'post.create.vinyl', 'id' => 'addVinylForm', 'files' => true]) !!}
      <div class="col-md-12 no-padding">
        <!-- Cover -->
        <div class="col-md-4 step one no-padding">
          <div class="col-md-12">
            <div class="step-number">1</div>
            <p class="h1 step-headline white">Cover</p>
          </div>
          <div class="col-md-12">
            <div class="col-md-8 col-md-offset-2">
              <img src="/images/PH_vinyl.svg" class="cover thumbnail" id="vinylCover">
            </div>
            <div class="coverUrl">
              {!! Form::text('cover', Input::old('cover'), ['class' => 'form-control', 'placeholder' => 'Image URL (e.g. http://example.com/image.jpg)']) !!}
            </div>
            <p class="text-center">or upload an image</p>
            <div class="coverUrl" style="padding-bottom: 40px;">
              {!! Form::file('coverFile', ['class' => 'form-control']) !!}
            </div>
          </div>
        </div>
        <!-- Vinyl Data -->
        <div class="col-md-8 step two no-padding">
          <div class="col-md-12">
            <div class="step-number">2</div>
            <p class="h1 step-headline">Vinyl information</p>
          </div>
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
              {!! Form::text('year', Input::old('year'), ['class' => 'form-control', 'placeholder' => 'Release year']) !!}
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
              <textarea class="form-control" placeholder="Additional notes (optional)" name="notes" style="resize: none;"></textarea>
            </div>
          </div>
        </div>
      </div>
      <!-- tracklist -->
      <div class="col-md-12 no-padding">
        <div class="col-md-12 step three no-padding">
          <div class="col-md-12">
            <div class="step-number">3</div>
            <p class="h1 step-headline white">Tracklist </p>
          </div>
          <div class="col-md-8 text-left">
            {!! Form::hidden('trackCount', 1) !!}
            <table class="table js-trackTable">
              <tr class="track0">
                <td width="80px" style="padding-left: 0;">{!! Form::text('track_0_position', Input::old('track_0_position'), ['class' => 'form-control', 'placeholder' => 'A1']) !!}</td>
                <td>{!! Form::text('track_0_title', Input::old('track_0_title'), ['class' => 'form-control', 'placeholder' => 'Title']) !!}</td>
                <td width="100px">{!! Form::text('track_0_duration', Input::old('track_0_duration'), ['class' => 'form-control', 'placeholder' => '1:13']) !!}</td>
              </tr>
            </table>
            <button type="button" class="js-add-track btn btn-md btn-default"><i class="fa fa-plus"></i> Add Track</button>
          </div>
        </div>
      </div>
      <!-- Save -->
      <div class="col-md-12 no-padding">
        <div class="col-md-12 step four no-padding">
          <div class="col-md-12">
            {!! Form::submit('Add vinyl', array('class' => 'btn btn-lg btn-primary pull-right', 'style' => 'margin: 15px 0')) !!}
          </div>
        </div>
      </div>
      {!! Form::close() !!}
    </div>
  </div>
@endsection