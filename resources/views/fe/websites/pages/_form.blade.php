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
            <fieldset class="form-group " id="title_group">
                <label for="title" class="post">Title</label>
                @if(isset($page) && $page->type == 'permanent')
                <input v-model="site_data.post.title" type="text" class="form-control disabled" name="title"
                    title="This is a special page, and the title is not adjustable" disabled>
                @else
                <input v-model="site_data.post.title" type="text" class="form-control" id="title" name="title"
                    placeholder="Enter title">
                <span class="help-block">
                    <strong class="title_error"></strong>
                </span>
                @endif
            </fieldset>
            <fieldset class="form-group">
                <label for="image" class="">Featured Image</label>
                <standalone v-on:standalone="standalone" v-on:close="showFile = false;" name="image"
                    search_url="{{ route('content.images.search') }}" downup_url="{{ route('content.downUp') }}"
                    imagelist_url="{{ route('content.images.list') }}"
                    icon_url="{{ route('content.flaticon.search') }}"
                    filelist_url="{{ route('content.images.list', ['show_files'=>true]) }}"
                    event_url="{{ route('images.event') }}" folder="{{ $folder }}" sig="{{ $sig }}"
                    image="{{ $page->image ?? '' }}"
                    icon="icon"
                    >
                </standalone>
            </fieldset>

            @include('fe.websites._template_btns')

        </div>
        <div class="col-md-6">
            <fieldset class="form-group">
                <div class="form-check">
                    <input v-model="site_data.post.include_posts" @change="includePosts($event)" type="checkbox"
                        class="form-check-input" name="include_posts" value="1">
                    <label class="form-check-label" for="include_posts">Include Posts</label>
                </div>
                <div v-if="site_data.post.include_posts">
                    <em>Filter Posts by Category</em>
                    <select name="post_category" id="category" class="form-control">
                        <option value="">All Posts</option>
                        @foreach($categories ?? [] as $cat)
                        @if( old('post_category',
                        (!empty($page->post_category)) ? $page->post_category : '') == $cat->id )
                        <option value="{{ $cat->id }}" selected>{{ ucwords($cat->name) }}</option>
                        @else
                        <option value="{{ $cat->id }}">{{ ucwords($cat->name) }}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
            </fieldset>
            <fieldset class="form-group {{ $errors->has('menu') ? ' has-error' : '' }}">
                <label for="headline" class="post">Select Menu(s) to add {{ $type }} to:</label>
                @foreach($website->menus ?? [] as $menu)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="menu[]" value="{{ $menu->id }}"
                        id="menu_{{ $menu->id }}"
                        {{ ( !empty($page) && !empty($page->menus->where('id', $menu->id)->first())) || ( !empty($menu_id) && $menu_id == $menu->id)  ? ' checked' : '' }}>
                    <label class="form-check-label" for="menu_{{ $menu->id }}">
                        {{ $menu->name }}
                    </label>
                </div>
                @endforeach
            </fieldset>
            <fieldset class="form-group{{ $errors->has('start_time') ? ' has-error' : '' }}">
                <label for="start_time">Publish Date</label>
                <input type="text" class="form-control" id="start_time" name="start_time" placeholder=""
                    value="{{ old('start_time', !empty($page->start_time) ? $page->start_time : date('Y-m-d') ) }}"
                    autocomplete="nope">
                @if ($errors->has('start_time'))
                <span class="help-block">
                    <strong>{{ $errors->first('start_time') }}</strong>
                </span>
                @endif
            </fieldset>
            @if(isset($page) &&( $page->type == 'index' || $page->type == 'permanent'))
            <fieldset class="form-group">
                <label for="status">Status</label>
                <div class="alert alert-info">
                    {{ $page->type == 'index' ? 'The Index page of your website' : 'This confirmation page' }}
                    cannot be deleted or archived.
                </div>
            </fieldset>
            @else
            <fieldset class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control">
                    @foreach(['live','draft','archived'] as $val)
                    @if( old('status', !empty($page->status) ? $page->status : 'live') == $val )
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
            @endif
        </div>
    </div>


    @include('websites._tabs')

    <div class="title_error alert alert-danger" style="display:none;">

    </div>

</div>

@section('js')
<script>
    var TemplateUrl = '{{ route('templates.show', $website->template_id) }}';
    var WebsiteDataUrl = '{!! route('websites.data', ['website'=>$website->id, 'page'=>!empty($page->id) ? $page->id : '', 'template' => !empty($template->id) ? $template->id : '' ]) !!}';
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
            var title = $('#title').val();
            if (title == '') {
                $('.title_error').html('The Title field is required');
                $('.title_error').show();
            } else {
                window.dirty = false;
                $('#submit_btn').attr("disabled", true);
                $('.title_error').hide();
                // $('#page_form').submit();

                var form = $('#page_form');
                var action_url = form.attr('action');

                var data = form.serializeArray().reduce(function(obj, item) {
                    obj[item.name] = item.value;
                    return obj;
                }, {});

                $.ajax({
                    type: 'POST',
                    url: action_url,
                    data: data,
                    success: function(result) {
                        if (result.data.page) {
                            location.href = "{{route('websites.pages.index', $website->id)}}/"+ result.data.page.id + '/edit';
                        }
                        $('#submit_btn').removeAttr("disabled");
                    },
                    errror: e => {
                        $('#submit_btn').removeAttr("disabled");
                        console.log(e)
                    }
                });
            }
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
        $.post('{{ route('website.preview', $website->id) }}', {data: JSON.stringify(vue_app.site_data), type: 'page'}, function(data){
            $('#return').html("<iframe id="+'"preview-iframe"'+" name="+'"preview-iframe"'+" class='embed-responsive-item' style='border: 1px solid #ddd;' src=" +
            "data:text/html;charset=utf-8," + encodeURIComponent(data.html) +
            "></iframe>");
        });
    }
});
</script>

@endsection