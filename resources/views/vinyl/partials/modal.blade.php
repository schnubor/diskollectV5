<!-- Modal -->
<div class="modal fade" id="quickAddVinyl" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add vinyl to collection</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6 cover">
            
          </div>
          <div class="col-md-6">
            {!! Form::open(['route' => 'post.create.vinyl', 'id' => 'addVinylForm']) !!}
              {!! Form::hidden('title', Input::old('title')) !!}
              {!! Form::hidden('artist', Input::old('artist')) !!}
              {!! Form::hidden('cover', Input::old('cover')) !!}
              {!! Form::hidden('label', Input::old('label')) !!}
              {!! Form::hidden('catno', Input::old('catno')) !!}
              {!! Form::hidden('genre', Input::old('genre')) !!}
              {!! Form::hidden('country', Input::old('country')) !!}
              {!! Form::hidden('year', Input::old('year')) !!}
              {!! Form::hidden('count', Input::old('count')) !!}
              {!! Form::hidden('format', Input::old('format')) !!}
              {!! Form::hidden('size', Input::old('size')) !!}
              {!! Form::hidden('weight', Input::old('weight')) !!}
              {!! Form::hidden('color', Input::old('color')) !!}
              {!! Form::hidden('type', Input::old('type')) !!}
              {!! Form::hidden('discogs_uri', Input::old('discogs_uri')) !!}
              {!! Form::hidden('release_id', Input::old('release_id')) !!}
              {!! Form::hidden('trackCount', Input::old('trackCount')) !!}
              {!! Form::hidden('videoCount', Input::old('videoCount')) !!}
              {!! Form::hidden('userCurrency', $user->currency, ['id' => 'userCurrency']) !!}
            <div class="form-group">
              <label id="priceLabelText">Discogs Median Price:</label>
              <div class="input-group">
                <p class="h1" id="price">Fetching...</p>
                {!! Form::hidden('price', Input::old('price'), ['class' => 'form-control', 'required' => 'required']) !!}
                <span class="input-group-addon" id="currencyLabel">.00</span>
              </div>
            </div>
            <div class="form-group">
              <label>Any special notes?</label>
              <textarea class="form-control" placeholder="optional" rows="6" style="resize: none;"></textarea>
            </div>
            
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        {!! Form::submit('Add vinyl', ['class' => 'btn btn-primary', 'id' => 'modalSubmit']) !!}
      </div>
      {!! Form::close() !!}
    </div>
  </div>
</div>