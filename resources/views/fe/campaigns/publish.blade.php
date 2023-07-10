@extends('fe.layouts.app')
@section('content')

<div>
    <h1 class="page-heading">Email Blasts - Schedule Confirmation</h1>
</div>
<ol class="breadcrumb">
    <li><a href="{{ route('homebc') }}">Home</a></li>
    <li><a href="{{ route('campaigns.index') }}">Email Blasts</a></li>
    <li class="active">Preview</li>
</ol>
@if(count($errors) > 0)
<div class="alert alert-danger">
    @foreach ($errors->all() as $error)
    @if($error == 'The schedule must be a date after now.')
    <div>The Send Date and Time must be in the future to Schedule an Email.</div>
    @else
    <div>{!! $error !!}</div><hr>
    @endif
    @endforeach
</div>
@endif
<div class="row">
    <div class="col-md-7">
        <div class="card">
            <div class="card-block">
                <div class="row">
                    <div class="col-md-6">
                        <strong>TO:</strong> {{ isset($campaign->list->name) ? $campaign->list->name : '' }}<br />
                        <strong>FROM:</strong> {{ isset($campaign->sender->email) ? $campaign->sender->email : '' }}<br />
                        <strong>SUBJECT:</strong> {{ $campaign->subject ?? '' }}<br />
                    </div>
                    <div class="col-md-6">
                        <div class="schedule pull right">
                            <strong>Send Date:</strong> {{ $campaign->send_date  ?? '' }} <br />
                            <strong>Send Time:</strong> {{ $campaign->send_time ?? '' }} {{ $team->send_timezone ?? '' }}<br />
                            <a href="#" class="btn btn-sm btn-primary edit_schedule"><i class="fa fa-clock-o"></i> Update Send Date/Time</a>
                        </div>
                        <div class=" update_schedule hide">
                            <div class=" form-group">
                                <label class="pull-right">DATE:</label>
                                <input name="send_date" class="datepicker form-control" type="text" value="{{ old('send_date', !empty($campaign->send_date) ? $campaign->send_date : NULL ) }}">
                            </div>
                            <div class=" form-group">
                                <label class="pull-right">TIME:</label>
                                <div class="input-group">
                                    <input name="send_time" type="text" class="form-control timepicker" value="{{ old('send_time', !empty($campaign->send_time) ? $campaign->send_time : NULL ) }}" autocomplete="off">
                                    <span class="input-group-addon">{{ $team->send_timezone ?? '' }}</span>
                                </div>
                            </div>
                            <div class=" form-group pull-right">
                                <a href="#" class="btn btn-sm btn-default cancel"><i class="fa fa-times"></i> Cancel</a>
                                <a href="#" class="btn btn-sm btn-success update"><i class="fa fa-clock-o"></i> Update</a>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card card-info">
            <div class="card-block">
                @if(!empty($campaign->status) && $campaign->status != 'PUBLISHED' && $campaign->status != 'locked')
                <a href="{{ route('campaigns.edit', $campaign->id ?? $id) }}" class="btn btn-primary">
                    <i class="fa fa-edit"></i> 
                    Edit
                </a>
                @endif
                <a href="{{ route('campaigns.publish', $campaign->id ?? $id) }}" class="btn btn-success {{ (count($errors) > 0) ? 'disabled' : '' }}">
                    <i class="fa fa-calendar"></i> 
                    Schedule Send
                </a>
                @if  (!empty($errors->first('schedule')) && !$errors->has('sender_id')  && !$errors->has('subject') && count($errors) <= 1 && $team == 'active')
                <a href="{{ route('campaigns.publish', ['campaign' => $campaign->id ?? $id , 'immediate'=> true]) }}" class="btn btn-success">
                    <i class="fa fa-send"></i>
                    Send Immediately
                </a>
                @endif
            </div>
        </div>
    </div>
</div>
@include('layouts.partials._preview', ['model'=>$campaign->id ?? $id, 'route_name'=>'campaigns.iframe'])
@if(!empty($campaign->status) ?? $campaign->status != 'PUBLISHED' && $campaign->status != 'locked')
<a href="{{ route('campaigns.edit', $campaign->id ?? $id) }}" class="btn btn-primary"><i class="fa fa-edit"></i> Edit</a>
@endif
<a href="{{ route('campaigns.publish', $campaign->id ?? $id) }}" class="btn btn-success {{ (count($errors) > 0) ? 'disabled' : '' }}"><i class="fa fa-calendar"></i> Schedule Send</a>

@endsection

@section('css')
<link rel="stylesheet" href="https://src.dzr.io/connect/4/examples/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="https://src.dzr.io/connect/4/examples/css/bootstrap-timepicker.min.css">
@endsection
@php $campaignHTML = preg_replace('/\s\s+/', ' ',  $campaign->html ?? '') @endphp

@section('js')
    <script src="https://src.dzr.io/connect/4/assets/vendor/bootstrap-datepicker.min.js"></script>
    <script src="https://src.dzr.io/connect/4/assets/vendor/bootstrap-timepicker.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.edit_schedule').on('click', function(e){
                e.preventDefault();
                $('.schedule').hide();
                $('.update_schedule').show();
            });

            $('.cancel').on('click', function(e){
                e.preventDefault();
                $('.schedule').show();
                $('.update_schedule').hide(); 
            });

            $('.update').on('click', function(e){
                var date = $('.datepicker').val();
                var time = $('.timepicker').val();
                $.ajax({
                    url: '{{ route('campaigns.update_schedule', $campaign->id ?? $id) }}',
                    data: {
                        send_date: date,
                        send_time: time,
                        _method: 'put',
                    },
                    type: 'POST',
                    success: function(result) {
                        window.location = '{{ route('campaigns.publish_preview', $campaign->id ?? $id) }}';
                    }
                });  
            });

            $.fn.plusDatePicker = function () {
                if (! this.length) return;
                if (typeof $.fn.datepicker != 'undefined') {
                    this.datepicker({
                        zIndexOffset:100000,
                        autoclose: true,
                        todayHighlight: true,
                    });
                }
            };

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
            $('.timepicker').plusTimePicker();


            var campaignHTML = `{{$campaignHTML}}`;
            var campaignHTML = htmlDecode(campaignHTML);

            var tmpl_html = render_html(`${campaignHTML}`);
            $('#return').html("<iframe id="+'"preview-iframe"'+" class='embed-responsive-item' style='border: 1px solid #ddd;' src="+"data:text/html;charset=utf-8," +escape(tmpl_html)+"></iframe>");
            // $('#return').html("<iframe id="+'"preview-iframe"'+" class='embed-responsive-item' style='border: 1px solid #ddd;' src=" +
            // "data:text/html;charset=utf-8," + encodeURIComponent(tmpl_html) +
            // "></iframe>");

            $('#mobile').click( function(e) {
                e.preventDefault();
                $(this).addClass('active');
                $('#desktop').removeClass('active');
                $('#preview-iframe').animate({ width: "375px" });
            });

            $('#desktop').click( function(e) {
                e.preventDefault();
                $(this).addClass('active');
                $('#mobile').removeClass('active');
                $('#preview-iframe').animate({ width: "100%" });
            });     

            function render_html(html) {
                var sender_id = {{ !empty($campaign->sender_id) ? $campaign->sender_id : 0 }};
                var data = {};
                $.ajax({
                    url: '{{ route('senders.json')}}/' + sender_id,
                    async: false,
                    dataType: 'json',
                    success: function (json) {
                        data = {
                            sender: json
                        };
                    }
                });
                var tmpl_html = Mustache.to_html(html, data);
                tmpl_html = tmpl_html.replace('[trk_tracking_pixel]', '');
                return tmpl_html;
            };

            function htmlDecode(input) {
                let doc = new DOMParser().parseFromString(input, "text/html");
                return doc.documentElement.textContent;
            }
        });
    </script>


@endsection
