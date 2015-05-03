root = exports ? this

root.getStats = (userId) ->
    console.log 'user: '+userId

    genreChart = c3.generate
        bindto: '#genreChart'
        data:
            columns: [
                ["setosa", 1],
                ["versicolor", 2],
                ["virginica", 3],
            ]
            type: 'donut'
        legend:
            show: true
        donut:
            title: '1124 Vinyls'
            label:
                format: (value) ->
                    return value

    sizeChart = c3.generate
        bindto: '#sizeChart'
        data:
            x: 'x'
            columns: [
                ['x', '7 inch', '10 inch', '12 inch']
                ['sizes', 30, 200, 100]
            ]
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