<div class="modal fade" id="deleteCollectionModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Delete collection</h4>
      </div>
      <div class="modal-body">
        <p>
            This will delete your entire collection. Type "delete" below to confirm this action.
        </p>
        <input type="text" v-model="confirm" class="form-control input-lg">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" :disabled="disabled"><i class="fa fa-trash-o"></i> Delete Collection</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
