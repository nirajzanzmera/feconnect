import Vue from 'vue';
import axios from "axios";
import VueSwal from 'vue-swal'

Vue.use(VueSwal);
var vue_app = new Vue({
    el: '#lock',
    components: {
        'vueswal': VueSwal,
    },
    data: {
      'data': {
        'auth_code': ''
      },
      'new_account': 0,
      'delete': false,
    },
    methods: {
        toggle_advanced() {
            var self = this;
            return axios.put(this.data.advanced_url, {
                'advanced_lock_status': !this.data.advanced_lock_status
            }).then(function (res) {
                self.data.advanced_lock_status = res.data.advanced_lock_status;
                if (res.data.advanced_lock_status == true) {
                  self.domain_lock();
                }
            });
        },
        toggle_domain_lock() {
          var self = this;
           return axios.put(this.data.advanced_url, {
               'transfer_locked': !this.data.transfer_locked
           }).then(function (res) {
               self.data.transfer_locked = res.data.transfer_locked;
           });
        },
        domain_lock() {
            var self = this;
            return axios.put(this.data.advanced_url, {
                'transfer_locked': true
            }).then(function (res) {
                self.data.transfer_locked = res.data.transfer_locked;
            });
        },

        switchAccounts() {
          window.location = this.data.move_url + '?new_account=' + this.new_account;
        },

        request_auth_code() {
            var self = this;
            return axios.put(this.data.advanced_url, {
                'request_auth_code': true,
            }).then(function (res) {
              self.$set(self.data, 'auth_code', res.data.auth_code);
            });
        },
        tryDelete(index) {
            this.$swal({
                    title: "Are you sure? You can never get it back.",
                    text: "Are you sure you want to delete your domain " + this.data.domain + " Deleting your domain is irreversible and will prevent you from using your website and any emails that use your domain. It also will allow someone else to register your domain and use it for their website. You will not be able to get it back.",
                    icon: "warning",
                    dangerMode: true,
                    buttons: ['Keep My Domain', 'DELETE'],
                })
                .then(willDelete => {
                    this.delete = true;
                    if (willDelete) {
                        document.getElementById("delete_form").submit();
                    }
                });
        },
        getInfo() {
          return axios.get(info_url).then((response) => {
            this.data = response.data.data
          });
        },

    },
    mounted() {
      this.getInfo();
    }

});
