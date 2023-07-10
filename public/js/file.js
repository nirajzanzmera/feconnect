var ImageContainer = {
    props: ['myFile', 'delete_url',  'context'],
    data : function () {
        return {
            menu: false,
            delete_menu: false,
        };
    },
    methods: {
        fileUse(image){
            this.$parent.$emit('url', image);
        },
        fileDeleteAlert(url){
            this.delete_menu = true;
        },
        fileDelete(file) {
            axios.delete(this.delete_url + '/' + file.filename + '.' + file.extension).then(() => {
                this.menu = false;
                this.delete_menu = false;
                this.$emit('reloadImages');
            });
           
        }
    },
    mounted: function() {
    
    },
    template: `
    <div>

    <img v-on:click.prevent="menu = !menu;" v-bind:class="{ 'image-display-hover' : menu }" v-bind:src='myFile.image'
        class="image-display">
    <div class="middle" v-bind:class="{ 'middle-hover' : menu }">
        <div v-if="menu" v-cloak>
            <div class="btn-group" v-if="!delete_menu" >
                <a v-on:click.prevent="fileUse(myFile.image)" href="" class="btn btn-sm btn-primary" v-if="context=='selector'">Use</a>
                <a v-on:click.prevent="fileDeleteAlert(myFile)" href="" class="btn btn-sm btn-danger" v-if="context!='selector'">Delete...</a>
            </div>
            <div v-if="delete_menu">
                <p class="alert alert-danger">
                    <i class="fa fa-warning"></i>
                    <strong>Are you sure?</strong><br /> This can't be undone. Any links to this image will be broken.
                </p>
                <div class="btn-group" >
                    <a v-on:click.prevent="fileDelete(myFile)" href="" class="btn btn-sm btn-danger">
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
    `,

};


