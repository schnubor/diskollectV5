<template id="vinyls-template">
    @if($vinyls->count())
        <div class="vinylControls row">
            <div class="col-md-2">
                <input type="text" class="form-control" placeholder="Filter" v-model="filter">
            </div>
            <div class="col-md-2">
                <select class="form-control col-md-3" v-model="sorting">
                    <option value="created_at" selected>Latest</option>
                    <option value="artist">Artist</option>
                    <option value="title">Title</option>
                    <option value="label">Label</option>
                    <option value="price">Price</option>
                </select>
            </div>
            <nav>
              <ul class="pagination no-margin">
                <li v-bind:class="prevButtonClass" @click="prevPage()"><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
                <li v-for="pageNumber in totalPages" v-bind:class="pageNumber == currentPage ? pageButtonClass : ''">
                  <a href="#" @click="setPage(pageNumber)">@{{ pageNumber + 1 }}</a>
                </li>
                <li v-bind:class="nextButtonClass" @click="nextPage()"><a href="#" aria-label="Next"><span aria-hidden="true">»</span></a></li>
              </ul>
            </nav>
        </div>

        <hr>

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
