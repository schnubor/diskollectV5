<hr>  
{!! Form::open() !!}
  {!! Form::hidden('userIdToFollow', $user->id) !!}
  <button class="btn btn-md btn-primary" type="submit">Follow {{ $user->username }}</button>
{!! Form::close() !!}