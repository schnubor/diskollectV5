@if($vinyls->count())
  @foreach(array_chunk($vinyls->all(), 4) as $vinylRow)
    <div class="row padding15">
      @foreach($vinylRow as $vinyl)
        <div class="col-md-3 vinyl">
          <div class="cover">
            <a href="{{ route('get.show.vinyl', $vinyl->id) }}"><img src="{{$vinyl->artwork}}" alt="{{$vinyl->artist}} - {{$vinyl->title}}"></a>
          </div>
          <div class="info">
            <span class="artist">{{$vinyl->artist}}</span><br>
            <span class="title">{{$vinyl->title}}</span>
          </div>
        </div>
      @endforeach
    </div>
  @endforeach
  <div class="row text-center">
    {!! $vinyls->render() !!}
  </div>
@else
  <div class="col-md-12 text-center">
    <p class="placeholder">No vinyls in the collection yet.</p>
    @if(Auth::user()->id == $user->id)
      <a href="{{ route('get.search') }}" class="btn btn-primary btn-lg"><i class="fa fa-fw fa-plus"></i> Add vinyl</a>
    @endif
  </div>
@endif