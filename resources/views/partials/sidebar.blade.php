<div class="col-md-4 text-center sidebar">
  <div class="avatar-big center-block" style="background-image: url('{{ $user->image }}')"></div>
  <h1>{{ $user->username }}</h1>
  @if($user->name || $user->location || $user->website || $user->description)
    <hr>
    <p class="lead">
      @if($user->name)
        <span>{{ $user->name }},</span>
      @endif
      @if($user->location)
        <span>{{ $user->location }},</span>
      @endif
      @if($user->website)
        <span><a href="{{ $user->website }}" target="_blank">{{ $user->website }}</a></span>
      @endif
      @if($user->description)
        <hr><span class="lead">{{ $user->description }}</span>
      @endif
    </p>
  @endif
  
  <!-- Follow Button -->
  @if(! Auth::check())
    @include('user.partials.follow')
  @endif
</div>