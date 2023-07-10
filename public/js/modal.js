var modal = {
    props: {
        modalContainer: {
            default: 'modal-container',
        }
    },
    data : function () {
        return {
            showModal: false,
        };
    },
    template: `
    <div>
    <transition name="modal">
      <div class="modal-mask" v-on:click="$emit('close')">
        <div class="modal-wrapper">
          <div v-bind:class="[this.modalContainer]" v-on:click.stop>
            

            <div class="row-fluid">
                <div class="card">
                    <div class="card-header">
                        
                        <slot name="header">
                            default header
                        </slot>
                                
                    </div>
                    <div class="card-block card-block-light">
                        <slot name="body">
                            default body
                        </slot>
                    </div>
                </div>
            </div>



          </div>
        </div>
      </div>
    </transition>
    </div>
    `,

};


