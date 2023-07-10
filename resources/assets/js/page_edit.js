import Vue from 'vue'
import Standalone from './components/Standalone.vue'
import 'promise-polyfill/src/polyfill'
import Editor from '@tinymce/tinymce-vue'
import ImageContainer from "./components/Image.vue"
import axios from 'axios'
import VueSwal from 'vue-swal'
import _ from 'lodash'

import draggable from 'vuedraggable'
import datePicker from 'vue-bootstrap-datetimepicker'
import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css'

import {
    isEqual
} from 'lodash'
Vue.use(VueSwal);
window.vue_app = new Vue({
    el: '#app',
    components: {
        'standalone': Standalone,
        'editor': Editor,
        'imagecontainer': ImageContainer,
        'vueswal': VueSwal,
        'datePicker': datePicker,
        draggable,
    },
    data: {
        config: {
            format: 'YYYY-MM-DD',
            useCurrent: false,
        },
        title_error: false,
        submit_disabled: false,
        menu_id: menu_id,
        currentTab: 2,
        newItem: {},
        currentItem: null,
        shouldPrevent: false,
        pageInfoAdv: false,
        showFile: false,
        category: false,
        site_data: {
            'base_url': '',
            'home_url': '',
            'menu': [],
            'menus': [],

            'post': {
                'title': '',
                'content': '',
                'status': 'live',
                'image': page_image,
                'include_posts': '',
                'scripts': '',
                'settings': {
                    'gallery': [],
                    'showGallery': false,
                },
            },
            'same_as': '',
            'site_name': '',
            'token': '',
            'year': new Date().getFullYear(),
        },
        imageRight: image_right,
        imageLeft: image_left,
        col2: col_2,
        col3: col_3,
        init: init,
        preview_html: '',
        preview_style: {},
        preview_type: 'desktop',
        updateMsg: false,
        formChange: false,
        showTemplates: false,
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
    computed: {
        pageTitle() {
          return this.site_data.post.title;
        },
        formData() {
            return {
                'title': this.pageTitle,
                'content': this.site_data.post.content,
                'image': this.site_data.post.image,
                'menu': this.site_data.menus,
                'scripts': this.site_data.post.scripts,
                'status': this.site_data.post.status,
                'settings': this.site_data.post.settings,
                'gallery': this.gallery,
                'showGallery': this.site_data.showGallery,
                'include_posts': this.site_data.post.include_posts,
                'json': true,
                'post_category': this.site_data.post.post_category,
                'start_time': this.site_data.post.start_time,
            }
        },
        gallery() {
            var gallery = (this.site_data.post.settings.gallery != undefined) ? JSON.parse(JSON.stringify(this.site_data.post.settings.gallery)) : [];
            if (!this.isEmpty(this.newItem)) {
                gallery.push(this.newItem);
            }
            return JSON.stringify(gallery);
        },
        shouldWePrevent() {
            return this.shouldPrevent;
        }
    },
    watch: {
        pageTitle() {
          this.checkTitle();
        },
        formData() {
            this.dirty();
        }
    },
    beforeMount() {
        window.addEventListener("beforeunload", this.preventNav)
    },
    beforeDestroy() {
        // Don't forget to clean up event listeners
        window.removeEventListener("beforeunload", this.preventNav)
    },
    methods: {
        checkTitle: 
           _.debounce(function() {
             this.checkTheTitle();
           }, 300
        ), 
        checkTheTitle() {
          axios.get(title_check_url + '&title=' + this.pageTitle).then((response) => {
              if (response.data.status == 'fail') {
                  this.title_error = true;
              } else {
                  this.title_error = false;
              }
          });
        },
        dirty() {
            this.shouldPrevent = true;
        },
        preventNav(e) {
            if (!this.shouldWePrevent) return
            e.preventDefault()
            e.returnValue = ""
        },
        toggleAdv() {
            this.pageInfoAdv = !this.pageInfoAdv;
        },
        editItem(index) {
            this.currentItem = index;
        },
        itemSave() {
            this.currentItem = null;
        },
        itemUpdate(url) {
            this.site_data.post.settings.gallery[url.field_name].url = url.url;
        },
        newItemUpdate(url) {
            this.$set(this.newItem, 'url', url.url);
        },
        tryDelete(index) {
            this.$swal({
                    title: "Are you sure?",
                    text: "Are you sure that you want to DELETE this item?",
                    icon: "warning",
                    dangerMode: true,
                    buttons: [true, 'DELETE'],
                })
                .then(willDelete => {
                    if (willDelete) {
                        this.deleteItem(index)
                    }
                });
        },
        deleteItem(index) {
            this.site_data.post.settings.gallery.splice(index, 1);
            this.$forceUpdate();
        },

        newItemSave() {
            // if (this.newItem.url !== undefined && this.newItem.url !== '') {
            if (this.site_data.post.settings.gallery == undefined) {
                this.site_data.post.settings.gallery = [];
            }
            this.site_data.post.settings.gallery.unshift(this.newItem);
            this.$refs.newItemImage.myImage = '';
            this.newItem = {};
            this.currentItem = null;
            //} else {
            //warn something
            //}
        },
        tinyInsert(content) {
            tinymce.activeEditor.insertContent(content);
            //tinymce.activeEditor.execCommand('mceInsertContent', false, content);
        },
        create_category() {
            this.category = !this.category;
        },
        standalone(url) {
            this.site_data.post.image = url.url;
            this.showFile = false;
        },
        removeImage() {
          this.site_data.post.image = null;
          this.showFile = false;
        },
        includePosts: function () {

        },
        switch_tab(tab) {
            switch (tab) {
                case "simple":
                    this.currentTab = 1;
                    this.site_data.advanced = false;
                    break;
                case "advanced":
                    this.currentTab = 2;
                    this.site_data.advanced = true;
                    break;
                case "preview":
                    this.render_preview();
                    this.currentTab = 3;
                    this.site_data.advanced = false;
                    break;
            }
        },
        preview_size(size) {
            if (size == 'mobile') {
                this.preview_type = 'mobile';
                this.preview_style = {
                    width: "375px"
                };
            } else {
                this.preview_type = 'desktop';
                this.preview_style = {
                    width: "100%"
                };
            }
        },

        submitData(e) {
          if (this.submit_disabled == true) {
            return false;
          }
          this.submit_disabled = true;
          if (this.formData.title == '' || this.title_error != '') {
              this.submit_disabled = false;
              alert('Title is required and must be unique.');
              return false;
          }
            var self = this
            this.shouldPrevent = false;
            if (crud_type == 'edit') {
                axios.put(page_url, this.formData).then(function (res) {
                    self.shouldPrevent = false;
                    // window.location = page_url2;
                    self.updateMsg = true;
                    setTimeout(() => {
                        self.updateMsg = false;
                    }, 2000);
                });
            } else {
                axios.post(page_url, this.formData).then(function (res) {
                    self.shouldPrevent = false;
                    window.location = page_url2 + '/' + res.data.page.id + '/edit';
                });
            }
            this.submit_disabled = false;
            this.shouldPrevent = false;
        },

        isEmpty(obj) {
            for (var prop in obj) {
                if (obj.hasOwnProperty(prop))
                    return false;
            }
            return true;
        },

        render_preview() {
            var self = this;
            axios.post(preview_url, {
                data: JSON.stringify(this.site_data),
                type: 'page'
            }).then(function (res) {
                self.preview_html = "data:text/html;charset=utf-8," + encodeURIComponent(res.data.html);
                console.log(self.preview_html);
            });
        }

    },
    mounted: function () {
        var self = this;
        axios.get(WebsiteDataUrl).then((response) => {
            self.site_data = response.data;
            if (this.menu_id != 0) {
                self.site_data.menus = [menu_id];
            }
        }).then(function () {
            self.shouldPrevent = false;
            if (self.site_data.advanced == true) {
                self.currentTab = 2;
            }
        });
    }
});
