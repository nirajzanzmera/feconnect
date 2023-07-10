@extends('layouts.app')
@section('content')
<div>
    <h1 class="page-heading">Newsletter</h1>
</div>
{{-- <ol class="breadcrumb">
    <li><a href="{{ route('homebc') }}">Home</a></li>
    <li><a href="{{ route('newsletters.index') }}">Newsletter</a></li>
</ol> --}}
@include('campaigns._nav')
@if($errors->count() > 0)
<div class="alert alert-danger">
    @foreach ($errors->all() as $error)
        <div>{{ $error }}</div>
    @endforeach
</div>
@endif
<div class="row-fluid">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="media">
                    <div class="media-body">
                        <h4 class="card-title">Newsletters</h4>
                        <p class="card-subtitle">Create newsletter using a template and your posts.</p>
                    </div>
                    <div class="media-right media-middle">
                        
                    </div>
                </div>
            </div>
            <div class="card-block">
                <div class="row">
                    <div class="col-md-4">
                        <a class="h2 pull-left" style="padding:0 15px;" href="{{ route('newsletters.create')}}">
                            <i class="fa fa-angle-double-left m-48"></i>
                        </a>
                        <h4 class="card-title">Step 2</h4>
                        <p class="card-subtitle">Preview Template with a Feed from your site.</p>
                    </div>
                    <div class="col-md-4">
                        <h4 class="card-title">
                            Select Feed
                            <a href="#" class="btn btn-xs btn-success pull-right" id="add_feed_switch">
                                <i class="fa fa-plus"></i>
                                Add New Feed
                            </a>
                            <a href="#" class="btn btn-xs btn-warning pull-right hide" id="remove_feed_switch">
                                <i class="fa fa-times"></i>
                                Cancel
                            </a>
                        </h4>
                        
                        <div id="feed_drop">
                            <select class="form-control" id="feed_select">
                                <option></option>
                                @foreach ($feeds as $feed_drop) 
                                    <option data-type="{{ isset($feed_drop['token']) ? 'website' : 'feed' }}" 
                                     value="{{ $feed_drop['id'] }}" {{ 
                                        ( 
                                            isset($feed_drop['token']) 
                                            && isset($feed->token) 
                                            && !empty($feed->id) 
                                            && $feed_drop['id'] == $feed->id
                                        ) || 
                                        ( 
                                            !isset($feed_drop['token']) 
                                            && !isset($feed->token) 
                                            && !empty($feed->id) 
                                            && $feed_drop['id'] == $feed->id
                                        )
                                         ? ' selected' : '' }}>
                                        {{ isset($feed_drop['token']) ? 'Website: ' : 'Feed: ' }}
                                        {{ !empty($feed_drop['name']) ? $feed_drop['name'] : $feed_drop['url'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div id="feed_form" class="hide">
                            <div class="input-group">
                                <input type="text" class="form-control" id="feed_url" placeholder="http://example.com">
                                <span class="input-group-btn">
                                    <button id="add_new_feed" class="btn btn-success loading" type="button">Add</button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h4 class="card-title">
                            Step 3 : Create Newsletter
                        </h4>
                        <a id="create_newsletter" href="#" class="btn btn-success pull-right {{ empty($feed->id) ? 'disabled' : '' }}">
                            <i class="fa fa-plus"></i>
                            Create Newsletter
                        </a>
                    </div>
                </div>
            </div>
           
            @include('layouts.partials._preview', ['model'=> $template , 'route_name'=>'newsletter.iframe'])
            
        </div>
    </div>
</div>
@endsection


@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    var tmpl_html = render_html(`{!! preg_replace('/\s\s+/', ' ',  $html) !!}`);
    $('#return').html("<iframe id="+'"preview-iframe"'+" class='embed-responsive-item' style='bordter: 1px solid #ddd;' src=" +
        "data:text/html;charset=utf-8," + encodeURIComponent(tmpl_html) +
        "></iframe>");
    $('#code_div').hide();
    $('#mobile').click( function(e) {
        e.preventDefault();
        $(this).addClass('active');
        $('#desktop').removeClass('active');
        $('#code').removeClass('active');
        $('#preview-iframe').animate({ width: "375px" });
        $('#code_div').hide();
        $("#embed").addClass('embed-responsive embed-responsive-4by3');
        $('#return').show();
    });
    $('#desktop').click( function(e) {
        e.preventDefault();
        $(this).addClass('active');
        $('#mobile').removeClass('active');
        $('#code').removeClass('active');
        $('#preview-iframe').animate({ width: "100%" });
        $('#code_div').hide();
        $("#embed").addClass('embed-responsive embed-responsive-4by3');
        $('#return').show();
    });

    $('#code').click( function(e) {
        e.preventDefault();
        $(this).addClass('active');
        $('#desktop').removeClass('active');
        $('#mobile').removeClass('active');
        $('#preview-iframe').animate({ width: "100%" });
        $('#return').hide();
        $("#embed").removeClass('embed-responsive embed-responsive-4by3');
        $('#code_div').show();
    });

    function render_html(html) {
        var sender_id = {{ !empty($sender->id) ? $sender->id : 0 }};
        var data = {
            news: {!! json_encode($news) !!},
            sender: {!! json_encode($sender) !!}
        };

        var tmpl_html = Mustache.to_html(html, data);
        tmpl_html = tmpl_html.replace('[trk_tracking_pixel]', '');
        return tmpl_html;
    }


    $('#feed_select').on('change', function(){
        var myVal = this.value;
        var type = $(this).find(':selected').data('type'); //$(this).data('type');
        if(type == 'website') {
            var newsletter_url = "{{ route('newsletters.create.website.preview', ['template_id'=>$template->id]) }}/"
        } else {
            var newsletter_url = "{{ route('newsletters.create.feed.preview', ['template_id'=>$template->id]) }}/"
        }
        $('#feed_drop').html('<i class="fa fa-spinner fa-pulse"></i> loading...');
        window.location = newsletter_url + myVal;            
    });


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#add_new_feed').click(function(e){
        e.preventDefault();
        var feed_url = $('#feed_url').val();
        $.ajax({
            type: "POST",
            url: '{{ route('feeds.store', ['ajax'=>'true']) }}',
            data: {
                url: feed_url
            },
            success: function(data) {
                console.log(data);
                window.location = '{{ route('newsletters.create.preview', $template) }}/feed/' + data.feed_id;
            },
            error: function(xhr, text_status) {
                var data = JSON.parse(xhr.responseText);
                alert(data.errors.url);
            },
        })
    });
/**/


    $('.loading').on('click', function(){
        $(this).addClass('disabled');
        $(this).html('<i class="fa fa-spinner fa-pulse"></i> loading...');
    });

    $('#create_newsletter').click(function(e){
        e.preventDefault();
        $(this).addClass('disabled');
        $('#create_newsletter').html('<i class="fa fa-spinner fa-pulse"></i> loading...');
        $.ajax({
            type: "POST",
            url: '{{ route('newsletters.store', ['ajax'=>true]) }}',
            data: {
                name: '{{ isset($news->title) ? $news->title : "" }}',
                template_id: '{{ isset($template->id) ? $template->id : "" }}',
                @if(isset($feed->token) && !empty($feed->id) )
                website_id: '{{ isset($feed->id) ? $feed->id : "" }}'
                @endif
                @if(!isset($feed->token) && !empty($feed->id) )
                feed_id: '{{ isset($feed->id) ? $feed->id : "" }}',
                @endif
            },
/*            dataType: "json",*/
            success: function(data) {
                window.location = '{{ route('newsletters.index') }}';
            },
            error: function(xhr, text_status) {
                var data = JSON.parse(xhr.responseText);
                alert(data.errors.url);
            },
        })
    });


    $('#add_feed_switch').click( function(e) {
        e.preventDefault();
        toggle();
    });
    $('#remove_feed_switch').click( function(e) {
        e.preventDefault();
        toggle();
    });
    function toggle() {
        $('#add_feed_switch').toggleClass('hide');
        $('#remove_feed_switch').toggleClass('hide');
        $('#feed_drop').toggleClass('hide');
        $('#feed_form').toggleClass('hide');
    }
  
});//end

</script>
@endsection
