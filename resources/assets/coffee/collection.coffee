Vue.component 'vinyls',
    template: '#vinyls-template'
    props: ['userid']

    data: ->
        list: []
        currentPage: 0
        itemsPerPage: 16
        resultCount: 0
        filter: ""
        sorting: "created_at"

        #classes
        pageButtonClass: "active"

    computed:
        totalPages: ->
            return Math.ceil @resultCount / @itemsPerPage

        nextButtonClass: ->
            return "disabled" if @currentPage >= @totalPages - 1
            return ""

        prevButtonClass: ->
            return "disabled" if @currentPage is 0
            return ""

    created: ->
        @fetchVinylList()

    methods:
        fetchVinylList: ->
            $.getJSON "/api/user/#{@userid}/vinyls/all", (response) =>
                @list = response
                @currentPage = 0

        setPage: (pageNumber) ->
            @currentPage = pageNumber

        nextPage: ->
            @currentPage++ if @currentPage isnt @totalPages

        prevPage: ->
            @currentPage-- if @currentPage > 0

Vue.filter 'chunk', (value, size) ->
    return _.chunk value, size

Vue.filter 'paginate', (list) ->
    @resultCount = list.length
    if @resultCount isnt 0
        @currentPage = @totalPages - 1 if @currentPage >= @totalPages
    else
        @currentPage = 0
    index = @currentPage * @itemsPerPage
    return list.slice index, index + @itemsPerPage

new Vue
    el: '#collection'
