<div class="card">
    <div class="card-header">
        <div class="media">
            <div class="media-body media-middle">
                <h4 class="card-title">
                Preview
                </h4>
            </div>
        </div>
    </div>
    <div class="card-block card-block-light">
        <div class="btn-group pull-right">
            <a class="btn btn-default" href="#" id="mobile" title="mobile"><i class="sidebar-menu-icon material-icons">smartphone</i></a>
            <a class="btn btn-default active" href="#" id="desktop" title="desktop"><i class="sidebar-menu-icon material-icons">desktop_mac</i></a>
            <a class="btn btn-default" href="#" id="code" title="code"><i class="sidebar-menu-icon material-icons">code</i></a>
        </div>
        <div style="margin-top: 40px;">
            <div id="embed" class="embed-responsive embed-responsive-4by3">
                <div id="return">
                    <div id="loading" class="alert alert-info">
                        <i class="fa fa-spinner fa-spin"></i>
                        Loading...
                    </div>
                    <iframe id="preview-iframe" class="embed-responsive-item" style="border: 1px solid #ddd;" src="{{ route($route_name, $model) }}">
                    </iframe>
                </div>
                <div id="code_div" style="display:none"><pre id="html_code">{{ isset($html) ? $html : '' }}</pre></div>
            </div>
        </div>
    </div>
</div>


@section('js2')
<script type="text/javascript">
$(document).ready(function(){
    $('#preview-iframe').load(function(){
        $('#loading').hide();
    });

    $('#mobile').click( function(e) {
        e.preventDefault();
        $(this).addClass('active');
        $('#desktop').removeClass('active');
        $('#code').removeClass('active');
        $('#return').show();
        $('#preview-iframe').animate({ width: "375px" });
        $("#embed").addClass('embed-responsive embed-responsive-4by3');
        $('#code_div').hide();
    });
    $('#desktop').click( function(e) {
        e.preventDefault();
        $(this).addClass('active');
        $('#mobile').removeClass('active');
        $('#code').removeClass('active');
        $('#return').show();
        $('#preview-iframe').animate({ width: "100%" });
        $("#embed").addClass('embed-responsive embed-responsive-4by3');
        $('#code_div').hide();
    });
    $('#code').click( function(e) {
        e.preventDefault();
        //id="embed" class="">
        $(this).addClass('active');
        $('#desktop').removeClass('active');
        $('#mobile').removeClass('active');
        $('#preview-iframe').animate({ width: "100%" });
        $('#return').hide();
        $("#embed").removeClass('embed-responsive embed-responsive-4by3');
        $('#code_div').show();
    });    
});
</script>
@endsection
