import Vue from 'vue'
import ImageManager from './components/ImageManager.vue'
import 'promise-polyfill/src/polyfill'
import * as clipboard from "clipboard-polyfill"

var vue_app = new Vue({
    el: '#app',
    components: {
        'image-manager': ImageManager,
    },
    methods: {
        useImage(url) {
            if(url.field_name != '') {
                
                    window.parent.postMessage({
                        mceAction: 'customAction',
                        content: url.url
                    }, '*');
                
            } else {
                clipboard.writeText(url.url);
                alert('Copied to Clipboard');
            }
        }
       
    },
    mounted() {
        
    },
})
