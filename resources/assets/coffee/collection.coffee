Vue.component 'vinyls',
    template: '#vinyls-template'
    props: ['userid']

    data: ->
        list: []
        currentPage: 0
        itemsPerPage: 16
        resultCount: 0
        filter: ""
        sorting: ""
        order: 1
        loading: true

    computed:
        totalPages: ->
            return Math.ceil @resultCount / @itemsPerPage

        nextButtonClass: ->
            return "disabled" if @currentPage >= @totalPages - 1
            return ""

        prevButtonClass: ->
            return "disabled" if @currentPage is 0
            return ""

        orderButtonClass: ->
            return "fa fa-sort-amount-asc" if @order is 1
            return "fa fa-sort-amount-desc"

    created: ->
        @fetchVinylList()

    methods:
        deleteVinyl: (vinyl, event) ->
            event.preventDefault()
            event.stopPropagation()

            swal
                title: "Are you sure?"
                text: "This will remove the vinyl from your collection!"
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55"
                confirmButtonText: "Yes, delete it!"
                closeOnConfirm: true
            , =>
                console.log "delete vinyl with id=#{vinyl.id}"
                $.ajaxSetup
                    headers:
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                $.ajax
                    url: "/vinyl/#{vinyl.id}/delete"
                    method: "DELETE"
                    success: =>
                        console.log "deleted!"
                        @list.$remove(vinyl)

        fetchVinylList: ->
            $.getJSON "/api/user/#{@userid}/vinyls/all", (response) =>
                @list = response
                @currentPage = 0
                @loading = false

        setPage: (pageNumber) ->
            @currentPage = pageNumber

        nextPage: ->
            @currentPage++ if @currentPage isnt @totalPages

        prevPage: ->
            @currentPage-- if @currentPage > 0

        changeOrder: ->
            @order = @order * -1


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
