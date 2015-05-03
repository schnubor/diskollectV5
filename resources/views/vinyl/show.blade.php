@extends('app')

@section('title')
  {{ $vinyl->artist }} - {{ $vinyl->title }}
@endsection

@section('content')
  @include('user.partials.sidebar')

  <div class="col-md-10 no-padding content-area">
    <div class="col-md-12 toolbar">
      <p class="lead">{{ $vinyl->artist }} - {{ $vinyl->title }}</p>
    </div>
    <div class="col-md-12 content">
      {{-- Left side --}}
      <div class="col-md-6">
        <div class="thumbnail">
          <img src="{{ $vinyl->artwork }}" alt="{{ $vinyl->artist }} - {{ $vinyl->title }}">
        </div>
        @if(Auth::user() == $user)
          <div>
            <a href="{{ route('get.edit.vinyl', $vinyl->id)}}" class="btn btn-default btn-sm"><i class="fa fa-fw fa-edit"></i> Edit Vinyl</a>
            {!! Form::open(['route' => ['delete.vinyl', $vinyl->id], 'onsubmit' => 'return confirm(\'Are you sure you want to delete this vinyl?\')', 'style' => 'display: inline;']) !!}
              {!! Form::hidden('_method', 'DELETE') !!}
              {!! Form::button('<i class="fa fa-fw fa-trash"></i> Delete Vinyl', ['class' => 'btn btn-sm btn-default', 'type' => 'submit']) !!}
            {!! Form::close() !!}
          </div>
        @endif
      </div>
        
      {{-- Right side --}}
      <div class="col-md-6">
        {{-- Details --}}
        <div class="panel panel-default">
          <div class="panel-heading">Vinyl Details <span class="label label-success pull-right">{{ $vinyl->price.$user->currency }}</span></div>
          <table class="table table-bordered">
            <tr>
              <td><strong>Label</strong></td>
              <td>{{ $vinyl->label }}</td>
            </tr>
            <tr>
              <td><strong>Cat. No.</strong></td>
              <td>{{ $vinyl->catno }}</td>
            </tr>
            <tr>
              <td><strong>Genre</strong></td>
              <td>{{ $vinyl->genre }}</td>
            </tr>
            <tr>
              <td><strong>Country</strong></td>
              <td>{{ $vinyl->country }}</td>
            </tr>
            <tr>
              <td><strong>Year</strong></td>
              <td>{{ $vinyl->releasedate }}</td>
            </tr>
            <tr>
              <td><strong>Weight</strong></td>
              <td>{{ $vinyl->weight }}g</td>
            </tr>
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
            <tr>
              <td><strong>Notes</strong></td>
              <td>{{ $vinyl->notes }}</td>
            </tr>
          </table>
        </div>
        {{-- Tracklist --}}
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
      
      </div>
    </div>
  </div>
@endsection
