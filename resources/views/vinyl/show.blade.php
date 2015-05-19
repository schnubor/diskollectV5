@extends('app')

@section('title')
  {{ $vinyl->artist }} - {{ $vinyl->title }}
@endsection

@section('content')
  @include('user.partials.sidebar')

  <div class="col-md-10 no-padding content-area">
    <div class="col-md-12 toolbar">
      <p class="lead pull-left">{{ $vinyl->artist }} - {{ $vinyl->title }}</p>
    </div>
    <div class="col-md-12 content">
      {{-- Left side --}}
      <div class="col-md-6">
        <div class="thumbnail">
          <img src="{{ $vinyl->artwork }}" alt="{{ $vinyl->artist }} - {{ $vinyl->title }}">
        </div>
        @foreach($videos as $video)
          <div class="panel panel-default">
            <div class="panel-heading">{{ $video->title }} <span class="label label-default pull-right">{{ gmdate('H:i:s', $video->duration) }}</span></div>
            <div class="panel-body">
              <div class="embed-responsive embed-responsive-16by9">
                <iframe class="embed-responsive-item" src="{{ $video->uri }}"></iframe>
              </div>
            </div>
          </div>
        @endforeach
      </div>
        
      {{-- Right side --}}
      <div class="col-md-6">
        {{-- Details --}}
        <div class="panel panel-default">
          <div class="panel-heading">Vinyl Details</div>
          <div class="panel-body">
            <p class="h2 text-center">{{ $vinyl->price.$user->currency }}</p>
          </div>
          <table class="table table-bordered">
            @if($vinyl->discogs_uri)
              <tr>
                <td><strong>Discogs</strong></td>
                <td><a href="{{ $vinyl->discogs_uri }}" target="_blank">{{ $vinyl->discogs_uri }}</a></td>
              </tr>
            @endif
            @if($vinyl->label)
              <tr>
                <td><strong>Label</strong></td>
                <td>{{ $vinyl->label }}</td>
              </tr>
            @endif
            @if($vinyl->catno)
              <tr>
                <td><strong>Cat. No.</strong></td>
                <td>{{ $vinyl->catno }}</td>
              </tr>
            @endif
            @if($vinyl->genre)
              <tr>
                <td><strong>Genre</strong></td>
                <td>{{ $vinyl->genre }}</td>
              </tr>
            @endif
            @if($vinyl->country)
              <tr>
                <td><strong>Country</strong></td>
                <td>{{ $vinyl->country }}</td>
              </tr>
            @endif
            @if($vinyl->year)
              <tr>
                <td><strong>Year</strong></td>
                <td>{{ $vinyl->releasedate }}</td>
              </tr>
            @endif
            @if($vinyl->weight)
              <tr>
                <td><strong>Weight</strong></td>
                <td>{{ $vinyl->weight }}g</td>
              </tr>
            @endif
            <tr>
              <td><strong>Type</strong></td>
              <td>{{ $vinyl->count }}x {{ $vinyl->size }}" {{ $vinyl->releasetype }}</td>
            </tr>
            <tr>
              <td><strong>Added</strong></td>
              <td>{{ date("d F Y", strtotime($vinyl->created_at)) }}</td>
            </tr>
            <tr>
              <td><strong>Updated</strong></td>
              <td>{{ date("d F Y", strtotime($vinyl->updated_at)) }}</td>
            </tr>
            @if($vinyl->notes)
              <tr>
                <td><strong>Notes</strong></td>
                <td>{{ $vinyl->notes }}</td>
              </tr>
            @endif
          </table>
        </div>
        {{-- Tracklist --}}
        @if($tracks)
          <div class="panel panel-default">
            <div class="panel-heading">Tracklist <span class="badge pull-right">{{ $tracks->count() }}</span>
            </div>
            <table class="table table-bordered">
              @foreach($tracks as $track)
                <tr>
                  <td>{{ $track->number }}</td>
                  <td>{{ $track->title }}</td>
                  <td>{{ $track->duration }}</td>
                </tr>
              @endforeach
            </table>
          </div>
        @endif

        @if(Auth::user() == $user)
          <div class="pull-left">
            <a href="{{ route('get.edit.vinyl', $vinyl->id)}}" class="btn btn-default btn-sm" style="vertical-align: top;"><i class="fa fa-fw fa-edit"></i> Edit</a>
            {!! Form::open(['route' => ['delete.vinyl', $vinyl->id], 'onsubmit' => 'return confirm(\'Are you sure you want to delete this vinyl?\')', 'style' => 'display: inline;']) !!}
              {!! Form::hidden('_method', 'DELETE') !!}
              {!! Form::button('<i class="fa fa-fw fa-trash"></i> Delete', ['class' => 'btn btn-sm btn-default', 'type' => 'submit']) !!}
            {!! Form::close() !!}
          </div>
        @endif
      
      </div>
    </div>
  </div>
@endsection
