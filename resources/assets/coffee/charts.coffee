userId = $('#statistics').data('userid')

new Vue
    el: '#statistics'

    data:
        loading: true
        vinyls: []
        userId: userId
        genreData:
            labels: []
            datasets: [
                {
                    label: "Genre Distrbution"
                    backgroundColor: [
                        "#56c9b8",
                        "#2f9fc2",
                        "#4466b3",
                        "#7d4193",
                        "#975aaa",
                        "#a44b8b",
                        "#be5f5f",
                        "#b98657",
                        "#e8c56a",
                        "#bee488",
                        "#60b04c",
                        "#5fda9b"
                    ]
                    hoverBorderColor: "#FFF"
                    data: []
                }
            ]
        sizeData:
            labels: []
            datasets: [
                {
                    label: "Vinyl Sizes"
                    backgroundColor: [
                        "#202020",
                        "#404040",
                        "#606060"
                    ]
                    hoverBorderColor: "#FFF"
                    data: []
                }
            ]
        timeData:
            labels: []
            datasets: [
                {
                    label: "Vinyl Release Dates"
                    fill: false,
                    lineTension: 0.1,
                    backgroundColor: "rgba(75,192,192,0.4)"
                    borderColor: "rgba(75,192,192,1)"
                    borderCapStyle: 'butt'
                    borderDash: []
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter'
                    pointBorderColor: "rgba(75,192,192,1)"
                    pointBackgroundColor: "#fff"
                    pointBorderWidth: 1
                    pointHoverRadius: 5
                    pointHoverBackgroundColor: "rgba(75,192,192,1)"
                    pointHoverBorderColor: "rgba(220,220,220,1)"
                    pointHoverBorderWidth: 2
                    pointRadius: 1
                    pointHitRadius: 10
                    data: []
                }
            ]

    methods:
        fetchVinylList: (userId) ->
            $.getJSON "/api/user/#{userId}/vinyls/all", (response) =>
                @vinyls = response
                @loading = false
                @generateCharts(@vinyls)

        generateCharts: (vinyls) ->
            allGenres = []
            allSizes = []
            allTimes = []

            genreCount = []
            sizeCount = []
            timeCount = []

            _.each vinyls, (vinyl) ->
                # Genre
                genre = vinyl.genre.split(';')[0]
                genre = "unknown" if genre is ""
                allGenres.push(genre)
                genreCount = _.chain(allGenres).countBy().toPairs().value()
                # Sizes
                size = vinyl.size
                allSizes.push(size)
                sizeCount = _.chain(allSizes).countBy().toPairs().value()
                # Times
                time = vinyl.releasedate
                allTimes.push(time)
                timeCount = _.chain(allTimes).countBy().toPairs().value()

            _.each genreCount, (genre) =>
                @genreData.labels.push(genre[0])
                @genreData.datasets[0].data.push(genre[1])

            _.each sizeCount, (size) =>
                @sizeData.labels.push("#{size[0]}inch")
                @sizeData.datasets[0].data.push(size[1])

            _.each timeCount, (time) =>
                @timeData.labels.push("#{time[0]}")
                @timeData.datasets[0].data.push(time[1])

            genreChartCanvas = $("#genreChart")
            genreChart = new Chart genreChartCanvas,
                type: 'pie',
                data: @genreData

            sizeChartCanvas = $("#sizeChart")
            sizeChart = new Chart sizeChartCanvas,
                type: 'pie',
                data: @sizeData

            timeChartCanvas = $("#timeChart")
            timeChart = new Chart timeChartCanvas,
                type: 'line',
                data: @timeData

    ready: ->
        @fetchVinylList(@userId)
