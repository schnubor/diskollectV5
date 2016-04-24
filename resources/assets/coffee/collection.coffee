Vue.component 'vinyls',
    template: '#vinyls-template'
    props: ['list']

Vue.filter 'chunk', (value, size) ->
    return _.chunk value, size

new Vue
    el: '#collection'
