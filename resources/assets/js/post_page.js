import Vue from 'vue'
import Standalone from './components/Standalone.vue'
import 'promise-polyfill/src/polyfill'


window.vue_app = new Vue({
    el: '#app',
    components: {
        'standalone': Standalone,
    },
    data: {
        showFile: false,
        category: false,
        site_data: {
            'post': {
                'title': '',
                'content': '',
                'image': '',
                'include_posts': '',
                'scripts': '',
            }
        },
        imageRight: image_right,
        imageLeft: image_left,
        col2: col_2,
        col3: col_3,
        formChange: false,
    },
    watch: {
        site_data: {
            handler: function(newVal, oldVal) {
                this.formChange = true; 
                if (this.formChange) {
                    $(window).bind('beforeunload', function(){
                        let action_btn = $('#submit_btn');
                        if (action_btn.data('action') == "edit") { 
                            return '>>>>>Are you sure you want to leave this page?<<<<<<<< \n Any unsaved changes would be discarded.';
                        }
                    });
                }
            },
            deep: true
        }
    },
    methods: {
        stuffChanged() {
            window.dirty = true;
        },
        tinyInsert(content) {
            tinymce.activeEditor.execCommand('mceInsertContent', false, content);
        },
        create_category() {
            this.category = !this.category;
        },
        standalone(url) {
            this.site_data.post.image = url;
            this.showFile = false;
        },
        includePosts: function () {
            if (this.site_data.post.include_posts == true) {
                this.site_data.news = this.site_data.bad_news;
            } else {
                this.site_data.bad_news = this.site_data.news;
                this.site_data.news = '';
            }
            $.get(TemplateUrl, function (data) {
                var html = data.html;
                //get data
                var tmpl_html = Mustache.to_html(html, vue_app.site_data);
                $('#return').html("<iframe id=" + '"preview-iframe"' + " name=" + '"preview-iframe"' + " class='embed-responsive-item' style='border: 1px solid #ddd;' src=" +
                    "data:text/html;charset=utf-8," + encodeURIComponent(tmpl_html) +
                    "></iframe>");
            });
        }
    },
    mounted: function () {
        var self = this;
        let WebsiteDataUrl = $('#app').attr('data-href');

        if (WebsiteDataUrl.length == 0) return;

        $.get(WebsiteDataUrl, function (data) {
            // console.log(data.data);
            self.site_data = data.data;
            tinymce.get('body').setContent(data.data.post.content);
        });
    }
});