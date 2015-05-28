@extends('app')

@section('title')
  Dashboard
@endsection

@section('content')
  <!-- Content -->
  <div class="content-area">
    <div class="col-md-12 toolbar">
      <p class="lead news">
        Welcome <a href="{{ route('user.show', $latestUser->id) }}">{{ $latestUser->username }}</a> to the party!
      </p>
    </div>
    <div class="col-md-12 content">
      {{-- Activities --}}
      <div class="col-md-6 activities">
        <div class="panel panel-default">
          <div class="panel-heading"><strong>Activities</strong></div>
          @if($activities->count())
            <ul class="list-group">
              @foreach($activities as $activity)
                <li class="list-group-item">
                  <div class="media">
                    <div class="media-left">
                      <a href="{{ route('user.show', $activity->user_id) }}">
                        <div class="avatar sm" style="background-image: url('{{ $activity->image}}')"></div>
                      </a>
                    </div>
                    <div class="media-body">
                      <h4 class="media-heading"><a href="{{ route('user.show', $activity->user_id) }}"><strong>{{ $activity->username }}</strong></a> added a new vinyl.</h4>
                      <small>{{ $activity->time }} ago</small>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-8 vinyl">
                      <a href="{{ route('get.show.vinyl', $activity->id) }}"><img src="{{ $activity->artwork }}" alt="{{ $activity->artist }} - {{ $activity->title }}" width="100%"></a>
                      <p style="margin-top: 10px">
                        <strong>{{ $activity->artist }}</strong> <br> {{ $activity->title }}
                      </p>
                      <hr>
                      <p><small>{{ $activity->price.$activity->currency }}, {{ $activity->genre }}, {{ $activity->label }}, {{ $activity->count }}x {{ $activity->releasetype }}</small></p>
                    </div>
                  </div>
                </li>
              @endforeach
            </ul>
          @else
            <div class="panel-body">
              <p class="text-center placeholder small" style="margin: 40px 0;">
                No recent activities. Try following other collectors! <br><br>
                <a href="{{ route('user.index') }}" class="btn btn-success btn-lg"><i class="fa fa-users"></i> Collectors</a>
              </p>
            </div>
          @endif
        </div>
      </div>
      <div class="col-md-6">
        {{-- Latest Vinyls --}}
        <div class="panel panel-default">
          <div class="panel-heading"><strong>Latest Vinyls on FTR</strong></div>
          <div class="panel-body">
            @foreach(array_chunk($latestVinyls->all(), 2) as $vinylRow)
              <div class="row">
                @foreach($vinylRow as $vinyl)
                  <div class="col-sm-6">
                    <a href="{{route('get.show.vinyl', $vinyl->id)}}"><img src="{{ $vinyl->artwork }}" alt="{{ $vinyl->artist.' - '.$vinyl->title }}" class="thumbnail" width="100%"></a>
                    <p>
                      <strong>{{ $vinyl->artist }}</strong><br>
                      <span>{{ $vinyl->title }}</span>
                    </p>
                  </div>
                @endforeach
              </div>
            @endforeach
          </div>
        </div>

        {{-- Latest Collectors --}}
        <div class="panel panel-default">
          <div class="panel-heading"><strong>Latest Collectors</strong></div>
          <div class="panel-body">
            @foreach($latestMembers as $member)
              <div class="col-sm-3 text-center">
                <a href="{{route('user.show', $member->id)}}"><div class="avatar sm" style="background-image: url('{{ $member->image }}');"></div></a>
                <p>
                  <span>{{ $member->username }}</span>
                </p>
              </div>
            @endforeach
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- Sidebar -->
  @include('user.partials.sidebar')
@endsection