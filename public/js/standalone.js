var Standalone = {
    props: ['name','image','search_url', 'downup_url', 'imagelist_url', 'filelist_url', 'event_url', 'folder', 'sig', 'type'],
    data : function () {
        return {
            showFile: false,
            myImage:this.image,
        };
    },
    components: {
        'image-manager': ImageManager,
    },
    methods: {
        filemanager() {
            this.showFile = this.showFile ? false : true;
        },
        standalone(url) {
            this.myImage = url;
            this.$emit('standalone', url);
            this.showFile = false;
        },
    },
    template: `
<div>
    <div v-if="myImage != undefined && myImage != ''" style="position: relative; width: 150px;" v-cloak>
        <a href v-on:click.prevent="myImage = ''" class="btn btn-xs btn-danger clear_holder"
            style="position: absolute; top:5px; right:5px;">
            <i class="fa fa-times"></i>
        </a>
        <img width="150px" class="img img-thumbnail" v-bind:src="myImage" v-cloak>
    </div>
    <div class="input-group">
        <span class="input-group-btn">
            <a href v-on:click.prevent="filemanager()" class="btn btn-primary filemanager">
                <i class="fa fa-picture-o"></i> Choose
            </a>
        </span>
        <input v-model="myImage" id="featured_image" class="form-control" type="hidden" :name="name">
    </div>

    <div class="card" v-if="showFile" v-cloak style="position: absolute;z-index: 9;width: 100%;">
        <div class="card-block card-block-light">
            <strong>File Manager</strong>

            <image-manager v-on:url="standalone" v-on:close="showFile = false;" :search_url="search_url"
                :downup_url="downup_url" :imagelist_url="imagelist_url" :event_url="event_url" :folder="folder"
                :filelist_url="filelist_url" :sig="sig" context="selector" type="standalone">
            </image-manager>
        </div>
    </div>
</div>
    `,

};


