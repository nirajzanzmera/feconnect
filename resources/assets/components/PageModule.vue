<template>
  <div class="section">

        <a href="" class="btn btn-default" v-if="module_type != ''">
          <i class="fa fa-times"></i>
          Remove Section
        </a>
    <div class="dropdown">
    <button
        class="btn btn-default dropdown-toggle"
        type="button"
        id="dropdownMenuButton"
        data-toggle="dropdown"
        aria-haspopup="true"
        aria-expanded="false"
    >
        <i class="fa fa-plus"></i>
        Insert Section
    </button>
      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <a
          class="dropdown-item"
          href="#"
          v-on:click.prevent="module_type = 'posts'"
          >Posts</a
        >
        <a
          class="dropdown-item"
          href="#"
          v-on:click.prevent="module_type = 'simple'"
          >Simple Content</a
        >
        <a
          class="dropdown-item"
          href="#"
          v-on:click.prevent="module_type = 'gallery'"
          >Gallery</a
        >
      </div>
    </div>

    <div v-if="module_type == 'posts'">
      <fieldset class="form-group">
        <div class="form-check">
          <input
            v-model="site_data.post.include_posts"
            @change="includePosts($event)"
            type="checkbox"
            class="form-check-input"
            name="include_posts"
            value="1"
          />
          <label class="form-check-label" for="include_posts"
            >Include Posts</label
          >
        </div>
        <div v-if="site_data.post.include_posts">
          <em>Filter Posts by Category</em>
          <select  
            name="post_category"
            id="category"
            class="form-control"
            v-model="categories"
          >
            <option value="">All Posts</option>

            <option v-for="cat in categories" :key="cat.index">
              {{ cat.name }}
            </option>
          </select>
        </div>
      </fieldset>
     
    </div>
  </div>
</template>
<script>
import axios from "axios";
export default {
  props: ["type", "site_data",'categories'],
  data: function () {
    return {
      module_type: this.type,
    };
  },
  methods: {},
  mounted: function () {},
};
</script>
