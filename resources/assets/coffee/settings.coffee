new Vue
    el: '#settings'

    data:
        confirm: ""

    computed:
        disabled: ->
            return false if @confirm is "delete"
            return true

    methods:
        delete: ->
            console.log "delete!"
