<template>
  <div>
    <li class="nav-item dropdown">
      <a
        class="btn btn-default dropdown-toggle btn-circle btn-notification "
        data-caret="false"
        data-toggle="dropdown"
        role="button"
        aria-haspopup="false"
      >
        <i class="material-icons" v-cloak>notifications</i>
        <span class="badge" v-if="unread_count > 0" v-cloak>{{ unread_count }}</span>
      </a>


<!--     <a v-bind:href="nots_index" class="btn btn-default btn-circle btn-notification hidden-xl-up">
        <i class="material-icons" v-cloak>notifications</i>
        <span class="badge" v-if="unread_count > 0" v-cloak>{{ unread_count }}</span>
    </a> -->


    <ul class="shadow dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
        <li class="dropdown-item" v-if="nots_count == 0">No New Notifications</li>
        <div class="space-width" style="overflow-y: scroll; max-height: 400px; ">
            <li
            class="dropdown-item"
            v-for="not in nots"
            v-bind:key="not.id"
            style="white-space: normal;"
          >
            <div class="row">
              <div class="col-lg">
                <a
                  href
                  v-on:click.stop.prevent="mark_archived(not.id)"
                  class="pull-right"
                  title="Mark Read"
                >
                  <i class="fa fa-times"></i>
                </a>

                <a v-bind:href="not.data.route" class="nav-link" v-if="not.data.route != ''">
                  <strong>{{ not.data.title}}</strong>
                  <br />
                  <span v-html="$options.filters.nl2br(not.data.msg)"></span>
                </a>
                <div class v-if="not.data.route == ''">
                  <strong><a v-bind:href="base_url + '/notification/'+not.id">{{ not.data.title}}</a></strong>
                  <br />
                   <div v-if="not.data.msg.length<100">
                       <span v-html="$options.filters.nl2br(not.data.msg)"></span>
                   </div>
                   <div v-if="not.data.msg.length>=100">
                       <span v-html="$options.filters.nl2br(not.data.msg.substring(0,100))+'...'"></span>
                   </div>
                <br />
                <small>{{ not.human }}</small>
              </div>
            </div>

            <hr />
          </li>
        </div>
        <!-- scroll -->
        <li class="dropdown-itemZ">
          <div class="btn-group pull-right" style="padding:10px;">
            <a v-bind:href="nots_index" class="btn btn-sm btn-primary">See All</a>
            <a href v-if="unread_count > 0"
              v-on:click.stop.prevent="mark_all_read()" class="btn btn-sm btn-default">Mark All Read</a>
          </div>
        </li>
      </ul>
    </li>
  </div>
</template>

<script>
import axios from "axios";
export default {
  props: ["nots_url", "nots_index", "base_url", "mark_all"],
  data: function () {
    return {
      nots: [],
      nots_count: 0,
      unread_count: 0,
    };
  },
  methods: {
    mark_all_read() {
      axios.get(this.mark_all).then((response) => {
        this.get_nots();
      });
    },
    mark_read(id) {
      axios.get("/notification/" + id).then((response) => {
        this.get_nots();
        if (response.data.status == true) {
          this.unread_count--;
        }
      });
    },
    mark_archived(id) {
      axios.get("/notification/archive/" + id).then((response) => {
        this.get_nots();
        if (response.data.status == true) {
          this.nots_count--;
        }
      });
    },
    get_nots() {
      //this.nots = [];
      axios.get(this.nots_url).then((response) => {
        this.unread_count = response.data.data.unread_count;
        this.nots_count = response.data.data.count;
        this.nots = response.data.data.nots;
      });
    },
  },
  filters: {
    nl2br: function (value) {
      if (!value) return "";
      return value.replace(/(?:\r\n|\r|\n)/g, "<br>");
    },
  },
  mounted: function () {
    this.get_nots();
  },
};
</script>
