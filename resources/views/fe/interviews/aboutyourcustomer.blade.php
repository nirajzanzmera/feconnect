<div class="modal fade" id="interview" tabindex="-1" role="dialog" aria-labelledby="interviewLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="container-fluid px-0">
                    <div class="row">
                        <h5 class="col modal-title" id="interviewLabel">About Your Customer</h5>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <form action="{{-- route('teams.update', $team) --}}" method="post" id="modal_form">
                    {{ method_field('PUT') }} {{ csrf_field() }}
                    <div class="tab">


                                <div class="alert alert-info">
                                    <label>What would your customer search for to find you?</label>
                                    <a class="btn btn-xs q-mark" tabindex="0" data-toggle="popover" data-placement="left" data-content="
                            <em>
                                Suggest keywords based on words in ad and about; one keyphrase per line
                            </em>
                            " data-original-title="" title="">
                                        <i class="fa fa-btn fa-question-circle"></i>
                                    </a>
                                </div>
                                <fieldset class="form-group ">
                                    <div class="col-md-12">
                                    <label for="territory" class="form-control-label" title="What is your territory?">What is your territory?</label>
                                    <select class="custom-select" name="" id="territory">
                                        <option selected="">Select one</option>
                                        <option value="">Whole country</option>
                                        <option value="">Within 50 miles</option>
                                        <option value="">Within 250 miles</option>
                                    </select>
                                        </div>
                                </fieldset>


                            <fieldset class="form-group" id="autocomplete">
                                <div class="col-md-12">
                                    <label for="industry" class="form-control-label" title="What is your industry?">What is your industry?</label>
                                </div>
                                <div class="col-md-12" style="position:relative" v-bind:class="{'open':openSuggestion}">
                                    <input id="industry" type="text" class='form-control' v-model='value'
                                           v-on:keydown.enter="enter"
                                           v-on:keydown.down="down"
                                           v-on:keydown.up="up"
                                    />

                                    <ul class="dropdown-menu list-group" style="width:100%">
                                        <li class="list-group-item" v-for="(suggestion, index) in matches"
                                            v-bind:class="{'active': isActive(index)}"
                                            v-on:click="suggestionClick(index)"
                                        >

                                            <a href="#">@{{ suggestion }}</a>
                                        </li>
                                    </ul>
                                </div>
                            </fieldset>

                            <div class="alert alert-info">
                                <em>
                                    Updates metadata for site and prepares data for Marketing step.
                                </em>
                            </div>

                            <input type="hidden" name="interview" id="interview_complete" value="true">

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="Close" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" onclick="getElementById('modal_form').submit()" id="submit" >
                    <i class="fa fa-save"></i>
                    Save changes
                </button>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('assets/vendor/jquery.min.js') }}"></script>
<!-- jQuery -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.17/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.17.1/axios.min.js"></script>
<script>
    var app = new Vue({
        el: '#autocomplete',
        data () {
            return {
                open: false,
                current: 0,
                suggestions: [],
                value: "",
            }
        },
        watch: {
            value: function (val) {
                this.updateValue(val);
            }
        },
        methods: {
            // Triggered the input event to cascade the updates to
            // parent component @input="updateValue($event.target.value)"
            updateValue(val) {
                if (this.open === false) {
                    this.open = true
                    this.current = 0
                }
                this.value = val;
            },

            // When enter key pressed on the input
            enter () {
                this.updateValue(this.matches[this.current]);
                this.open = false

            },

            // When up arrow pressed while suggestions are open
            up () {
                if (this.current > 0) {
                    this.current--
                }
            },

            // When down arrow pressed while suggestions are open
            down () {
                if (this.current < this.matches.length - 1) {
                    this.current++;
                }
            },

            // For highlighting element
            isActive (index) {
                return index === this.current
            },

            // When one of the suggestion is clicked
            suggestionClick (index) {
                this.updateValue(this.matches[index])
                this.open = false
            }
        },
        mounted() {
            console.log('miiitttt');
            axios.get('{{ asset('assets/data/Industries.csv') }}').then(response => {
                let outputs = response.data.split(',');
            this.suggestions = [...outputs];
            console.log(this.suggestions);
        }).catch(err => console.log(err));
        },

        computed: {

            // Filtering the suggestion based on the input
            matches () {
                return this.suggestions.filter((obj) => {
                            return obj.toLowerCase().indexOf(this.value.toLowerCase()) >= 0
                        })
            },

            openSuggestion () {
                return this.value !== '' &&
                        this.matches.length !== 0 &&
                        this.open === true
            }
        }
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('[data-toggle="popover"]').popover({
            trigger: 'focus',
            html: true,
        });
    });

</script>
<script type="text/javascript">
$(document).ready(function() {
    $('#interview').modal();

    $(document).on('hidden.bs.modal', function(e) {
        //save stuff
        $('#interview_complete').val('delay');
        //$('#modal_form').submit(); // skip saving until we fix modal routes
    });

});
</script>
