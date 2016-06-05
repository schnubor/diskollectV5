(function() {
  Vue.component('vinyls', {
    template: '#vinyls-template',
    props: ['userid'],
    data: function() {
      return {
        list: [],
        currentPage: 0,
        itemsPerPage: 16,
        resultCount: 0,
        filter: "",
        sorting: "",
        order: 1,
        loading: true
      };
    },
    computed: {
      totalPages: function() {
        return Math.ceil(this.resultCount / this.itemsPerPage);
      },
      nextButtonClass: function() {
        if (this.currentPage >= this.totalPages - 1) {
          return "disabled";
        }
        return "";
      },
      prevButtonClass: function() {
        if (this.currentPage === 0) {
          return "disabled";
        }
        return "";
      },
      orderButtonClass: function() {
        if (this.order === 1) {
          return "fa fa-sort-amount-asc";
        }
        return "fa fa-sort-amount-desc";
      }
    },
    created: function() {
      return this.fetchVinylList();
    },
    methods: {
      deleteVinyl: function(vinyl, event) {
        event.preventDefault();
        event.stopPropagation();
        return swal({
          title: "Are you sure?",
          text: "This will remove the vinyl from your collection!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Yes, delete it!",
          closeOnConfirm: true
        }, (function(_this) {
          return function() {
            console.log("delete vinyl with id=" + vinyl.id);
            $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });
            return $.ajax({
              url: "/vinyl/" + vinyl.id + "/delete",
              method: "DELETE",
              success: function() {
                return _this.list.$remove(vinyl);
              }
            });
          };
        })(this));
      },
      fetchVinylList: function() {
        return $.getJSON("/api/user/" + this.userid + "/vinyls/all", (function(_this) {
          return function(response) {
            _this.list = response;
            _this.currentPage = 0;
            return _this.loading = false;
          };
        })(this));
      },
      setPage: function(pageNumber) {
        return this.currentPage = pageNumber;
      },
      nextPage: function() {
        if (this.currentPage !== this.totalPages) {
          return this.currentPage++;
        }
      },
      prevPage: function() {
        if (this.currentPage > 0) {
          return this.currentPage--;
        }
      },
      changeOrder: function() {
        return this.order = this.order * -1;
      }
    }
  });

  Vue.filter('chunk', function(value, size) {
    return _.chunk(value, size);
  });

  Vue.filter('paginate', function(list) {
    var index;
    this.resultCount = list.length;
    if (this.resultCount !== 0) {
      if (this.currentPage >= this.totalPages) {
        this.currentPage = this.totalPages - 1;
      }
    } else {
      this.currentPage = 0;
    }
    index = this.currentPage * this.itemsPerPage;
    return list.slice(index, index + this.itemsPerPage);
  });

  new Vue({
    el: '#collection'
  });

}).call(this);

//# sourceMappingURL=collection.js.map