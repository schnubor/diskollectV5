@if(Auth::check())
  @if($user->isFollowedBy(Auth::user()))
    {!! Form::open([ 'route' => ['unfollow', $user->id], 'method' => 'delete' ]) !!}
      <button class="btn btn-md btn-default btn-follow" type="submit"><i class="fa fa-fw fa-minus"></i> Unfollow</button>
    {!! Form::close() !!}
  @else
    {!! Form::open([ 'route' => 'follow' ]) !!}
      {!! Form::hidden('userIdToFollow', $user->id) !!}
      <button class="btn btn-md btn-primary btn-follow" type="submit"><i class="fa fa-fw fa-plus"></i> Follow</button>
    {!! Form::close() !!}
  @endif
@else
  {!! Form::open([ 'route' => 'follow' ]) !!}
    {!! Form::hidden('userIdToFollow', $user->id) !!}
    <button class="btn btn-md btn-primary btn-follow" type="submit"><i class="fa fa-fw fa-plus"></i> Follow</button>
  {!! Form::close() !!}
@endif
