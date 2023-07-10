import Vue from 'vue'
import DataTable from './components/DataTable.vue'
import 'promise-polyfill/src/polyfill'

var vue_app = new Vue({
    el: '#app',
    components: {
        'data-table': DataTable,
    },
    data: {
       
    },
    methods: {
        
    }
});

