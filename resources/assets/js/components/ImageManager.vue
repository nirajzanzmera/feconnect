<template>
  <div id="image_manager">
    <div v-if="!menu_off">
    <a
      href
      v-if="type == 'standalone'"
      v-on:click.prevent="$emit('close')"
      title="Close Filemanager"
      class="btn btn-danger btn-sm"
      style="position: absolute; right: 5px; top: 5px"
    >
      <i class="fa fa-times"></i>
    </a>
    <ul
      class="nav nav-pills flex-column flex-sm-row"
      style="padding-bottom: 15px"
      v-bind:class="[type == 'iframe' ? 'windowed' : '']"
    >
      <li class="nav-item">
        <a
          class="nav-link"
          href
          v-bind:class="{ active: tab == 'upload' }"
          v-on:click.prevent="tab = 'upload'"
        >
          <i class="fa fa-upload"></i>
          Upload
        </a>
      </li>
      <li class="nav-item">
        <a
          class="nav-link"
          href
          v-bind:class="{ active: tab == 'images' }"
          v-on:click.prevent="switchTab('images')"
        >
          <i class="fa fa-image"></i>
          My Images
        </a>
      </li>

      <li class="nav-item" v-if="!imageOnly">
        <a
          class="nav-link"
          href
          v-bind:class="{ active: tab == 'files' }"
          v-on:click.prevent="
            tab = 'files';
            getFiles();
          "
        >
          <i class="fa fa-file"></i>
          My Files
        </a>
      </li>

      <li class="nav-item">
        <a
          class="nav-link"
          href
          v-bind:class="{ active: tab == 'search' }"
          v-on:click.prevent="tab = 'search'"
        >
          <i class="fa fa-search"></i>
          Free Images
        </a>
      </li>
      <li class="nav-item">
        <a
          class="nav-link"
          href
          v-bind:class="{ active: tab == 'icon' }"
          v-on:click.prevent="tab = 'icon'"
        >
          <i class="fa fa-search-plus"></i>
          Icon
        </a>
      </li>
      <li class="nav-item" v-if="context=='content'">
        <a
          class="nav-link"
          v-bind:href="tools_link"
        >
            <i class="fa fa-briefcase"></i>
            Content Tools
        </a>
      </li>
    </ul>
    </div>

    <div
      class="alert alert-success"
      v-if="message != '' && tab == 'upload'"
      v-cloak
    >
      {{ message }}
    </div>

    <div
      class="alert alert-danger"
      v-if="upload_error != '' && tab == 'upload'"
      v-cloak
    >
      {{ upload_error }}
    </div>

    <div class="card" v-if="tab == 'upload'">
      <div class="card-header">
        <div class="media">
          <div class="media-body">
            <div class="card-title">Upload Images<span v-if="!imageOnly"> / Files</span></div>
          </div>
        </div>
      </div>
      <div class="card-block card-block-light">
        <fieldset class="form-group">
          <a href v-on:click.prevent="selectImages()" class="btn btn-primary">
            <i class="fa fa-file"></i>
            Choose Files
          </a>
          <input
            type="file"
            v-on:change="fileChange()"
            ref="myImages"
            accept="image/*, application/pdf, audio/mp3, .xls, .xlsx, .doc, .docx, .ppt, .pptx"
            multiple="multiple"
            class="inputFile"
            placeholder
          />
        </fieldset>

        <h4 v-if="uploads.length > 0" v-cloak>
          <hr />
          Upload Previews
        </h4>
        <div class="card-columns photos" v-cloak>
          <div v-for="(upload, index) in uploads" v-bind:key="index">
            <upload
              :myUpload="upload"
              :sig="sig"
              :folder="folder"
              :file_sig="file_sig"
              :file_folder="file_folder"
              :event_url="event_url"
              :context="context"
              v-on:url="imageUse"
              v-on:uploadComplete="uploadComplete"
            ></upload>
          </div>
        </div>
      </div>
    </div>

    <div class="card" v-if="tab == 'images'" v-cloak>
      <div class="card-header">
        <div class="media">
          <div class="media-body">
            <div class="card-title">My Images</div>
          </div>
        </div>
      </div>
      <div class="card-block card-block-light">
        <div class="div" v-if="image_status == 'loading'" v-cloak>
          Loading ...
          <i class="fa fa-spinner fa-pulse"></i>
        </div>
        <div class="photos" style="overflow: auto">
          <div
            class="image-result"
            style="float: left"
            v-for="(image, index) in sortedImages"
            v-bind:key="index"
          >
            <ImageContainer
              :myImage="image"
              :delete_url="delete_url"
              :context="context"
              :view_url="view_url"
              v-on:reloadImages="getImages()"
              v-on:url="imageUse"
            ></ImageContainer>
          </div>
        </div>
      </div>
    </div>

    <div class="card" v-if="tab == 'files'" v-cloak>
      <div class="card-header">
        <div class="media">
          <div class="media-body">
            <div class="card-title">My Files</div>
          </div>
        </div>
      </div>

      <div class="div" v-if="file_status == 'loading'" v-cloak>
        Loading ...
        <i class="fa fa-spinner fa-pulse"></i>
      </div>
      <ul class="list-group">
        <li
          class="list-group-item"
          v-for="(file, index) in sortedFiles"
          v-bind:key="index"
        >
          <ImageContainer
            :myImage="file"
            :delete_url="delete_url"
            :display_type="'file_view'"
            :context="context"
            :file_view_url="file_view_url"
            v-on:reloadImages="getFiles()"
            v-on:url="imageUse"
          ></ImageContainer>
        </li>
      </ul>
    </div>

    <div class="card" v-if="tab == 'search'" v-cloak>
      <div class="card-header">
        <div class="media">
          <div class="media-body">
            <div class="card-title">Search for Free Images</div>
          </div>
          <div class="media-right">
            <a
              href="https://pixabay.com/"
              target="_blank"
              title="Images provided by Pixabay.com"
            >
              <img
                src="https://dataczar-public.s3.us-west-2.amazonaws.com/photos/54/pixabay_logo_DKrud.png"
                style="max-width: 100px"
                alt="Images provided by Pixabay.com"
              />
            </a>
          </div>
        </div>
      </div>
      <div class="card-block card-block-light">
        <div class="input-group">
          <input
            type="text"
            class="form-control"
            v-model="search_term"
            v-on:keydown.enter.prevent="findImages()"
          />
          <a
            href
            class="btn btn-success input-group-addon"
            v-on:click.prevent="findImages()"
          >
            <i class="fa fa-search"></i>
          </a>
        </div>

        <nav
          class="center"
          v-if="(photos.length > 0 || page > 1) && selected == ''"
          v-cloak
        >
          <ul class="pagination">
            <li class="page-item" v-bind:class="{ disabled: page == 1 }">
              <a v-on:click.prevent="prevPage()" class="page-link" href="#"
                >Previous</a
              >
            </li>
            <li class="page-item disabled">
              <a class="page-link">{{ page * 20 }} / {{ photo_count }}</a>
            </li>
            <li class="page-item" v-bind:class="{ disabled: lastPage }">
              <a v-on:click.prevent="nextPage()" class="page-link" href="#"
                >Next</a
              >
            </li>
          </ul>
        </nav>

        <div class="card-columns photos" v-if="selected == ''" v-cloak>
          <div class="card" v-for="(photo, index) in photos" v-bind:key="index">
            <a v-on:click.prevent="select(photo.image)" class>
              <img
                v-bind:src="photo.large_preview"
                alt
                class="card-img-top img-fluid img-result"
              />
            </a>
          </div>
        </div>

        <div class="text-center" v-if="selected != ''" v-cloak>
          <div class="btn-group" style="padding: 15px">
            <a
              v-on:click.prevent="download(selected)"
              href
              class="btn btn-large btn-success"
            >
              <i class="fa fa-check"></i>
              Use this Image
            </a>
            <a v-on:click.prevent="cancel()" class="btn btn-large btn-default">
              <i class="fa fa-times"></i>
              Cancel
            </a>
          </div>
          <br />

          <div class="big-img">
            <img
              v-bind:src="selected"
              alt
              class="card-img-top img-fluid"
              style="margin: auto; width: auto; max-height: 650px"
            />
          </div>

          <br />
          <div class="btn-group" style="padding: 15px">
            <a
              v-on:click.prevent="download(selected)"
              href
              class="btn btn-large btn-success"
            >
              <i class="fa fa-check"></i>
              Use this Image
            </a>
            <a v-on:click.prevent="cancel()" class="btn btn-large btn-default">
              <i class="fa fa-times"></i>
              Cancel
            </a>
          </div>
        </div>

        <nav
          class="center"
          v-if="(photos.length > 0 || page > 1) && selected == ''"
          v-cloak
        >
          <ul class="pagination">
            <li class="page-item" v-bind:class="{ disabled: page == 1 }">
              <a v-on:click.prevent="prevPage()" class="page-link" href="#"
                >Previous</a
              >
            </li>
            <li class="page-item disabled">
              <a class="page-link">{{ page * 20 }} / {{ photo_count }}</a>
            </li>
            <li class="page-item" v-bind:class="{ disabled: lastPage }">
              <a v-on:click.prevent="nextPage()" class="page-link" href="#"
                >Next</a
              >
            </li>
          </ul>
        </nav>
      </div>
    </div>
    <div class="card" v-if="tab == 'icon'" v-cloak>
      <div class="card-header">
        <div class="media">
          <div class="media-body">
            <div class="card-title">Search for Icons</div>
          </div>
          <div class="media-right">
            <a
              href="https://flaticon.com/"
              target="_blank"
              title="Images provided by Flaticon.com"
            >
              <img
                src="https://dataczar-public.s3.us-west-2.amazonaws.com/photos/675/flaticon_wkALv.png"
                style="max-width: 100px"
                alt="Images provided by Flaticon.com"
              />
            </a>
          </div>
        </div>
      </div>
      <div class="card-block card-block-light">
        <div class="input-group">
          <input
            type="text"
            class="form-control"
            v-model="search_term"
            v-on:keydown.enter.prevent="findImages()"
          />
          <a
            href
            class="btn btn-success input-group-addon"
            v-on:click.prevent="findImages()"
          >
            <i class="fa fa-search"></i>
          </a>
        </div>

        <nav
          class="center"
          v-if="(photos.length > 0 || page > 1) && selected == ''"
          v-cloak
        >
          <ul class="pagination">
            <li class="page-item" v-bind:class="{ disabled: page == 1 }">
              <a v-on:click.prevent="prevPage()" class="page-link" href="#"
                >Previous</a
              >
            </li>
            <li class="page-item disabled">
              <a class="page-link">{{ page * 20 }} / {{ photo_count }}</a>
            </li>
            <li class="page-item" v-bind:class="{ disabled: lastPage }">
              <a v-on:click.prevent="nextPage()" class="page-link" href="#"
                >Next</a
              >
            </li>
          </ul>
        </nav>

        <div class="card-columns photos" v-if="selected == ''" v-cloak>
          <div class="card" v-for="(photo, index) in photos" v-bind:key="index">
            <a v-on:click.prevent="select(photo.image)" class>
              <img
                v-bind:src="photo.large_preview"
                alt
                class="card-img-top img-fluid img-result"
              />
            </a>
          </div>
        </div>

        <div class="text-center" v-if="selected != ''" v-cloak>
          <div class="btn-group" style="padding: 15px">
            <a
              v-on:click.prevent="download(selected)"
              href
              class="btn btn-large btn-success"
            >
              <i class="fa fa-check"></i>
              Use this Image
            </a>
            <a v-on:click.prevent="cancel()" class="btn btn-large btn-default">
              <i class="fa fa-times"></i>
              Cancel
            </a>
          </div>
          <br />

          <div class="big-img">
            <img
              v-bind:src="selected"
              alt
              class="card-img-top img-fluid"
              style="margin: auto; width: auto; max-height: 650px"
            />
          </div>

          <br />
          <div class="btn-group" style="padding: 15px">
            <a
              v-on:click.prevent="download(selected)"
              href
              class="btn btn-large btn-success"
            >
              <i class="fa fa-check"></i>
              Use this Image
            </a>
            <a v-on:click.prevent="cancel()" class="btn btn-large btn-default">
              <i class="fa fa-times"></i>
              Cancel
            </a>
          </div>
        </div>

        <nav
          class="center"
          v-if="(photos.length > 0 || page > 1) && selected == ''"
          v-cloak
        >
          <ul class="pagination">
            <li class="page-item" v-bind:class="{ disabled: page == 1 }">
              <a v-on:click.prevent="prevPage()" class="page-link" href="#"
                >Previous</a
              >
            </li>
            <li class="page-item disabled">
              <a class="page-link">{{ page * 20 }} / {{ photo_count }}</a>
            </li>
            <li class="page-item" v-bind:class="{ disabled: lastPage }">
              <a v-on:click.prevent="nextPage()" class="page-link" href="#"
                >Next</a
              >
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </div>
</template>

<script>
import ImageContainer from "./Image.vue";
import Upload from "./Upload.vue";
import axios from "axios";
import "promise-polyfill/src/polyfill";

if (!String.prototype.startsWith) {
  String.prototype.startsWith = function (searchString, position) {
    position = position || 0;
    return this.substr(position, searchString.length) === searchString;
  };
}
import _ from "lodash";
export default {
  props: [
    "search_url",
    "downup_url",
    "imagelist_url",
    "filelist_url",
    "event_url",
    "delete_url",
    "view_url",
    "file_view_url",
    "file_folder",
    "folder",
    "sig",
    "file_sig",
    "type",
    "context",
    "field_name",
    "menu_off",
    "default_tab",
    "tools_link",
    "icon_url",
    'default_search'
  ],
  data() {
    return {
      tab: (this.default_tab !== undefined && this.default_tab !== "") ? this.default_tab :"upload",
      showModal: false,
      search_term: "",
      page: 1,
      photos: [],
      photo_count: 0,
      selected: "",
      images: [],
      image_status: "done",
      files: [],
      file_status: "done",
      uploads: [],
      uploads_completed: 0,
      image_preview: "",
      message: "",
      upload_error: "",
      iconUrl: "",
    };
  },
  components: {
    ImageContainer: ImageContainer,
    Upload: Upload,
  },
  watch: {
    tab: function(val) {
      if (val == "icon" && this.default_search) {
        this.search_term = this.default_search;
        this.findImages();
      }
    }
  },
  computed: {
    imageOnly() {
        return this.context == 'selector' ? true : false;
    },
    lastPage() {
      return this.page * 20 > this.photo_count ? true : false;
    },
    sortedImages() {
      var images = this.images;
      images = _.orderBy(images, ["modified"], ["desc"]);
      return images;
    },
    sortedFiles() {
      var files = this.files;
      files = _.orderBy(files, ["modified"], ["desc"]);
      return files;
    },
  },
  mounted() {
       if (this.default_tab == "images") {
        this.getImages();
      }
      if (this.default_tab == "files") {
        this.getFiles();
      }
      if (this.tab =="icon" && this.default_tab == "search") {
        this.iconUrl = this.default_search;
        this.findImages();
      }
      if (this.icon_url == undefined) {
        this.iconUrl = localStorage.getItem('icon_url');
      } else {
        this.iconUrl = this.icon_url;
      }
  },
  methods: {
    uploadComplete(url) {
      if(this.uploads.length == 1 && this.context == 'selector') {
        this.imageUse(url);
      }
    },
    switchTab(tab_name) {
      this.tab = tab_name;
      if (tab_name == "images") {
        this.getImages();
      }
      if (tab_name == "files") {
        this.getFiles();
      }
    },
    findImages() {
      this.page = 1;
      this.search();
    },
    search() {
      if (this.search_term !== "") {
        this.photos = [];
        let search_url = this.search_url;
        if (this.tab=="icon") search_url = this.iconUrl;
        return axios
          .post(search_url, { search: this.search_term, page: this.page })
          .then((response) => {
            this.photos = response.data.images;
            this.photo_count = response.data.image_count;
          });
      }
    },
    nextPage() {
      this.page++;
      this.search();
    },
    prevPage() {
      if (this.page > 1) {
        this.page--;
        this.search();
      }
    },
    select(photo) {
      this.selected = photo;
    },
    cancel() {
      this.selected = "";
    },
    download(photo) {
      if (photo != undefined) {
        axios.post(this.downup_url, { image: photo }).then((response) => {
          if (this.context == "content") {
            this.tab = "images";
            this.getImages();
          } else {
            this.imageUse(response.data.image);
          }
        });
      }
    },
    getImages() {
      this.image_status = "loading";
      this.images = [];
      return axios.get(this.imagelist_url).then((response) => {
        this.images = response.data;
        this.image_status = "done";
      });
    },
    getFiles() {
      this.file_status = "loading";
      return axios.get(this.filelist_url).then((response) => {
        this.files = response.data;
        this.file_status = "done";
      });
    },
    imageUse(url) {
      this.$emit("url", { url: url, field_name: this.field_name });
    },
    imageDelete(image) {
      console.log(image);
    },
    fileChange() {
      //this.uploads = [];
      for (var i = 0; i < this.$refs.myImages.files.length; i++) {
        this.uploads.push({
          file: this.$refs.myImages.files[i],
          preview: false,
          status: "pending",
        });
      }
    },
    copyLink(link) {
      clipboard.writeText(link);
      alert("Copied to Clipboard");
    },
    selectImages() {
      this.$refs.myImages.value = "";
      this.$refs.myImages.click();
    },
    createImage(file) {
      var image = new Image();
      var reader = new FileReader();
      var vm = this;
      reader.onload = (e) => {
        vm.uploads.push({
          file: file,
          preview: e.target.result,
          status: "pending",
        });
      };
      reader.readAsDataURL(file);
    },
    cancel_upload(index) {
      this.uploads.splice(index, 1);
    },
    getSigData(file) {
      if (file.type.startsWith("image/")) {
        var folder = this.folder;
        var sig = this.sig;
      } else {
        var folder = this.file_folder;
        var sig = this.file_sig;
      }
      return axios
        .get(
          "/upload/signed?type=" +
            file.type +
            "&folder=" +
            folder +
            "&sig=" +
            sig +
            "&pub=true&content_type=" +
            file.type +
            "&name=" +
            file.name
        )
        .then((response) => {
          var data = new FormData();
          var json = response.data;
          var arr = Object.keys(json.additionalData);
          arr.forEach(function (value, index) {
            data.append(value, json.additionalData[value]);
          });
          data.append("file", file);
          return {
            data: data,
            json: json,
          };
        });
    },
  },
};
</script>

<style lang="scss">
label {
  font-weight: bold;
}

.has-error input {
  border-color: red;
}

@media (min-width: 576px) {
  .card-columns.photos {
    column-count: 3;
  }
}

@media (min-width: 992px) {
  .card-columns.photos {
    column-count: 3;
  }
}

.photos {
  padding-top: 15px;
}

.big-img {
  text-align: center;
  /* background: url('{{ url("img/loader.svg") }}'); the laravel url method could be passed through props*/
  background-repeat: no-repeat;
  background-position: top;
  min-height: 100px;
}

.inputFile {
  width: 0.1px;
  height: 0.1px;
  opacity: 0;
  overflow: hidden;
  position: absolute;
  top: -50px;
}

.windowed {
  padding-top: 15px;
}

.image-result {
  background-color: #eee;
  overflow: hidden;
  position: relative;
  margin: 15px;
  border: 1px solid #ccc;
}

.image-display {
  opacity: 1;
  display: block;
  max-height: 200px;
  max-width: 100%;
  width: auto;
  transition: 0.5s ease;
  backface-visibility: hidden;
}

.middle {
  width:100%;
  transition: 0.5s ease;
  opacity: 1;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  text-align: center;
}

.image-display-hover {
  opacity: 0.3;
}

.image-display-delete {
  min-height: 400px;
  max-width: 100%;
}

.middle-hover {
  opacity: 1;
}
</style>
