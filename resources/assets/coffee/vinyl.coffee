new Vue
    el: '#singleVinyl'

    methods:
        deleteVinyl: (vinylid, userid) ->
            swal
                title: "Are you sure?"
                text: "This will remove the vinyl from your collection!"
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55"
                confirmButtonText: "Yes, delete it!"
                closeOnConfirm: true
            , ->
                $.ajaxSetup
                    headers:
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                $.ajax
                    url: "/vinyl/#{vinylid}/delete"
                    method: "DELETE"
                    success: ->
                        window.location = "/user/#{userid}/collection"
