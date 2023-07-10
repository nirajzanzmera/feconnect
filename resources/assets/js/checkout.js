import Vue from 'vue'
import axios from 'axios'

var app = new Vue({
    el: '#app',
    data: {
        email: emailVal,
        email_status: '',
        email_msg: ''
    },
    computed: {
        dirty: function () {
            if (this.email_status != 'success' && this.email_status != '') {
                return true;
            } else {
                return false;
            }
        },
        valid: function () {
            if (this.email_status == 'success') {
                return true;
            } else {
                return false;
            }
        },
    },
    methods: {
        user_check() {
            return axios.post(userCheckUrl, {
                    email: this.email
                }).then((response) => {
                this.email_status = response.data.status;
                this.email_msg = response.data.msg;
                //console.log(response);
            });
        },
        submitOrder() {
            
        }
    },
    mounted() {
        if (this.email != '') {
            this.user_check();
        }
    }
});
