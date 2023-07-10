@extends('layouts.app')
@section('content')
<div>
    <a href="{{route('campaigns.index')}}" class="btn btn-default btn-sm pull-right" style="margin-top: 22px;">
        <i class="fa fa-arrow-left"></i> Back
    </a>
    <h1 class="page-heading">Email Blasts - Preview</h1>
</div>
<ol class="breadcrumb">
    <li><a href="{{ route('homebc') }}">Home</a></li>
    <li><a href="{{ route('campaigns.index') }}">Email Blasts</a></li>
    <li class="active">Preview</li>
</ol>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-block">
                <div class="row">
                    <div class="col-md-12">
                        <div class="pull-right">
                            <strong>DATE:</strong> {{ $campaign->send_date }}<br />
                            <strong>TIME:</strong> {{ $campaign->send_time }} {{ Auth::user()->currentTeam->send_timezone }}<br />
                        </div>
                        <strong>TO:</strong> {{ isset($campaign->list->name) ? $campaign->list->name : ''  }}<br />
                        <strong>FROM:</strong> {{ isset($campaign->sender->email) ? $campaign->sender->email : ''  }}<br />
                        <strong>SUBJECT:</strong> {{ $campaign->subject }}<br />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        @if(!empty($campaign) && $external == false)
        <div class="card card-info">
            <div class="card-block">
                <div class="input-group">
                    <input type="email" class="form-control ignore-me" id="test_email" placeholder="email address">
                    <span class="input-group-btn">
                        <button class="btn btn-sm btn-success send-btn" type="button" id="send_test_email"><i class="material-icons">mail</i> Send Test</button>
                    </span>
                </div>
                <div class="alert alert-success" id="test_email_message_block">
                    <strong id="test_email_message">message</strong>
                </div>
                <hr >
            </div>
            <div class="card-block">
                <div class="btn-group">
                    
                <a href="" class="btn btn-primary" id="print">
                    <i class="fa fa-print"></i>
                    Print ...
                </a>
                
                <div class="btn-group">
                    <div class="dropdown show">
                        <a class="btn btn-default dropdown-toggle" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-file"></i> Save As...
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">

                            <a class="dropdown-item" href="{{ route('campaigns.saveAs', $campaign) }}"><i class="fa fa-envelope"></i> New Email</a>
                            <a class="dropdown-item" href="{{ route('templates.saveAs', $campaign) }}"><i class="fa fa-puzzle-piece"></i> New Template</a>
                        </div>
                    </div>
                </div>

                @if($campaign->complete == FALSE)
                <a href="{{ route('campaigns.publish_preview', $campaign) }}" class="btn btn-success schedule-btn">
                    <i class="fa fa-calendar"></i> Schedule
                </a>
                @endif
                </div>

            </div>
        </div>
    </div>
    @endif
</div>
@include('layouts.partials._preview', ['model'=>$id, 'route_name'=>'campaigns.iframe'])
@endsection

@section('js')
<script type="text/javascript">
$(document).ready(function(){
    $('#print').on('click', function (e) {
        e.preventDefault();
        printHTML( tmpl_html );
    });
    function printHTML(html) 
    {
      var newWin=window.open('','Print-Window');
      newWin.document.open();
      newWin.document.write('<html><body onload="window.print()">'+html+'</body></html>');
      newWin.document.close();
      setTimeout(function(){newWin.close();},10);
    }

    $('#test_email_message_block').hide();
    $('#send_test_email').on('click', function(){
        $('#test_email_message_block').hide();
        var email = $('#test_email').val();
        var data = {
            'email': email
        };
        $.ajax({
            @if(Auth::user()->currentTeam->status == 'active' && !empty($campaign))
            url: '{{ route('campaigns.send_test', !empty($campaign)?$campaign:NULL) }}',
            @else 
            url: '{{ route('campaigns.send_test_limit', !empty($campaign)?$campaign:NULL) }}',
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

});//end

</script>
@endsection
