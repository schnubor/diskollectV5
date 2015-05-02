chart = c3.generate
    bindto: '#genreChart'
    data:
        columns: [
            ['data1', 30, 200, 100, 400, 150, 250]
        ]
        types:
            data1: 'bar'
    axis:
        rotated: true