{{-- Vinyl count --}}
<div class="col-md-3">
  <div class="well">
    @if(isset($count))
      <p class="h2">{{ $count }}</p>
    @else
      <p class="h2">0</p>
    @endif
    <p class="lead">Records</p>
  </div>
</div>

{{-- Value --}}
<div class="col-md-3">
  <div class="well">
    <p class="h2">{{ $value }} {{ $user->currency }}</p>
    <p class="lead">Overall Value</p>
  </div>
</div>

{{-- Weight --}}
<div class="col-md-3">
  <div class="well">
    <p class="h2">{{ $weight }} kg</p>
    <p class="lead">Overall Weight</p>
  </div>
</div>

{{-- Fav label --}}
<div class="col-md-3">
  <div class="well">
    @if(isset($favLabel))
      <p class="h2">{{ $favLabel->label }}</p>
    @else
      <p class="h2">-</p>
    @endif
    <p class="lead">Favourite Label</p>
  </div>
</div>

{{-- Genres --}}
<div class="col-md-9">
  <div class="panel panel-default">
    <div class="panel-heading"><strong>Genre Distribution</strong></div>
    <div class="panel-body">
        <div class="text-center" style="font-size: 42px;" v-if="loading">
            <i class="fa fa-circle-o-notch fa-spin"></i>
        </div>
        <canvas id="genreChart" v-show="!loading"></canvas>
    </div>
  </div>
</div>

{{-- Sizes
<div class="col-md-6">
  <div class="panel panel-default">
    <div class="panel-heading"><strong>Record Sizes</strong></div>
    <div class="panel-body">
        <div class="text-center" style="font-size: 42px;" v-if="loading">
            <i class="fa fa-circle-o-notch fa-spin"></i>
        </div>
        <canvas id="sizeChart" v-show="!loading"></canvas>
    </div>
  </div>
</div>
--}}

{{-- Value Vinyl --}}
<div class="col-md-3">
  <div class="panel panel-default valueVinyl">
    <div class="panel-heading"><strong>Treasure</strong><span class="pull-right label label-success">
      @if(isset($valueVinyl))
        {{ number_format((float)$valueVinyl->price, 2, '.', '').' '.$user->currency }}
      @else
        0 {{ $user->currency }}
      @endif
    </span></div>
    <div class="panel-body">
      @if(isset($valueVinyl))
        <a href="{{ route('get.show.vinyl', $valueVinyl->id) }}"><img src="{{ $valueVinyl->artwork }}" alt="{{ $valueVinyl->artist }} - {{ $valueVinyl->title }}" class="thumbnail" width="100%"></a>
        <p style="margin-bottom: 0;">
          <strong>{{ $valueVinyl->artist }}</strong><br>
          <span>{{ $valueVinyl->title }}</span>
        </p>
      @else
        <img class="thumbnail" src="/images/PH_vinyl.svg" alt="empty vinyl" width="100%">
      @endif
    </div>
  </div>
</div>

{{-- Times --}}
<div class="col-md-12">
  <div class="panel panel-default">
    <div class="panel-heading"><strong>Record Release Dates</strong></div>
    <div class="panel-body">
        <div class="text-center" style="font-size: 42px;" v-if="loading">
            <i class="fa fa-circle-o-notch fa-spin"></i>
        </div>
        <canvas id="timeChart" v-show="!loading"></canvas>
    </div>
  </div>
</div>
