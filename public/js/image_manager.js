var ImageManager = {
    props: ['search_url', 'downup_url', 'imagelist_url', 'filelist_url', 'event_url', 'delete_url', 'file_folder', 'folder', 'sig', 'file_sig', 'type', 'context','field_name'],
    data: function () {
        return {
            tab: 'upload',
            showModal: false,
            search_term: '',
            page: 1,
            photos: [],
            photo_count: 0,
            selected: '',
            images: [],
            image_status: 'done',
            files: [],
            file_status: 'done',
            uploads: [],
            uploads_completed: 0,
            image_preview: '',
            message: '',
            upload_error: '',
        };
    },
    components: {
        'ImageContainer': ImageContainer,
    },
    computed: {
        lastPage(){
            return (this.page * 20 > this.photo_count) ? true : false;
        },
        sortedImages() {
            var images = this.images;
            images = _.orderBy(images, ['modified'], ['desc']);
            return images;
        },
        sortedFiles() {
            var files = this.files;
            files = _.orderBy(files, ['modified'], ['desc']);
            return files;
        },
    },
    methods: {
        findImages() {
            this.page = 1;
            this.search();
        },
        search() {
            if (this.search_term !== '') {
                this.photos = [];
                return axios.post(this.search_url, { search: this.search_term, page: this.page })
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
            if(this.page > 1) {
                this.page--;
                this.search();
            }
        },
        select(photo) {
            this.selected = photo;
        },
        cancel() {
            this.selected = '';
        },
        download(photo) {
            if (photo != undefined) {
                axios.post(this.downup_url, { image: photo }).then((response) => {
                    this.selected = '';
                    this.tab = 'images';
                    this.getImages();
                });
            }
        },
        getImages() {
            this.image_status = 'loading';
            return axios.get(this.imagelist_url).then((response) => {
                this.images = response.data;
                this.image_status = 'done';
            });
        },
        getFiles() {
            this.file_status = 'loading';
            return axios.get(this.filelist_url).then((response) => {
                this.files = response.data;
                this.file_status = 'done';
            });
        },
        imageUse(url) {
            this.$emit('url', {url: url, field_name: this.field_name});
        },
        imageDelete(image) {
            console.log(image);
        },
        fileChange() {
            this.uploads = [];
            for (var i = 0; i < this.$refs.myImages.files.length; i++) {
                /* console.log(this.$refs.myImages.files[i].type); */
                if (this.$refs.myImages.files[i].type.startsWith('image')) {
                    this.createImage(this.$refs.myImages.files[i]);
                } else {
                    this.uploads.push({
                        file: this.$refs.myImages.files[i],
                        preview: false,
                        status: 'pending',
                    });
                }
            }
        },
        copyLink(link) {
            clipboard.writeText(link);
            alert('Copied to Clipboard');
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
                    status: 'pending'
                })
            };
            reader.readAsDataURL(file);
        },
        getSigData(file) {
            if (file.type.startsWith('image/')) {
                var folder = this.folder;
                var sig = this.sig;
            } else {
                var folder = this.file_folder;
                var sig = this.file_sig;
            }
            return axios.get('/upload/signed?type=' + file.type +
                '&folder=' + folder + '&sig=' + sig + '&pub=true&content_type=' + file.type +
                '&name=' + file.name)
                .then((response) => {
                    var data = new FormData();
                    var json = response.data;
                    var arr = Object.keys(json.additionalData);
                    arr.forEach(function (value, index) {
                        data.append(value, json.additionalData[value]);
                    });
                    data.append('file', file);
                    return {
                        data: data,
                        json: json,
                    };
                });

        },
        cancel_upload(index) {
            this.uploads.splice(index, 1);
        },
        upload() {
            if (this.uploads.length < 1) {
                return false;
            }
            this.message = "";
            this.upload_error = "";
            let self = this;
            for (var i = 0; i < this.uploads.length; i++) {
                var file = this.uploads[i].file;
                this.uploads[i].status = 'uploading';
                this.getSigData(file).then((data) => {
                    return axios({
                        url: data.json.attributes.action,
                        method: data.json.attributes.method,
                        data: data.data,
                        cache: false,
                        contentType: false,
                        processData: false,
                    }).then((response) => {
                        if (file.type.startsWith('image/')) {
                            axios.get(this.event_url + '/?path=/' + this.folder + '/' + data.json.name);
                        }
                        this.uploads_completed++;
                        this.uploads[this.uploads_completed - 1].status = 'complete';
                        if (this.uploads_completed == this.uploads.length) {
                            this.uploads = [];
                            this.uploads_completed = 0;
                            this.message = "Upload Complete";
                            /* this.tab = 'images';
                            this.getImages(); */
                        }
                    }, function(error) {
                        self.uploads_completed++;
                        self.uploads[self.uploads_completed - 1].status = 'failed';
                        self.upload_error = "Invalid File Type";
                        self.uploads = [];
                    });
                });
            }; //end for loop 
        }, //end upload
    },
    template: `
<div id="image_manager">
<a href v-if="type == 'standalone'" v-on:click.prevent="$emit('close')"
    title="Close Filemanager" class="btn btn-danger btn-sm"
    style="position: absolute; right:5px; top:5px;">
    <i class="fa fa-times"></i>
</a>
<ul class="nav nav-pills flex-column flex-sm-row" style="padding-bottom: 15px;" v-bind:class="[type == 'iframe' ? 'windowed' : '']">
    <li class="nav-item">
        <a class="nav-link" href v-bind:class="{ active: tab == 'upload' }" v-on:click.prevent="tab = 'upload'">
            <i class="fa fa-upload"></i>
            Upload
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href v-bind:class="{ active: tab == 'images' }"
            v-on:click.prevent="tab = 'images'; getImages();">
            <i class="fa fa-image"></i>
            My Images
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href v-bind:class="{ active: tab == 'files' }"
            v-on:click.prevent="tab = 'files'; getFiles();">
            <i class="fa fa-file"></i>
            My Files
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href v-bind:class="{ active: tab == 'search' }" v-on:click.prevent="tab = 'search'">
            <i class="fa fa-search"></i>
            Free Images
        </a>
    </li>
</ul>

<div class="alert alert-success" v-if="message != '' && tab == 'upload'" v-cloak>
    {{ message }}
</div>

<div class="alert alert-danger" v-if="upload_error != '' && tab == 'upload'" v-cloak>
    {{ upload_error }}
</div>

<div class="card" v-if="tab == 'upload'">
            <div class="card-header">
                <div class="media">
                    <div class="media-body">
                        <div class="card-title">
                            Upload Images / Files
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-block card-block-light">
                <fieldset class="form-group ">
                    <a href="" v-on:click.prevent="selectImages()" class="btn btn-primary">
                        <i class="fa fa-file"></i>
                        Choose Files
                    </a>
                    <input type="file" v-on:change="fileChange()" ref="myImages" accept="image/*, application/pdf, audio/mp3" multiple="multiple"
                        class="inputFile" placeholder="">
                </fieldset>
                <fieldset class="form-group ">
                    <a href v-if="uploads.length > 0" v-on:click.prevent="upload()" class="btn btn-success">
                        <i class="fa fa-upload"></i>
                        Upload
                    </a>
                </fieldset>

                <h4 v-if="uploads.length > 0" v-cloak>
                    <hr>
                    Upload Previews
                </h4>
                <div class="card-columns photos" v-cloak>
                    <div class="card text-center" v-for="(upload, index) in uploads">
                        <a href v-if="upload.status == 'uploading'" v-on:click.prevent="" title="Uploading..."
                            class="btn btn-default btn-sm" style="position: absolute; right:5px; top:5px;">
                            <i class="fa fa-spinner fa-pulse"></i>
                        </a>
                        <a href v-if="upload.status == 'complete'" v-on:click.prevent="" title="Completed"
                            class="btn btn-success btn-sm" style="position: absolute; right:5px; top:5px;">
                            <i class="fa fa-check"></i>
                        </a>
                        <a href v-if="upload.status == 'pending'" v-on:click.prevent="cancel_upload(index)"
                            title="Cancel Upload" class="btn btn-danger btn-sm"
                            style="position: absolute; right:5px; top:5px;">
                            <i class="fa fa-times"></i>
                        </a>

                        <div v-if="upload.preview == false">

                            <i style="padding:25px;" class="fa fa-file-pdf-o fa-5x" v-if="upload.file.type == 'application/pdf'"></i>
                            <i style="padding:25px;" class="fa fa-file-audio-o fa-5x" v-if="upload.file.type == 'audio/mp3' || upload.file.type == 'audio/mpeg'"></i>
                            <br />
                            <br />
                            {{ upload.file.name }}
                        </div>

                        <img v-if="upload.preview != false" v-bind:src='upload.preview' alt="" class="card-img-top img-fluid">
                    </div>
                </div>
            </div>
        </div>
















        <div class="card" v-if="tab == 'images'" v-cloak>
            <div class="card-header">
                <div class="media">
                    <div class="media-body">
                        <div class="card-title">
                            My Images
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-block card-block-light">
                <div class="div" v-if="image_status == 'loading'" v-cloak>
                    Loading ...
                    <i class="fa fa-spinner fa-pulse"></i>
                </div>
                <div class=" photos" v-cloak style="overflow:auto;">
        
                    <div class="image-result" style="float:left;" v-for="image in sortedImages">
                    
                        <ImageContainer :myImage="image" :delete_url="delete_url" :context="context" v-on:reloadImages="getImages()"></ImageContainer>
                    
                    </div>
                </div>
                
                
                
            </div>
        </div>








    <div class="card" v-if="tab == 'files'" v-cloak>
        <div class="card-header">
            <div class="media">
                <div class="media-body">
                    <div class="card-title">
                        My Files
                    </div>
                </div>
            </div>
        </div>
        
        <div class="div" v-if="file_status == 'loading'" v-cloak>
            Loading ...
            <i class="fa fa-spinner fa-pulse"></i>
        </div>
            <ul class="list-group" v-cloak>
                <li class="list-group-item" v-for="file in sortedFiles">
                   
                    <ImageContainer :myImage="file" :delete_url="delete_url" :display_type="'file_view'" :context="context" v-on:reloadImages="getFiles()"></ImageContainer>

                </li>
            </ul>
    </div>


















        <div class="card" v-if="tab == 'search'" v-cloak>
            <div class="card-header">
                <div class="media">
                    <div class="media-body">
                        <div class="card-title">
                            Search for Free Images
                        </div>
                    </div>
                    <div class="media-right">
                        <a href="https://pixabay.com/" target="_blank" title="Images provided by Pixabay.com">
                            <img src="https://dataczar-public.s3.us-west-2.amazonaws.com/photos/54/pixabay_logo_DKrud.png" style="max-width:100px;" alt="Images provided by Pixabay.com">
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-block card-block-light">
                <div class="input-group">
                    <input type="text" class="form-control" v-model="search_term" v-on:keydown.enter.prevent="findImages()">
                    <a href="" class="btn btn-success input-group-addon" v-on:click.prevent="findImages()">
                        <i class="fa fa-search"></i>
                    </a>
                </div>
                
<nav class="center" v-if="(photos.length > 0 || page > 1) && selected == ''" v-cloak>
    
    <ul class="pagination">
        <li class="page-item" v-bind:class="{ disabled: page == 1 }">
            <a v-on:click.prevent="prevPage()" class="page-link" href="#">
                Previous
            </a>
        </li>
        <li class="page-item disabled">
            <a class="page-link">
            {{ page * 20 }} / {{ photo_count }}
            </a>
        </li>
        <li class="page-item" v-bind:class="{ disabled: lastPage }">
            <a v-on:click.prevent="nextPage()" class="page-link" href="#">
                Next
            </a>
        </li>
    </ul>
</nav>


                <div class="card-columns photos" v-if="selected == ''" v-cloak> 
                    <div class="card" v-for="photo in photos">
                        <a v-on:click.prevent="select(photo.image)" class="">
                            <img v-bind:src='photo.large_preview' alt="" class="card-img-top img-fluid img-result">
                        </a>
                    </div>
                </div>

                <div class="text-center" v-if="selected != ''" v-cloak>
                    <div class="btn-group" style="padding: 15px;">
                        <a v-on:click.prevent="download(selected)" href="" class="btn btn-large btn-success">
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
                        <img v-bind:src='selected' alt="" class="card-img-top img-fluid"
                            style="margin:auto; width:auto; max-height: 650px;">
                    </div>

                    <br />
                    <div class="btn-group" style="padding: 15px;">
                        <a v-on:click.prevent="download(selected)" href="" class="btn btn-large btn-success">
                            <i class="fa fa-check"></i>
                            Use this Image
                        </a>
                        <a v-on:click.prevent="cancel()" class="btn btn-large btn-default">
                            <i class="fa fa-times"></i>
                            Cancel
                        </a>
                    </div>
                </div>



                <nav class="center" v-if="(photos.length > 0 || page > 1) && selected == ''" v-cloak>
    
                <ul class="pagination">
                    <li class="page-item" v-bind:class="{ disabled: page == 1 }">
                        <a v-on:click.prevent="prevPage()" class="page-link" href="#">
                            Previous
                        </a>
                    </li>
                    <li class="page-item disabled">
                        <a class="page-link">
                        {{ page * 20 }} / {{ photo_count }}
                        </a>
                    </li>
                    <li class="page-item" v-bind:class="{ disabled: lastPage }">
                        <a v-on:click.prevent="nextPage()" class="page-link" href="#">
                            Next
                        </a>
                    </li>
                </ul>
            </nav>




            </div>

        </div>
</div>
        `,

};


