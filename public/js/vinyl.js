(function() {
  new Vue({
    el: '#singleVinyl',
    methods: {
      deleteVinyl: function(vinylid, userid) {
        return swal({
          title: "Are you sure?",
          text: "This will remove the vinyl from your collection!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Yes, delete it!",
          closeOnConfirm: true
        }, function() {
          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });
          return $.ajax({
            url: "/vinyl/" + vinylid + "/delete",
            method: "DELETE",
            success: function() {
              return window.location = "/user/" + userid + "/collection";
            }
          });
        });
      }
    }
  });

}).call(this);

//# sourceMappingURL=vinyl.js.map