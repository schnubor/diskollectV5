$.getStatus = (userId) ->
    $vinyls = $.ajax
        url: '/api/user/'+userId+'/status'
        type: 'GET'
        error: (x,status,error) -> # not connected
            console.warn status
            console.warn error
            $('.js-connectionStatus').removeClass('btn-info').addClass('btn-danger').html('<i class="fa fa-fw fa-exclamation-circle"></i> Not connected')
            $('.js-connectionAction').removeClass 'hidden'
            return false
        success: (response) -> # connected
            $('.js-connectionStatus').removeClass('btn-info').addClass('btn-success').html('<i class="fa fa-fw fa-check"></i> Connected')
            return true
