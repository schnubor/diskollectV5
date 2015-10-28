@extends('app')

@section('title')
  {{ $user->username }}
@endsection

@section('content')
  
  <div class="content-area">
    <div class="col-md-12 toolbar">
      @if(Auth::check())
        @if(Auth::user()->id == $user->id)
          <p class="lead"><strong>Your Statistics</strong></p>
        @else
          @include('user.partials.dropdown')
        @endif
      @else
        @include('user.partials.dropdown')
      @endif
    </div>
    
    <div class="col-md-12 content">
      @if($user->statistics_visibility == 'everyone' || Auth::user()->id == $user->id)
        @include('partials.statistics')
      @else {{-- not everyone can the collection --}}
        @if($user->statistics_visibility == 'follower')
          @if($user->isFollowedBy(Auth::user()))
            @include('partials.statistics')
          @else
            <div class="col-md-12 text-center">
              <p class="placeholder">This profile is only visible for followers.</p>
              {!! Form::open([ 'route' => 'follow' ]) !!}
                {!! Form::hidden('userIdToFollow', $user->id) !!}
                <button class="btn btn-md btn-success btn-follow" type="submit"><i class="fa fa-fw fa-plus"></i> Follow</button>
              {!! Form::close() !!}
            </div>
          @endif
        @else
          <div class="col-md-12 text-center">
            <p class="placeholder">This profile is private.</p>
          </div>
        @endif
      @endif
    </div>
  </div>
  
  <!-- Sidebar -->
  @include('user.partials.sidebar')
@endsection

@section('scripts')
  <script>$.getStats({{$user->id}});</script>
@endsection