Vue.component 'vinyls',
    template: '#vinyls-template'
    props: ['userid', 'filter', 'sorting']

    data: ->
        list: []
        currentPage: 0
        itemsPerPage: 16
        resultCount: 0

    computed:
        totalPages: ->
            return Math.ceil @resultCount / @itemsPerPage

    created: ->
        @fetchVinylList()

    methods:
        fetchVinylList: ->
            $.getJSON "/api/user/#{@userid}/vinyls/all", (response) =>
                @list = response
                @currentPage = 0

        setPage: (pageNumber) ->
            @currentPage = pageNumber

Vue.filter 'chunk', (value, size) ->
    return _.chunk value, size

Vue.filter 'paginate', (list) ->
    @resultCount = list.length
    console.log 'resultCount: ', @resultCount
    console.log 'totalPages: ', @totalPages
    console.log 'currentPage before: ', @currentPage
    @currentPage = @totalPages - 1 if @currentPage >= @totalPages
    console.log 'currentPage: ', @currentPage
    index = @currentPage * @itemsPerPage
    console.log list.slice index, index + @itemsPerPage
    return list.slice index, index + @itemsPerPage

new Vue
    el: '#collection'
    data:
        vinylFilter: ""
        vinylSorting: "Latest"
