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
            <div class="form-group">
              <label>What did you pay?</label>
              <div class="input-group">
                <input type="text" class="form-control" placeholder="required">
                <span class="input-group-addon" id="basic-addon1">{{ $user->currency }}</span>
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
        <button type="button" class="btn btn-primary">Add vinyl</button>
      </div>
    </div>
  </div>
</div>