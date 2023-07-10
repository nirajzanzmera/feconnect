<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="media">
                    <div class="media-body media-middle">
                        <h4 class="card-title">
                            Email Info 
                        </h4>
                    </div>
                </div>
            </div>
            <div class="card-block">
                <div class="row form-group">
                    <div class="col-lg-2">
                        <label>DATE:</label>
                    </div>
                    <div class="col-lg-4">
                        <input name="send_date" class="datepicker form-control" type="text"
                            value="{{ old('send_date', !empty($campaign->send_date) ? $campaign->send_date : NULL ) }}"
                            autocomplete="nope">
                    </div>
                    <div class="col-lg-2">
                        <label>TIME:</label>
                    </div>
                    <div class="col-lg-4">
                        <div class="input-group">
                            <input name="send_time" id="timepicker" type="text" class="form-control"
                                value="{{ old('send_time', !empty($campaign->send_time) ? $campaign->send_time : NULL ) }}"
                                autocomplete="off">
                            <span class="input-group-addon">{{ $team->send_timezone ?? '' }}</span>
                        </div>
                    </div>
                </div>

                <div class="row form-group{{ $errors->has('sender_id') ? ' has-error' : '' }}">
                    <label class="col-md-12 col-lg-2">FROM:</label>
                    <div class="col-md-4">
                        <select name="sender_id" id="sender_id" class="form-control">
                            @foreach ($senders as $sender)
                            @if(old('sender_id', !empty($campaign->sender_id) ? $campaign->sender_id : NULL ) ==
                            $sender->id)
                            <option value="{{ $sender->id }}" selected>{{ $sender->from_name }}
                                &#x3C;{{ $sender->email }}&#x3E;</option>
                            @else
                            <option value="{{ $sender->id }}">{{ $sender->from_name }} &#x3C;{{ $sender->email }}&#x3E;
                            </option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <a href="{{ route('senders.index') }}" target="_blank" class="btn btn-sm btn-success"
                            title="Add a new From Address (Sender)"><i class="material-icons">add</i></a>
                    </div>
                </div>
                <div class="row form-group{{ $errors->has('list_id') ? ' has-error' : '' }}">
                    <label class="col-md-12 col-lg-2">TO:</label>
                    <div class="col-md-4">
                        <select name="list_id" class="form-control" id="list_drop">
                            @foreach ($lists as $list)
                            @if(old('list_id', !empty($campaign->list_id) ? $campaign->list_id : $default_list_id ) ==$list->id )
                                <option data-default-sender="{{ $list->default_sender ?? '' }}" value="{{ $list->id }}" selected>
                                    {{ $list->name }}
                                </option>
                                @else
                                <option data-default-sender="{{ $list->default_sender ?? '' }}" value="{{ $list->id }}">
                                    {{ $list->name }} ({{ $list->subscribers_count ?? '' }})
                                </option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <span id="filters" class="btn btn-sm btn-success"><i class="material-icons">filter_list</i>
                            Filter List</span>
                        <strong class=pull-right style="padding-top:5px;"> List Count: <span
                                id="list_count"></span></strong>
                    </div>
                </div>
                <div id="filter_form" class="row form-group" style="display: none; background:#62cfdb; padding: 25px;">
                    <div class="col-md-6 offset-md-2">
                        <label class="">Select an Imported File</label>
                        <select name="file_id" class="form-control" id="files_drop"></select>
                        <div class="help-text"><em>This email will only send to active Subscribers, that were in this
                                file.</em>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="alert">

                        </div>
                    </div>
                </div>

                <div class="row form-group{{ $errors->has('subject') ? ' has-error' : '' }}">
                    <label class="col-lg-2">SUBJECT:</label>
                    <div class="col-md-10">
                        @if(!empty($campaign->subject))
                        <input id="input_subject" type="text" class="form-control" name="subject" value="{{ $campaign->subject }}">
                        @elseif(!empty($news))
                        <input id="input_subject" type="text" class="form-control" name="subject"
                            value="{{ html_entity_decode( $news->main->title) }}">
                        @else
                        <input id="input_subject" type="text" class="form-control" name="subject" value="{{ old('subject') }}">
                        @endif
                    </div>
                </div>

                @if ($reachvars)
                <div class="row form-group{{ $errors->has('sid') ? ' has-error' : '' }}">
                    <label class="col-lg-2">SID:</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="sid" value="{{ old('sid', !empty($campaign->schid->item->sid) ? $campaign->schid->item->sid : '' ) }}">
                    </div>
                </div>
                    
                @endif

            </div> {{-- end card block --}}
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <div class="media">
                    <div class="media-body media-middle">
                        @if(!empty($campaign->status))
                        <div class="pull-right">
                            Current Status:
                            <div class="label label-default">
                                {{ ucfirst($campaign->status) }}
                            </div>
                        </div>
                        @endif
                        <h4 class="card-title">
                            Email Actions
                        </h4>
                    </div>
                </div>
            </div>
            <div class="card-block">
                @if(!empty($campaign))
                <div class="input-group">
                    <input type="email" class="form-control ignore-me" id="test_email" placeholder="email address">
                    <span class="input-group-btn">
                        <button class="btn btn-sm btn-success send-btn" type="button" id="send_test_email"><i
                                class="material-icons">mail</i> Send Test</button>
                    </span>
                </div>
                <div class="alert" id="test_email_message_block">
                    <strong id="test_email_message">message</strong>
                </div>
                <hr>
                @endif
                @if($team->status == 'active' && !empty($campaign))
                <div class="form-group has-{{ !empty($spam) ? $spam['color'] : ''}}">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-{{ !empty($spam) ? $spam['color'] : ''}}"
                            id="spam_score" placeholder="0/0"
                            value="{{ !empty($spam) ? $spam['status'] : 'No Score yet' }}" disabled=disabled>
                        <span class="input-group-btn">
                            <button class="btn btn-sm btn-success spam-btn" type="button" id="get_spam_score"
                                title="{{ $campaign->schid->id ?? '' }}"><i class="material-icons">security</i> Get
                                Score</button>
                        </span>
                    </div>
                    @if(!empty($spam['msg']))<small class="text-help">{{ $spam['msg'] }}</small>@endif
                </div>
                <div class="alert alert-success" id="spam_score_message_block">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong id="spam_score_message_block">message</strong>
                </div>
                @endif
            </div>
            @include('fe.campaigns._buttons')
        </div>
    </div>
</div>

{{-- Include for tabbed  HTML editor --}}
@include('layouts.partials._editor')


<div class="row-fluid">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-block">
                @include('fe.campaigns._buttons')
            </div>
        </div>
    </div>
</div>
</form>

@section('js2')

<script type="text/javascript" src="//cdn.jsdelivr.net/jquery.dirtyforms/2.0.0/jquery.dirtyforms.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){

    var lists = {!! !empty($json) ? $json : '""' !!};
    var myList =  $('#list_drop').val();
    var dirty = false;

    updateItems();

    @if(Route::currentRouteName() == 'campaigns.create')
        default_sender();
    @endif

    $('#list_drop').on('change', function(){
        updateItems();
        updateListCount();
        default_sender();
    });

    function default_sender() {
        var default_sender = $('#list_drop').find('option:selected').data("default-sender");
        $('#sender_id').val(default_sender);
    }

    updateListCount();
    function updateListCount() {
        $('#list_count').html('loading...');
        $.get('{{ route('list.get_count') }}?id=' + myList, function(data) {
            $('#list_count').html(data);
        });
    }

    $('.question').on('click', function(e){
        e.preventDefault();
        var target = $(this).data('target-id');
        $('.'+target).toggle();
    });

    function updateItems() {
        myList =  $('#list_drop').val();

        var items = '<option value=""> ( Do Not Filter ) </option>';
        $.each(lists[myList].files, function (i, file) {
            items += "<option value='" + file.id + "'>" + file.original_filename + " - Imported on " + file.created_at + "</option>";
        });
        $('#files_drop').html(items);
    }

    $('.save_and_sched').on('click', function(e){
        e.preventDefault();
        var action = $('#editor_form').attr('action') + '?sched=true';
        $('#editor_form').attr('action', action);
        $('#editor_form').submit();
    });

    $('.save_as_email').on('click', function(e){
        e.preventDefault();
        $('input[name=_method]').remove();
        $('#editor_form').attr('action', '{{ route('campaigns.store') }}');
        $('#editor_form').submit();
    });

    $('.save_as_template').on('click', function(e){
        e.preventDefault();
        $('input[name=_method]').attr('name', 'name').val( $('input[name=subject]').val() );
        $('#editor_form').attr('action', '{{ route('templates.store') }}');
        $('#editor_form').submit();
    });


    var filter = {{ !empty($filter) && !empty($filter->and) ? '1' : '0' }};
    if (filter == 1) {
        $(function() {
            $('#filters').hide('slow');
            $('#filter_form').show('slow');
            {{--
            $("#group").val('{{ !empty($filter) && !empty($filter->and) ? $filter->and[0]->value : ''}}');
            $("#compare").val("{!! !empty($filter) && !empty($filter->and) ? $filter->and[0]->comparator : '' !!}");
            $("#files_drop").val('{{ !empty($filter) && !empty($filter->and) ? $filter->and[1]->value : ''}}');
            --}}
        });
    } else {
        $('#filters').on('click', function(){
            $('#filters').hide('slow');
            $('#filter_form').show('slow');
        });
    }

    $.fn.plusDatePicker = function () {
        if (! this.length) return;
        if (typeof $.fn.datepicker != 'undefined') {
            this.datepicker({
                autoclose: true,
                todayHighlight: true,
            });
        }
    };
    /**
    * jQuery timepicker plugin wrapper for compatibility
    */
    $.fn.plusTimePicker = function () {
        if (! this.length) return;
        if (typeof $.fn.datepicker != 'undefined') {
            this.timepicker({
                minuteStep: 5,
                showInputs: false,
                disableFocus: true,
                format: 'Y-m-d',
                icons: {
                    up: 'material-icons up',
                    down: 'material-icons down'
                }
            });
        }
    };
    $('.datepicker').plusDatePicker();
    $('#timepicker').plusTimePicker({
        minuteStep: 5,
        showInputs: false,
        disableFocus: true
    });

    $('#test_email_message_block').hide();
    $('#spam_score_message_block').hide();
    $('#send_test_email').on('click', function(){
        if (dirty === true) {
            alert('Please save your changes before sending a test.');
            return false;
        }
        if (! $('#input_subject').val()) {
            $('#input_subject').addClass('is-invalid');
            alert('Subject is required.');
            return false;
        }
        if (! $('#sender_id').val()) {
            $('#sender_id').addClass('is-invalid');
            alert('From is required.');
            return false;
        }
        $('#test_email_message_block').hide();
        var email = $('#test_email').val();
        var data = {
            'email': email
        };
        $.ajax({
            @if($team->status == 'active' && !empty($campaign))
            url: '{{ route('campaigns.send_test', isset($campaign)?$campaign->id ?? $id:NULL) }}',
            @else 
            url: @if(isset($campaign))'{{ route('campaigns.send_test_limit', isset($campaign)?$campaign->id ?? $id:NULL) }}' @else null @endif,
            @endif
            type: 'GET',
            data: data,
            success: function(data){ 
                if(data.status == 'success') {
                    $('#test_email_message_block').addClass('alert-success');
                } else {
                    $('#test_email_message_block').addClass('alert-danger');
                }
                $('#test_email_message').html(data.message);
                $('#test_email_message_block').show();
            },
            error: function(data) {
                $('#test_email_message_block').addClass('alert-danger');
                $('#test_email_message').html(data.responseJSON.message);
                $('#test_email_message_block').show();
            }
        });
    });

    var polling = false;
    var log_id = 0;
    $('#get_spam_score').on('click', function(){
        var data = {
            'email': '{{ !empty($campaign->schid) ? $campaign->schid->id : NULL }}@spam.dataczar.com'
        };
        // go get current
        $.get('{{ route('campaign.spamscore.ajax', !empty($campaign)?$campaign->id ?? $id:NULL) }}', function(data) {
            log_id = data.id !== undefined ? data.id : 0;
        });
        //send email for testing
        @if(!empty($campaign))
        $.get('{{ route('campaigns.send_test', !empty($campaign)?$campaign->id ?? $id:NULL) }}', data, function(data){
            console.log(data);
            if(data.status == 'success') {
                doPoll();
                $('#spam_score_message_block').html('<i class="fa fa-spinner fa-pulse"></i> processing...');
            } else {
                $('#spam_score_message_block').html('Something went wrong.')
            }
            $('#spam_score_message_block').show();
        })
        @endif
    });
    function doPoll(){
        $.get('{{ route('campaign.spamscore.ajax', !empty($campaign) ? $campaign->id ?? $id : NULL ) }}', function(data) {
            /*console.log(data);
            console.log(log_id);*/
            if(data.id > log_id) {
                $('#spam_score').val(data.status);
                $('#spam_score_message_block').html("Score updated");
                $('#spam_score_message_block').show();
            } else {
                //keep checkin
                setTimeout(doPoll,5000);
            }
        });
    }

    $('#editor_form').dirtyForms({
        ignoreSelector: '.ignore-me'
    });
    $('#editor_form').on('dirty.dirtyforms clean.dirtyforms', function (ev) {
        if (ev.type === 'dirty') {
            dirty = true;
            $('.schedule-btn').addClass('disabled');
            $('.spam-btn').addClass('disabled');
            $('.send-btn').addClass('disabled');
            $('.copy-btn').addClass('disabled');
        } else {
            dirty = false;
            $('.schedule-btn').removeClass('disabled');
            $('.spam-btn').removeClass('disabled');
            $('.send-btn').removeClass('disabled');
            $('.copy-btn').removeClass('disabled');
        }
    });

    $("#editor_form").submit(function (e) {
        $(".btn").attr("disabled", true);
        return true;
    });
});
</script>
@endsection
