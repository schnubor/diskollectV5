<div class="avatar sm" style="background-image: url('{{ $user->image }}')"></div>
<div class="lead dropdown">
  <strong class="toggle-dropdown" data-toggle="dropdown" aria-expanded="false" id="userDropdown" role="button">{{ $user->username }}<span class="caret"></span></strong>
  <ul class="dropdown-menu" role="menu" aria-labelledby="userDropdown">
    <li role="presentation"><a role="menuitem" tabindex="-1" href="{{ route('user.collection', $user->id) }}"><i class="fa fa-fw fa-database"></i> Collection</a></li>
    <li role="presentation"><a role="menuitem" tabindex="-1" href="{{ route('user.show', $user->id) }}"><i class="fa fa-fw fa-area-chart"></i> Statistics</a></li>
    <li role="presentation"><a role="menuitem" tabindex="-1" href="{{ route('user.jukebox', $user->id) }}"><i class="fa fa-fw fa-music"></i> Jukebox</a></li>
    <li class="divider"></li>
    <li role="presentation"><a role="menuitem" tabindex="-1" href="{{ route('user.followers', $user->id) }}">{{ $user->followers->count() }} Follower</a></li>
    <li role="presentation"><a role="menuitem" tabindex="-1" href="{{ route('user.following', $user->id) }}">{{ $user->following->count() }} Following</a></li>
  </ul>
</div>
<div class="pull-right">@include('user.partials.follow')</div>