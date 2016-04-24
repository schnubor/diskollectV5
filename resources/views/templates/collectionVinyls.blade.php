<template id="vinyls-template">
    @if($vinyls->count())
        <div class="row padding15">
          <div v-for="group in list | filterBy filter in 'artist' 'title' 'label' 'catno' | orderBy sorting | paginate | chunk 4" class="row">
            <div class="col-md-3 vinyl" v-for="vinyl in group">
              <div class="cover">
                <a href="/vinyl/@{{ vinyl.id }}"><img v-bind:src="vinyl.artwork" alt="@{{ vinyl.artist }} - @{{ vinyl.title }}"></a>
              </div>
              <div class="info">
                <span class="artist">@{{ vinyl.artist }}</span><br>
                <span class="title">@{{ vinyl.title }}</span>
              </div>
            </div>
          </div>

          <nav>
            <ul class="pagination">
              <li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
              <li v-for="pageNumber in totalPages">
                <a href="#" @click="setPage(pageNumber)" v-bind:class="current">@{{ pageNumber + 1 }}</a>
              </li>
              <li><a href="#" aria-label="Next"><span aria-hidden="true">»</span></a></li>
            </ul>
          </nav>
        </div>
    @else
      <div class="col-md-12 text-center">
        <p class="placeholder">No vinyls in the collection yet.</p>
        @if(Auth::user()->id == $user->id)
          <a href="{{ route('get.search') }}" class="btn btn-primary btn-lg"><i class="fa fa-fw fa-plus"></i> Add vinyl</a>
        @endif
      </div>
    @endif
</template>
