import Vue from 'vue';
import axios from "axios";

var vue_app = new Vue({
    el: '#hosting',
    data: {
        get_url: get_url,
        subdomain_add_url: '',
        subdomain_update_url: '',
        domain_update_url: '',
        rows: [],
        hosting: [],
        dropdown: [],
        edit: -1,
        destination: '',
        url: '',
        new_destination: '',
        new_url: '',
        new_domain: '',
        add: false,
    },
    computed: {
        
    },
    methods: {
        getRecords: function () {
            this.destination = '';
            this.url = '';
            this.edit = -1;
            this.new_destination = '';
            this.new_domain = '';
            this.new_url = '';
            return axios.get(this.get_url).then(response => {
                this.hosting = response.data.hosting;
                this.dropdown = response.data.dropdown;
                this.subdomain_add_url = response.data.urls.subdomain_add_url;
                this.subdomain_update_url = response.data.urls.subdomain_update_url;
                this.domain_update_url = response.data.urls.domain_update_url;
            });
        },

        editDomain: function (index) {
          this.edit = index;
          if (this.hosting[index].answer !== '' && this.hosting[index].answer !== undefined) {
            this.destination = 'new_url';
            this.url = this.hosting[index].answer;
          } else {
            this.destination = this.hosting[index].destination_id;
            this.url = null;
          }
        },

        add_subdomain: function () {
            axios.post(this.subdomain_add_url, {
              'new_destination': this.new_destination,
              'new_domain': this.new_domain,
              'new_url': this.new_url,
            }).then(function(res) {
               vue_app.getRecords();
            }).catch((error) => {
              var msg = this.build_error_message(error.response.data.errors)
              $('#js_warning').html(msg);
              $('#js_warning').show();
            });
        },

        update_domain: function (host) {
           axios.put(this.domain_update_url, {
               'id': host.domain_id,
               'destination': this.destination,
               'url': this.url
           }).then(function (res) {
               vue_app.getRecords();
           });
        },

        update_subdomain: function (host) {
            axios.put(this.subdomain_update_url, {
              'id': host.domain_id,
              'destination': this.destination,
              'url': this.url
            }).then(function (res) {
              vue_app.getRecords();
            }).catch((error) => {
              var msg = this.build_error_message(error.response.data.errors)
              $('#js_warning').html(msg);
              $('#js_warning').show();
            });
        },

        build_error_message: function (errors) {
          var msg = '';
          for (var error in errors) {
              errors[error].forEach(error_msg => {
                msg += error_msg + '<br/>';
              });
          }
          return msg;
        }

    },
    mounted() {
        this.getRecords();
    }

});
