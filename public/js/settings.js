(function() {
  new Vue({
    el: '#settings',
    data: {
      confirm: ""
    },
    computed: {
      disabled: function() {
        if (this.confirm === "delete") {
          return false;
        }
        return true;
      }
    }
  });

}).call(this);

//# sourceMappingURL=settings.js.map
