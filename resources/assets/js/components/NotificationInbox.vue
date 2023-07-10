<template>
<div class="card">
        <div class="card-header">
            <div class="card-title">
                Notifications
                <div class="pull-right">
                    <a href="" class="btn btn-sm btn-primary" v-on:click.stop.prevent="mark_all_read()">Mark All Read</a>
                </div>
            </div>
        </div>
        <ul class="list-group" v-cloak>
            <div v-for="record in records" v-bind:key="record.index">
                <template v-if="record.archived_at == undefined">
                <li class="list-group-item unread"
                    v-on:click.stop.prevent="mark_archived(record.id)"
                >
                    <div class="row">
                        <div class="col-xl-1 col-lg-2">
                            {{ record.date }}
                        </div>
                        <div class="col-xl-11 col-lg-10">
                            <strong>{{ record.data.title }}</strong>
                            <br />
                            <small>{{ record.data.msg }}</small>
                            <br/>
                            <a v-bind:href="record.data.route" v-if="record.data.route != ''" target="_blank">
                                View 
                            </a>
                        </div>
                    </div>
                </li>
                </template>
                <template v-else>
                    <li class="list-group-item">
                        <div class="row">
                        <div class="col-xl-1 col-lg-2">
                            {{ record.date }}
                        </div>
                        <div class="col-xl-11 col-lg-10">
                            <strong>{{ record.data.title }}</strong>
                            <br />
                            <small>{{ record.data.msg }}</small>
                            <br/>
                              <a v-bind:href="record.data.route" v-if="record.data.route != ''" target="_blank">
                                View 
                            </a>
                        </div>
                    </div>
                    </li>
                </template>
            
            </div>
        </ul>
    </div>
</div>
</template>

<script>
import Vue from "vue";
import axios from "axios";

export default {
  props: ["nots_url","mark_all"],
  data() {
    return {
      records: [],
    };
  },
  methods: {
    mark_all_read() {
      axios.get(this.mark_all).then((response) => {
        this.getRecords();
        window.not_app.$refs.nots.get_nots();
      });
    },
    getRecords: function () {
      return axios.get(this.nots_url).then((response) => {
        this.records = response.data.nots;
      });
    },
    mark_archived(id) {
      axios.get("/notification/archive/" + id).then((response) => {
        this.getRecords();
        window.not_app.$refs.nots.get_nots();
      });
    },
  },
  mounted() {
    this.getRecords();
  },
};
</script>

<style lang="scss">
li.list-group-item.unread {
  border: lightslategray dashed 1px;
  background: lightgray;
  font-weight: bold;
  cursor: pointer;
}
.unread small {
  font-weight: bold;
}
</style>