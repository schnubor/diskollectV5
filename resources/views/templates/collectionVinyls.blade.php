<template id="vinyls-template">
    @if($vinyls->count())
        <div v-if="loading">
            <div class="loading text-center"><i class="fa fa-circle-o-notch fa-spin"></i></div>
        </div>
        <div v-else>
            <div class="vinylControls row">
                <div class="col-md-2">
                    <input type="text" class="form-control" placeholder="Filter" v-model="filter">
                </div>
                <div class="col-md-2">
                    <select class="form-control" v-model="sorting">
                        <option value="created_at" selected>Latest</option>
                        <option value="artist">Artist</option>
                        <option value="title">Title</option>
                        <option value="label">Label</option>
                        <option value="price">Price</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <button class="btn btn-default btn-block" @click="changeOrder()"><i :class="orderButtonClass"></i></button>
                </div>
                <nav class="col-md-3">
                    <button class="btn btn-default" :class="prevButtonClass" @click="prevPage()"><i class="fa fa-chevron-left"></i></button>
                    <ul class="pagination no-margin">
                        <li style="padding: 0 10px;">Page @{{ currentPage + 1 }}</li>
                    </ul>
                    <button class="btn btn-default" :class="nextButtonClass" @click="nextPage()"><i class="fa fa-chevron-right"></i></button>
                </nav>
            </div>

            <hr>

            <div class="row padding15">
              <div v-for="group in list | filterBy filter in 'artist' 'title' 'label' 'catno' | orderBy sorting order | paginate | chunk 4" class="row vinylRow">
                <div class="col-md-3 vinyl" v-for="vinyl in group">
                  <div class="cover">
                    <div class="vinylContent">
                        <a href="/vinyl/@{{ vinyl.id }}">
                            <div class="overlay">
                                <div class="price">@{{ parseFloat(vinyl.price).toFixed(2) }} {{ Auth::user()->currency }}</div>
                            </div>
                            <img :src="vinyl.artwork" alt="@{{ vinyl.artist }} - @{{ vinyl.title }}">
                        </a>
                        <div class="actions">
                            <a href="/vinyl/@{{ vinyl.id }}/edit" class="btn btn-default edit"><i class="fa fa-edit"></i></a>
                            <button class="btn btn-default delete" @click="deleteVinyl(vinyl, $event)"><i class="fa fa-trash-o"></i></button>
                        </div>
                    </div>
                  </div>
                  <div class="info">
                    <span class="artist">@{{ vinyl.artist }}</span><br>
                    <span class="title">@{{ vinyl.title }}</span>
                  </div>
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
