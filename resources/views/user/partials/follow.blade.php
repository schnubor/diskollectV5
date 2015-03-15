<hr>
@if($user->isFollowedBy(Auth::user()))
  <button class="btn btn-md btn-primary" disabled>Followed</button>
@else
  {!! Form::open([ 'route' => 'follow' ]) !!}
    {!! Form::hidden('userIdToFollow', $user->id) !!}
    <button class="btn btn-md btn-primary" type="submit">Follow {{ $user->username }}</button>
  {!! Form::close() !!}
@endif