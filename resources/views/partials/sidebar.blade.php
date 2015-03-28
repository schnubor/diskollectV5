<div class="col-md-2 text-center sidebar">
  <div class="avatar md center-block" style="background-image: url('{{ $user->image }}')"></div>
  <p class="lead">{{ $user->username }}</p>

  <!-- Follow Button -->
  @unless(Auth::user()->id == $user->id)
    @include('user.partials.follow')
  @endunless
  <hr>
  <div class="navigation">
    <a href="">
      <div class="button active">
        <i class="fa fa-fw fa-database blue"></i>
        <span>Collection</span>
        <div class="triangle"></div>
      </div>
    </a>
    <a href="">
      <div class="button">
        <i class="fa fa-fw fa-area-chart green"></i>
        <span>Statistics</span>
        <div class="triangle"></div>
      </div>
    </a>
  </div>

  @if($user->name || $user->location || $user->website || $user->description)
    <p>
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
        <hr><span>{{ $user->description }}</span>
      @endif
    </p>
  @endif
  
</div>