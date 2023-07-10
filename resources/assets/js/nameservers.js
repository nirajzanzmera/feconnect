import Vue from 'vue';
import axios from "axios";

window.vue_app = new Vue({
    el: '#nameservers',
    data: {
        nameservers_url: nameservers_url,
        nameservers: [],
        edit: false,
        add_nameserver: '',
        custom: false,
        show_edit: false,
        dns_template: '', 
        working: false,
    },
    watch: {
        dns_template: function (val) {
            if (val == 'other') {
              this.show_edit = true;
              if (this.nameservers[0] == 'ns1.name.com') {
                this.nameservers = [];
              }
            } else {
              this.edit = false;
              this.show_edit = false;
            }
        }
    },
    methods: {
        UpdateDNS() {
            this.nameservers = ['ns1.name.com','ns2.name.com','ns3.name.com','ns4.name.com'];
            this.update();
        },

        getRecords: function (){
            return axios.get(this.nameservers_url).then(response => {
                this.nameservers = response.data.nameservers;
                this.custom = response.data.custom;
                this.init();
            });
        },
        deleteServer: function (index) {
            this.nameservers.splice(index, 1);
        },
        cancel: function() {
            this.edit = false;
            this.getRecords();
        },
        update: function() {
            this.working = true;
            this.addServer();
            axios.put(this.nameservers_url, {
              nameservers: this.nameservers
            }).then(response => {
              this.working = false;
              this.edit = false;
              this.getRecords();
            });

        },
        editServers: function () {
            this.edit = true;
            /* this.custom = true; */
        },
        addServer: function() {
            if (this.add_nameserver != '') {
                this.nameservers.push(this.add_nameserver);
            }
            this.add_nameserver = '';
        },

        init: function() {
          if(this.custom == true) {
            this.dns_template = 'other';
            this.show_edit = true;
          } else {
            this.dns_template = 'dataczar';
            this.show_edit = false;
          }
        }

    },
    mounted() {
        this.getRecords();
    }

});