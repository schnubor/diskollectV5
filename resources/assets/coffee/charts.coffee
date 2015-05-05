root = exports ? this

root.getStats = (userId) ->
  console.log 'user: '+userId

  $vinyls = $.ajax
    url: '/api/user/'+userId+'/vinyls'
    type: 'GET'
    dataType: 'JSON'
    error: (x,status,error) ->
      console.log status
      console.log error
    success: (vinyls) -> # search results received
      console.log vinyls

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
        if genre == ""
          genre = "unknown"
        genreData.push(genre)

        # --- Size --------------------------------
        size = vinyl.size
        sizeData_temp.push(size)

        # --- Time --------------------------------
        time = vinyl.releasedate.substr(vinyl.releasedate.length - 4)
        if time != ""
          timeData_temp.push(time)
      
      genreData = _.chain(genreData).countBy().pairs().value()

      sizeData_temp = _.chain(sizeData_temp).countBy().pairs().value()
      _.each sizeData_temp, (sizeArray) ->
        sizeData[0].push(sizeArray[0])
        sizeData[1].push(sizeArray[1])

      timeData_temp = _.chain(timeData_temp).countBy().pairs().value()
      _.each timeData_temp, (timeArray) ->
        timeData[0].push(timeArray[0])
        timeData[1].push(timeArray[1])

      genreChart = c3.generate
        bindto: '#genreChart'
        data:
          columns: genreData
          type: 'donut'
        legend:
          show: true
        donut:
          title: vinyls.length+' Vinyls'
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
          columns: [
            ['x', '2010-01-01', '2011-01-01', '2012-01-01', '2013-01-01', '2014-01-01', '2015-01-01']
            ['vinyls', 30, 200, 100, 400, 150, 250]
          ]
        axis:
          x: 
            type: 'timeseries'
            tick:
              format: (x) -> 
                return x.getFullYear()
        legend:
          show: false