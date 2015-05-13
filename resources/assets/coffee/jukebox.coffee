$.jukebox = (userId) ->
    console.log 'user: '+userId

    vinyls = []
    videos = []

    vinylsRequest = $.ajax
        url: '/api/user/'+userId+'/vinyls'
        type: 'GET'
        dataType: 'JSON'
        error: (x,status,error) ->
          console.log status
          console.log error
        success: (response) -> # search results received
            vinyls = response
            console.log vinyls

            # pick a random vinyl
            vinyl = vinyls[Math.floor(Math.random()*vinyls.length)]
            console.log vinyl.id

            # try to fetch a video for that vinyl
            videoRequest = $.ajax
                url: '/api/vinyl/'+vinyl.id+'/videos'
                type: 'GET'
                dataType: 'JSON'
                error: (x,status,error) ->
                  console.log status
                  console.log error
                success: (response) -> # search results received
                    console.log response
                    if(response.length)
                        console.log vinyl
                        console.log response[Math.floor(Math.random()*response.length)]
                    else
                        $.jukebox(userId)


            #on sucess: display the vinyl and the video 

