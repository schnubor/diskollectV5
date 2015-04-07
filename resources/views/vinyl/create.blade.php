@extends('app')

@section('title')
  Add Vinyl
@endsection

@section('content')
  @include('user.partials.sidebar')

  <div class="col-md-10 no-padding content-area">
    <div class="col-md-12 content full-height no-padding">
      <div class="col-md-12 no-padding">
        <!-- Cover -->
        <div class="col-md-4 step one no-padding">
          <div class="col-md-12">
            <div class="step-number">1</div>
            <p class="h1 step-headline white">Cover</p>
          </div>
          <div class="col-md-12">
            <img src="/images/PH_vinyl.svg" class="cover">
            <div class="form-group coverUrl">
              <input class="form-control" name="coverUrl" type="text" placeholder="Image URL (e.g. http://example.com/image.jpg)"> 
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
                <input class="form-control" name="artist" type="text" placeholder="Artist">
                <span class="input-group-addon" id="basic-addon1">required</span>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <input class="form-control" name="title" type="text" placeholder="Title">
                <span class="input-group-addon" id="basic-addon1">required</span>
              </div>
            </div>
            <div class="form-group">
              <input class="form-control" name="genre" type="text" placeholder="Genre">
            </div>
            <div class="form-group">
              <input class="form-control" name="label" type="text" placeholder="Label">
            </div>
            <div class="form-group">
              <input class="form-control" name="year" type="text" placeholder="Release year">
            </div>
            <div class="form-group">
              <input class="form-control" name="country" type="text" placeholder="Country">
            </div>
            <div class="form-group">
              <input class="form-control" name="catno" type="text" placeholder="Catalog number">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <div class="input-group">
                <input class="form-control" name="price" type="text" placeholder="Price">
                <span class="input-group-addon" id="basic-addon1">required</span>
              </div>
            </div>
            <div class="form-group">
              <input class="form-control" name="color" type="text" placeholder="Color">
            </div>
            <div class="form-group">
              <div class="input-group">
                <input class="form-control" name="weight" type="text" placeholder="Weight">
                <span class="input-group-addon" id="basic-addon1">gram</span>
              </div>
            </div>
            <div class="row">
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
              <div class="form-group col-xs-3">
                <select class="form-control" name="format">
                  <option selected>LP</option>
                  <option>EP</option>
                  <option>Single</option>
                </select>
              </div>
              <div class="form-group col-xs-5">
                <div class="input-group">
                  <select class="form-control" name="format">
                    <option selected>12</option>
                    <option>10</option>
                    <option>7</option>
                  </select>
                  <span class="input-group-addon" id="basic-addon1">inch</span>
                </div>
              </div>
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
        </div>
      </div>
      <!-- Save -->
      <div class="col-md-12 no-padding">
        <div class="col-md-12 step four no-padding">
          <div class="col-md-8">
            <div class="step-number">4</div>
            <p class="h1 step-headline">Save</p>
          </div>
          <div class="col-md-4">
            {!! Form::submit('Add vinyl', array('class' => 'btn btn-lg btn-primary pull-right')) !!}
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection