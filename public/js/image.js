var ImageContainer = {
    props: ['myImage', 'delete_url', 'context', 'display_type'],
    data: function () {
        return {
            menu: false,
            delete_menu: false,
        };
    },
    methods: {
        imageUse(image) {
            this.$parent.$emit('url', image);
        },
        imageDeleteAlert(image) {
            console.log(image);
            this.delete_menu = true;
        },
        imageDelete(image) {
            axios.delete(this.delete_url + '/' + image.filename + '.' + image.extension).then(() => {
                this.menu = false;
                this.delete_menu = false;
                this.$emit('reloadImages');
            });
        }
    },
    mounted: function () {

    },
    template: `
<div>

<div v-if="display_type != 'file_view'">    
    <img v-on:click.prevent="menu = !menu;" v-bind:class="{ 'image-display-hover' : menu }" v-bind:src='myImage.image'
        class="image-display">
    <div class="middle" v-bind:class="{ 'middle-hover' : menu }">
        <div v-if="menu" v-cloak>
            <div class="btn-group" v-if="!delete_menu" >
                <a v-on:click.prevent="imageUse(myImage.image)" href="" class="btn btn-sm btn-primary" v-if="context=='selector'">Use</a>
                <a v-on:click.prevent="imageDeleteAlert(myImage)" href="" class="btn btn-sm btn-danger" v-if="context!='selector'">Delete...</a>
            </div>
            <div v-if="delete_menu">
                <p class="alert alert-danger">
                    <i class="fa fa-warning"></i>
                    <strong>Are you sure?</strong><br /> This can't be undone. Any links to this image will be broken.
                </p>
                <div class="btn-group" >
                    <a v-on:click.prevent="imageDelete(myImage)" href="" class="btn btn-sm btn-danger">
                        <i class="fa fa-trash-o"></i>
                        Delete
                    </a>
                    <a v-on:click.prevent="delete_menu = false; menu = false;" href="" class="btn btn-sm btn-default">
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row" v-if="display_type == 'file_view'">
    <div class="col-xl-2 media-middle">
        <i style="padding:5px;" class="fa fa-file-pdf-o fa-2x" v-if="myImage.extension == 'pdf'"></i>
        <i style="padding:5px;" class="fa fa-file-audio-o fa-2x" v-if="myImage.extension == 'mp3'"></i>
    </div>
    <div class="col-xl-8 media-middle ellipsis">
        <a :href="myImage.file" target="_bank">
            {{ myImage.filename }}.{{ myImage.extension }}
        </a>
        <div class="pull-right">

            <div class="btn-group" v-if="!delete_menu">
                <a v-on:click.prevent="imageUse(myImage.file)" href="" class="btn btn-sm btn-primary"
                    v-if="context=='selector'">Use</a>
                <a v-on:click.prevent="imageDeleteAlert(myImage)" href="" class="btn btn-sm btn-danger"
                    v-if="context!='selector'">Delete...</a>
            </div>

        </div>
    </div>
    <div class="col-xl-2 media-middle">
        {{ myImage.created }}
    </div>

</div>

<div class="col-md-12 text-center" v-if="display_type == 'file_view' && delete_menu">
    <div class="alert alert-danger" style="overflow-wrap: break-word;">
        <i class="fa fa-warning"></i>
        <strong>Are you sure?</strong><br /> This can't be undone. Any links to this file will be broken.
    </div>
    <div class="btn-group">
        <a v-on:click.prevent="imageDelete(myImage)" href="" class="btn btn-sm btn-danger">
            <i class="fa fa-trash-o"></i>
            Delete
        </a>
        <a v-on:click.prevent="delete_menu = false; menu = false;" href="" class="btn btn-sm btn-default">
            Cancel
        </a>
    </div>
</div>



</div>
    `,

};


