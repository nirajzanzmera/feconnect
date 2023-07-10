@section('css')
<link rel="stylesheet" href="https://src.dzr.io/connect/4/examples/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="https://src.dzr.io/connect/4/examples/css/bootstrap-timepicker.min.css">

@endsection
@if($errors->count() > 0)
<div class="alert alert-danger">
    @foreach ($errors->all() as $error)
    <div>{{ $error }}</div>
    @endforeach
</div>
@endif

<div id="app" v-on:change="stuffChanged()">
    <div class="row">
        <div class="col-md-6">
            <fieldset class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                <label for="title" class="post">Title</label>
                <input v-model="site_data.post.title" type="text" class="form-control" id="title" name="title"
                    placeholder="Enter title">
                @if ($errors->has('title'))
                <span class="help-block">
                    <strong>{{ $errors->first('title') }}</strong>
                </span>
                @endif
            </fieldset>
            <fieldset class="form-group">
                <label for="image" class="">Featured Image</label>
                <standalone v-on:standalone="standalone" v-on:close="showFile = false;" name="image"
                    search_url="{{ route('content.images.search') }}" 
                    downup_url="{{ route('content.downUp') }}" 
                    imagelist_url="{{ route('content.images.list') }}" 
                    filelist_url="{{ route('content.images.list', ['show_files'=>true]) }}" 
                    event_url="{{ route('images.event') }}"
                    folder="{{ $folder }}" sig="{{ $sig }}" 
                    image="{{ $post->image ?? ''}}">
                </standalone>
            </fieldset>

            @include('fe.websites._template_btns')

        </div>

        <div class="col-md-6">
            <div class="row form-group">
                <div class="col-lg-2">
                    <label>Publish Date:</label>
                </div>
                <div class="col-lg-4">
                    <input id="datepicker" name="publish_date" class=" form-control" type="text"
                        value="{{ old('publish_date', !empty($post->publish_date) ? $post->publish_date : NULL ) }}"
                        autocomplete="nope">
                </div>
                <div class="col-lg-2">
                    <label>Publish Time:</label>
                </div>
                <div class="col-lg-4">
                    <div class="input-group">
                        <input name="publish_time" id="timepicker" type="text" class="form-control"
                            value="{{ old('publish_time', !empty($post->publish_time) ? $post->publish_time : NULL ) }}"
                            autocomplete="off">
                        <span class="input-group-addon">{{ auth()->user()->currentTeam->send_timezone }}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <fieldset class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                        <label for="category">Category</label>
                        <a v-if="!category" href="" v-on:click.prevent="category = true" class="btn btn-xs btn-success pull-right">
                            <i class="fa fa-plus"></i>
                            Create New
                        </a>
                        <a v-if="category" href="" v-on:click.prevent="category = false" class="btn btn-xs btn-default pull-right" v-cloak>
                            <i class="fa fa-times"></i>
                            cancel
                        </a>
                        <input type="text" class="form-control" name="category" v-if="category" placeholder="Enter a Category" v-cloak>
                        <select name="category" id="category" class="form-control" v-if="!category">
                            <option value=""></option>
                            @foreach($categories as $cat)
                            @if( old('category', 
                                (!empty($post) && !empty($post->categories()->first())) ? $post->categories()->first()->name : '') == $cat->name )
                            <option value="{{ $cat->name }}" selected>{{ ucwords($cat->name) }}</option>
                            @else
                            <option value="{{ $cat->name }}">{{ ucwords($cat->name) }}</option>
                            @endif
                            @endforeach
                        </select>
                        @if ($errors->has('category'))
                        <span class="help-block">
                            <strong>{{ $errors->first('category') }}</strong>
                        </span>
                        @endif
                    </fieldset>
                </div>
                <div class="col-md-6">
                    <fieldset class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                            @foreach(['live','draft','archived'] as $val)
                            @if( old('status', !empty($post->status) ? $post->status : 'live') == $val )
                            <option value="{{ $val }}" selected>{{ ucwords($val) }}</option>
                            @else
                            <option value="{{ $val }}">{{ ucwords($val) }}</option>
                            @endif
                            @endforeach
                            {{-- <option value="hide">DELETE</option> --}}
                        </select>
                        @if ($errors->has('status'))
                        <span class="help-block">
                            <strong>{{ $errors->first('status') }}</strong>
                        </span>
                        @endif
                    </fieldset>
                </div>
            </div>
        </div>
    </div>

    @include('websites._tabs')

</div>

@section('js')

<script>
    var TemplateUrl = '{{ route('templates.show', $website->template_id) }}';
    var WebsiteDataUrl = '{!! route('websites.data', ['website'=>$website->id, 'post'=>!empty($post->id) ? $post->id : '', 'template' =>
        !empty($template->id) ? $template->id : '' ]) !!}';
    @include('websites._templates')

    function setDirty(data) {
        //do stuff   
    }
</script>
<script src="{{ mix('/stuff/post_page.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js"></script>
<script src="https://src.dzr.io/connect/4/assets/vendor/bootstrap-datepicker.min.js"></script>
<script src="https://src.dzr.io/connect/4/assets/vendor/bootstrap-timepicker.js"></script>

@include('websites._tiny5')
@include('websites._ace')

<script type="text/javascript">
    $(document).ready(function(){
        

        $('#submit_btn').on('click', function(e){
            e.preventDefault();
            window.dirty = false;
            $('#submit_btn').attr("disabled", true);
            $('#post_form').submit();
        });


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
    $('#datepicker').plusDatePicker();
    $('#timepicker').plusTimePicker({
        minuteStep: 5,
        showInputs: false,
        disableFocus: true
    });

    $('#content').on('change', function(){
        vue_app.site_data.post.content = $(this).val();
        render_preview();
    });
    $('#featured_image').on('change', function(){
        vue_app.site_data.post.image = $(this).val();
        render_preview();
    });
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
    var myTab = '';
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        switch(e.target.name) {
            case 'simple':
                var html = editor.getValue();
                /*var tmpl_html = render_html(html);*/
                tinymce.get('body').setContent(html);
                myTab = 'simple';
                break;
            case 'code':   
                var html = tinymce.get('body').getContent();
                editor.setValue(html);
                /*var tmpl_html = render_html(html);*/
                myTab = 'code';
                break;
            case 'preview':
                if(myTab == 'code') {
                    var content = editor.getValue();
                    tinymce.get('body').setContent(content);
                } else {
                    var content = tinymce.get('body').getContent();
                    editor.setValue(content);
                }
                $('#content').change();

                //get template
                render_preview();
               /* var tmpl_html = render_html(html);*/
                myTab = 'preview';
                break;
            default:
                //nuthin
        }
    }); 
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    function render_preview(){
        $.post('{{ route('website.preview', $website) }}', {data: JSON.stringify(vue_app.site_data), type: 'post'}, function(data){
            
            $('#return').html("<iframe id="+'"preview-iframe"'+" name="+'"preview-iframe"'+" class='embed-responsive-item' style='border: 1px solid #ddd;' src=" +
            "data:text/html;charset=utf-8," + encodeURIComponent(data.html) +
            "></iframe>");
        });
    }

});
</script>


@endsection
