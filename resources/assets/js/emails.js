import Vue from 'vue';
import axios from "axios";
import VueSwal from 'vue-swal'

import EmailsDrop from './components/EmailsDrop.vue'

Vue.use(VueSwal);
window.vue_app = new Vue({
    components: {
      'emails-drop': EmailsDrop,
       'vueswal': VueSwal
    },
    el: '#app',
    data () {
        return {
            message: '',
            forwards: [],
            emails: [],
            create_email: {},
            new_user: '',
            editing: {
                id: null, 
                form: {},
                errors: []
            },
            data_url: data_url,
            emailbox_url: '',
            forward_url: '',
        }
    },
    methods: {
        getRecords() {
          return axios.get(this.data_url).then((response) => {
              this.forwards = response.data.forwards;
              this.emails = response.data.emails;
              this.emailbox_url = response.data.emailbox_url;
              this.forward_url = response.data.forward_url;
          });
        },
        edit(email) {
            this.editing.errors = []
            this.editing.id = email.id
            this.editing.form = email
        },
        cancel() {
            this.editing.errors = []
            this.editing.id = null
            this.editing.form = {}
        },
        addEmail() {
          if(this.create_email.selected == 'new_email') {
            var data = this.create_email;
            axios.post(this.emailbox_url, {
                id: data.id,
                mailbox: this.new_user,
                password: data.password
            }).then(() => {
              window.location = this.emailbox_url;
            }).catch((error) => {
                if (error.response.status === 422) {
                    this.editing.errors = error.response.data.errors
                }
            }); 
          } else {
            var data = this.create_email;
            if (data.selected == 'other') {
                var email_to = data.other_email;
            } else {
                var email_to = data.selected;
            }
            axios.post(this.forward_url, {
              email_box: this.new_user,
              email_to: email_to
            }).then(() => {
              window.location = this.emailbox_url;
            }).catch((error) => {
                if (error.response.status === 422) {
                    this.editing.errors = error.response.data.errors
                }
            });
          }
        },
        update(email) {
          if(email.formData.selected == 'new_email') {
            var data = this.editing.form;
            axios.post(this.emailbox_url, {
                id: data.id,
                mailbox: data.email_box,
                password: data.formData.password
            }).then(() => {
              window.location = this.emailbox_url;
            }).catch((error) => {
                if (error.response.status === 422) {
                    this.editing.errors = error.response.data.errors
                }
            });
          } else {
            var data = this.editing.form;
            if (data.formData.selected == 'other') {
              var email_to = data.formData.other_email;
            } else {
              var email_to = data.formData.selected;
            }
            axios.patch(this.forward_url, {
              id: data.id,
              email_box: data.email_box,
              email_to: email_to
            }).then(() => {
              window.location = this.emailbox_url;

            }).catch((error) => {
                if (error.response.status === 422) {
                    this.editing.errors = error.response.data.errors
                }
            });
          }
        },
        deleteModal(email) {
            console.log(email);
            this.$swal({
                title: "Are you sure?",
                text: "Are you sure that you want to DELETE: \n" + email.email + ' > ' +  email.email_to ,
                icon: "warning",
                dangerMode: true,
                buttons: [true, 'DELETE'],
            })
            .then(willDelete => {
                if (willDelete) {
                    axios.delete(this.forward_url + '/' + email.id, this.editing.form).then(() => {
                        this.getRecords().then(() => {
                            this.editing.id = null
                            this.editing.form = {}                    
                        });
                    }).catch((error) => {
                        if(error.response.status === 422) {
                            this.editing.errors = error.response.data.errors
                        }
                    });
                }
            }); 
        },
    }, /* end methods */
    mounted() {
      this.getRecords();
    },
});
