import Vue from 'vue'
import Standalone from './components/Standalone.vue'
import 'promise-polyfill/src/polyfill'

var vue_app = new Vue({
    el: '#app',
    components: {
        'standalone': Standalone,
    },
    data: {
        showFile: false,
    },
    methods: {
        standalone(url) {
            //do stuff?
        },
    }

});

