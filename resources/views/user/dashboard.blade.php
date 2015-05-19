@extends('app')

@section('title')
  Dashboard
@endsection

@section('content')
  @include('user.partials.sidebar')
  <div class="col-md-10 no-padding content-area">
    <div class="col-md-12 toolbar">
      <p class="lead news">
        Welcome <a href="{{ route('user.show', $latestUser->id) }}">{{ $latestUser->username }}</a> to the party!
      </p>
      @include('user.partials.follow', ['user' => $latestUser])
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
                      <h4 class="media-heading"><a href="{{ route('user.show', $activity->user_id) }}">{{ $activity->username }}</a> added a new vinyl to his collection.</h4>
                      <p>{{ $activity->time }} ago</p>
                      <div class="thumbnail">
                        <a href="{{ route('get.show.vinyl', $activity->id) }}"><img src="{{ $activity->artwork }}" alt="{{ $activity->artist }} - {{ $activity->title }}" width="100%"></a>
                      </div>
                      <p>
                        <strong>{{ $activity->artist }}</strong> - {{ $activity->title }}
                      </p>
                    </div>
                  </div>
                </li>
              @endforeach
            </ul>
          @else
            <div class="panel-body">
              <p class="text-center" style="margin: 40px 0;">
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
@endsection