$.fetchVinylPage = (page) ->
    vinyls = []
    $vinyls = $.ajax
        url: '/api/user/'+userId+'/vinyls'
        type: 'GET'
        dataType: 'JSON'
        error: (x,status,error) ->
            console.log status
            console.log error
        success: (response) ->
            return response.data

$.getStats = (userId) ->
    $vinyls = $.ajax
        url: '/api/user/'+userId+'/vinyls/all'
        type: 'GET'
        dataType: 'JSON'
        error: (x,status,error) ->
            console.log status
            console.log error
        success: (vinyls) -> # search results received
            # console.log vinyls
            genreData = []

            sizeData = [
                ['x'],
                ['sizes']
            ]
            sizeData_temp = []

            timeData = [
                ['x']
                ['vinyls']
            ]
            timeData_temp = []

            _.each vinyls, (vinyl) ->
                # --- Genre --------------------------------
                genre = vinyl.genre.split(';')[0]
                genre = "unknown" if genre is ""
                genreData.push(genre)

                # --- Size --------------------------------
                size = vinyl.size
                sizeData_temp.push(size)

                # --- Time --------------------------------
                time = new Date(vinyl.releasedate)
                if time.getFullYear()
                    timeData_temp.push(time.format('Y'))

            # console.log timeData_temp

            genreData = _.chain(genreData).countBy().toPairs().value()

            sizeData_temp = _.chain(sizeData_temp).countBy().toPairs().value()
            _.each sizeData_temp, (sizeArray) ->
                sizeData[0].push(sizeArray[0])
                sizeData[1].push(sizeArray[1])

            timeData_temp = _.chain(timeData_temp).countBy().toPairs().value()
            _.each timeData_temp, (timeArray) ->
                timeData[0].push(timeArray[0])
                timeData[1].push(timeArray[1])

            # console.log timeData

            # --- Charts --------------------------------
            genreChart = c3.generate
                bindto: '#genreChart'
                data:
                    columns: genreData
                    type: 'donut'
                legend:
                    show: true
                donut:
                    title: vinyls.length + ' Vinyls'
                    label:
                        format: (value) ->
                            return value

            sizeChart = c3.generate
                bindto: '#sizeChart'
                data:
                    x: 'x'
                    columns: sizeData
                    types:
                        sizes: 'bar'
                legend:
                    show: false
                axis:
                    x:
                        type: 'categorized'

            timeChart = c3.generate
                bindto: '#timeChart'
                data:
                    x: 'x'
                    columns: timeData
                legend:
                    show: false
