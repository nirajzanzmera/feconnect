@extends('fe.layouts.app')
@section('content')
<div>
    <h1 class="page-heading">Newsletter</h1>
</div>
@include('fe.campaigns._nav')
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
                        <h4 class="card-title">{{ $newsletter->name }} - Newsletter Preview</h4>
                        <p class="card-subtitle"></p>
                    </div>
                    <div class="media-right media-middle">
                        <a href="{{ route('newsletters.index') }}" class="btn btn-default"><< Back</a>
                    </div>
                </div>
            </div>
            @include('layouts.partials._preview', ['model'=>$newsletter->id,'route_name'=>'newsletter.iframe'])
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
$(document).ready(function(){
    
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
            url: '{{ route('feeds.store', ['ajax'=>true]) }}',
            data: {
                url: feed_url
            },
/*            dataType: "json",*/
            success: function(data) {
                window.location = newsletter_url + data.feed_id;
            },
            error: function(xhr, text_status) {
                var data = JSON.parse(xhr.responseText);
                alert(data.errors.url);
            },
        })
    });


    $('#create_newsletter').click(function(e){
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: '{{ route('newsletters.store', ['ajax'=>true]) }}',
            data: {
                name: '',
                template_id: '',
                feed_id: '',
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
