import Vue from 'vue/dist/vue.js';
import axios from 'axios';

var vue_app = new Vue({
    el: '#recent_post',
    components: {
    },
    data() {
        return {
            posts: [],
            loading: false,
        }
    },
    methods: {
        getPosts(website=null) {
            this.loading = true;
            this.posts = [];

            let wID;
            if (website==null) wID = this.$refs.recent_post.getAttribute('website-id');
            else wID = website;

            let recent_post_url = this.$refs.recent_post.getAttribute('data-url');
            axios.get(`${recent_post_url}/${wID}`).then((response) => {
                this.loading = false;
                this.posts = response.data;
            }).catch((e) => {
                this.loading = false;
                this.posts = [];
            });
        },
        getPostUrl(id, website_id) {
            let post_url = this.$refs.recent_post.getAttribute('post-url')
            post_url = post_url.replace(':website_id', website_id)
            post_url = post_url.replace(':id', id)
            
            return post_url;
        },
        strip_tags(str) {
            str = str.toString();
            return str.replace(/<\/?[^>]+>/gi, '');
        },
        switchWebsitePosts(event) {
            this.getPosts(event.target.value);
        }
    },
    computed: {
        recent_posts() {
            const showPosts = [];
            let index = 1;
            for( const element of Object.entries(this.posts)) {
                if (index > 3) break;
                else showPosts.push(element[1]);
                index++;
            };
            return showPosts;
        }
    },
    mounted() {
        this.getPosts();
    },
})
