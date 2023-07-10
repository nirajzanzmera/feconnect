<template>
  <div class="card text-center">
    <div v-if="myUpload.status == 'complete'">
      <div
        style="
          background: grey;
          height: 55px;
          width: 100%;
          padding: 15px;
          opacity: 0.8;
        "
        class="middle middle-hover"
      >
        &nbsp;
      </div>
      <button
        style="color: white; opacity: 1"
        class="middle btn btn-primary"
        v-on:click.prevent="imageUse(myUpload.url)"
      >
        {{ context != "selector" ? "Copy" : "Use" }}
      </button>
    </div>
    <a
      href
      v-if="myUpload.status == 'uploading'"
      v-on:click.prevent
      title="Uploading..."
      class="btn btn-default btn-sm"
      style="position: absolute; right: 5px; top: 5px"
    >
      <i class="fa fa-spinner fa-pulse"></i>
    </a>
    <div
      v-if="myUpload.status == 'complete'"
      title="Completed"
      class="btn btn-success btn-sm"
      style="position: absolute; right: 5px; top: 5px; cursor:unset;"
    >
      <i class="fa fa-check"></i>
    </div>
    <a
      href
      v-if="myUpload.status == 'pending'"
      v-on:click.prevent="cancel_upload(index)"
      title="Cancel Upload"
      class="btn btn-danger btn-sm"
      style="position: absolute; right: 5px; top: 5px"
    >
      <i class="fa fa-times"></i>
    </a>

    <div v-if="myUpload.preview == false">
      <i
        style="padding: 25px"
        class="fa fa-file-word-o fa-5x"
        v-if="myUpload.file.type == 'application/msword'"
      ></i>
      <i
        style="padding: 25px"
        class="fa fa-file-word-o fa-5x"
        v-if="
          myUpload.file.type ==
          'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
        "
      ></i>
      <i
        style="padding: 25px"
        class="fa fa-file-excel-o fa-5x"
        v-if="myUpload.file.type == 'application/vnd.ms-excel'"
      ></i>
      <i
        style="padding: 25px"
        class="fa fa-file-excel-o fa-5x"
        v-if="
          myUpload.file.type ==
          'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        "
      ></i>
      <i
        style="padding: 25px"
        class="fa fa-file-powerpoint-o fa-5x"
        v-if="myUpload.file.type == 'application/vnd.ms-powerpoint'"
      ></i>
      <i
        style="padding: 25px"
        class="fa fa-file-powerpoint-o fa-5x"
        v-if="
          myUpload.file.type ==
          'application/vnd.openxmlformats-officedocument.presentationml.presentation'
        "
      ></i>

      <i
        style="padding: 25px"
        class="fa fa-file-pdf-o fa-5x"
        v-if="myUpload.file.type == 'application/pdf'"
      ></i>
      <i
        style="padding: 25px"
        class="fa fa-file-audio-o fa-5x"
        v-if="
          myUpload.file.type == 'audio/mp3' ||
          myUpload.file.type == 'audio/mpeg'
        "
      ></i>
      <br />
      <br />
      {{ myUpload.file.name }}
    </div>

    <img
      v-if="myUpload.preview != false"
      v-bind:src="myUpload.preview"
      class="card-img-top img-fluid"
    />
  </div>
</template>

<script>
import axios from "axios";
export default {
  props: [
    "myUpload",
    "sig",
    "folder",
    "file_sig",
    "file_folder",
    "event_url",
    "context",
  ],
  data: function () {
    return {};
  },
  methods: {
    uploadComplete(url) {
      this.$emit('uploadComplete', url);
    },
    imageUse(url) {
      this.$emit("url", url);
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

    autoUpload() {
      this.message = "";
      this.upload_error = "";
      let self = this;

      var file = this.myUpload.file;
      this.myUpload.status = "uploading";
      this.getSigData(file).then((data) => {
        return axios({
          url: data.json.attributes.action,
          method: data.json.attributes.method,
          data: data.data,
          cache: false,
          contentType: false,
          processData: false,
        }).then(
          (response) => {
            if (file.type.startsWith("image/")) {
              return axios.get(
                  this.event_url +
                    "/?path=/" +
                    this.folder +
                    "/" +
                    data.json.name
                )
                .then((response) => {
                  console.log(response);
                  this.myUpload.status = "complete";
                  this.myUpload.url =
                    "https://dataczar-public.s3.us-west-2.amazonaws.com/" +
                    this.folder +
                    "/" +
                    data.json.name;
                    this.uploadComplete(this.myUpload.url);
                });
            }
            this.myUpload.status = "complete";
            this.myUpload.url =
                "https://dataczar-public.s3.us-west-2.amazonaws.com/" +
                this.file_folder +
                "/" +
                data.json.name;
            
          },
          function (error) {
            this.myUpload.status = "failed";
            /* self.uploads_completed++;
self.uploads[self.uploads_completed - 1].status = "failed";
self.upload_error = "Invalid File Type";
self.uploads = []; */
          }
        );
      });
    }, //end upload
    createPreview() {
      var vm = this;
      if (this.myUpload.file.type.startsWith("image")) {
        var reader = new FileReader();
        reader.onload = (e) => {
          vm.myUpload.preview = e.target.result;
        };
        reader.readAsDataURL(this.myUpload.file);
      } else {
        vm.myUpload.preview = "false";
        vm.myUpload.preview = false;
      }
    },
  },
  updated: function () {
    if (this.myUpload.status == "pending") {
      this.autoUpload();
    }
    console.log(this.myUpload.status);
  },
  mounted: function () {
    this.createPreview();
  },
};
</script>
