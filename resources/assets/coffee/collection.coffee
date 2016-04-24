Vue.component 'vinyls',
    template: '#vinyls-template'
    props: ['userid', 'filter']

    data: ->
        return {
            list: []
        }

    created: ->
        @fetchVinylList()

    methods:
        fetchVinylList: ->
            $.getJSON "/api/user/#{@userid}/vinyls/all", (response) =>
                console.log response
                @list = response

Vue.filter 'chunk', (value, size) ->
    return _.chunk value, size

new Vue
    el: '#collection'
    data:
        vinylFilter: ""
