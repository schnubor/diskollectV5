new Vue
    el: '#settings'

    data:
        confirm: ""

    computed:
        disabled: ->
            return false if @confirm is "delete"
            return true
