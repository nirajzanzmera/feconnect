<style>
    .embed-responsive iframe {
        margin: auto;
    }
</style>
<label class="lead">Message</label>


<div class="card">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" href="#simple" name="simple" data-toggle="tab">Simple</a>
        </li>
        
        <li class="nav-item">
            
            <a href="#" class="nav-link" id="code_btn">&lt; /&gt; Code</a>
               
        </li>
       
        <li class="nav-item">
            <a class="nav-link" href="#preview" name="preview" data-toggle="tab">Previews</a>
        </li>

    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="simple">
            <textarea name="html" id="html">{{ !empty($html) ? $html : '' }}</textarea>
        </div>
        <div class="tab-pane" id="code">
            <div id="editor"></div>
            <textarea name="editor">{{ !empty($html) ? $html : '' }}</textarea>
        </div>
        <div class="tab-pane" id="preview">
            <div class="card-block">
                <div class="btn-group pull-right">
                    <a class="btn btn-default" href="#" id="mobile" title="mobile"><i
                            class="sidebar-menu-icon material-icons">smartphone</i></a>
                    <a class="btn btn-default active" href="#" id="desktop" title="desktop"><i
                            class="sidebar-menu-icon material-icons">desktop_mac</i></a>
                </div>
            </div>
            <div class="card-block">
                <div class="embed-responsive embed-responsive-4by3">
                    <div id="return"></div>
                </div>
            </div>
        </div>
    </div>
</div>



<textarea name="rendered_html" id="rendered_html" style="width: 1px; height: 1px; opacity:0.0"></textarea>

@section('js')
<script src="//cloud9ide.github.io/emmet-core/emmet.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/ace/1.2.8/ace.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/ace/1.2.8/ext-emmet.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/ace/1.2.8/ext-beautify.js" type="text/javascript"></script>




    <script src="https://cdn.tiny.cloud/1/aegf2fqf84iwno2lab9tv20w19scgxf6v6rcxkzqf180rigs/tinymce/5/tinymce.min.js"></script>


<link rel="stylesheet" href="https://src.dzr.io/connect/4/examples/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="https://src.dzr.io/connect/4/examples/css/bootstrap-timepicker.min.css">
<script src="https://src.dzr.io/connect/4/assets/vendor/bootstrap-datepicker.min.js"></script>
<script src="https://src.dzr.io/connect/4/assets/vendor/bootstrap-timepicker.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js"></script>


<script type="text/javascript">
    $(document).ready(function(){

        $('#code_btn').on('click', function(e){
            e.preventDefault();
            zE.hide();
            javascript:tinymce.activeEditor.execCommand('mceCodeEditor');
        });

		$('#loadTemplate').on('click', function(){
			var myVal = $('#template').val();
			if(myVal != '') {
				$.getJSON( '{{ route('templates.index') }}/' + myVal+ '/show'  , function( data ) {
					var html = data.html;
					$('[name="editor"]').val(html);
					editor.setValue(html);
					tinymce.get('html').setContent(html);
				});
			}
		});
		var myTab = '';
		$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
			switch(e.target.name) {
				case 'simple':
					var html = editor.getValue(html);
                    var tmpl_html = render_html(html);
                    tinymce.get('html').setContent(html);
                    myTab = 'simple';
                    break;
                case 'code':
                    if (tinyMCE.activeEditor.isDirty()) {
                        var html = tinymce.get('html').getContent();
                        editor.setValue(html);
                        var tmpl_html = render_html(html);
                        myTab = 'code';
                    }
                    break;
                case 'preview':
                    var html = tinymce.get('html').getContent();
                    editor.setValue(html);
                    var tmpl_html = render_html(html);
                    tmpl_html = tmpl_html.replace('[trk_tracking_pixel]', '');
					$('#return').html("<iframe id="+'"preview-iframe"'+" name="+'"preview-iframe"'+" class='embed-responsive-item' style='border: 1px solid #ddd;' src=" +
					"data:text/html;charset=utf-8," + encodeURIComponent(tmpl_html) +
					"></iframe>");
                    myTab = 'preview';
                    break;
                default:
                    //nuthin
            }
        });
        function render_html(html) {
            var sender_id = $('#sender_id').val();
            var data = {
                news: {!! !empty($news) ? json_encode($news) : '[]' !!},
            };
            $.ajax({
                url: '{{ route('senders.json')}}/' + sender_id,
                async: false,
                dataType: 'json',
                success: function (json) {
                    data.sender = json;
                }
            });
            var tmpl_html = linker(Mustache.to_html(html, data));
            $('#rendered_html').val(tmpl_html);
            return tmpl_html;
        }
        function linker(str) {
            const a_tag = /<a (.*)>/g;
            return str.replace(a_tag, '<a target="_blank" $1>');
        }
        
        var editor_config = {
            
            selector: "#html",
            height: "520",

            branding: false,
            menubar: 'edit insert format table',
            menu: {
                edit: {title: 'Edit', items: 'undo redo | cut copy paste pastetext | selectall'},
                insert: {title: 'Insert', items: 'link | image '},
                format: {title: 'Format', items: 'bold italic underline strikethrough superscript subscript | formats | removeformat'},
                table: {title: 'Table', items: 'inserttable tableprops deletetable | cell row column'},
            },

			toolbar: " undo redo | fontselect | forecolor | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
           
           /*  font_formats: 'Arial=arial,helvetica,sans-serif;Courier New=courier new,courier,monospace;Times New Roman=Times New Roman,Times,serif', */
            
            fontsize_formats: "8pt 10pt 11pt 12pt 14pt 18pt 24pt 36pt",
            

            protect: [
                /\<\/?(if|endif)\>/g, // Protect <if> & </endif>
                ],
                plugins: [
                    "fullpage",
                    "noneditable",
                    "advlist lists link image charmap print preview anchor",
                    "searchreplace visualblocks code",
                    "insertdatetime table contextmenu paste ",
                    "textcolor",
                    "advcode",
                    "tinymcespellchecker",
                    
                ],
                convert_urls: false,
                default_link_target: "_blank",
                setup:function(ed) {
                    ed.on('change', function(e) {
                        setDirty();
                        render_html( ed.getContent() );
                    });
                    ed.on('init', function(e){
                        render_html( ed.getContent() );
                        @if( !empty($news) && Route::currentRouteName() != 'newsletters.edit')
                        var render = render_html( $('#html').val());
                        ed.setContent(render);
                        var html = ed.getContent();
                        editor.setValue(html);
                        $('#html').val(html);
                        @endif
                    });
                },
                path_absolute: '/',
                file_browser_callback : function(field_name, url, type, win) {
                    var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                    var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;
                    
                    var cmsURL = '{{ route('content.index') }}?context=selector&amp;type=window&amp;field_name=' + field_name;
                    
                    tinyMCE.activeEditor.windowManager.open({
                        file : cmsURL,
                        title : 'Filemanager',
                        width : x * 0.5,
                        height : y * 0.8,
                        resizable : "yes",
                        close_previous : "no"
                    }, {
                        window : win,
                        input : field_name
                    });
                    return false;
                },
                
                
                    toolbar_mode: "floating",
                    mobile: {
                        menubar: 'edit insert format table',
                        toolbar_mode: "floating",
                    },
                    file_picker_callback: function(callback, value, meta) {
                        var instanceApi = tinymce.activeEditor.windowManager.openUrl({
                            title: 'Filemanager',
                            url: '{{ route('content.index') }}?context=selector&type=window&field_name=' + this.field_name,
                            onMessage: function(dialogApi, details) {
                                console.log(details);
                                callback(details.content);
                                instanceApi.close();
                            }
                        });
                    },
                

            }; //end tinymce
            tinymce.init(editor_config);
            
            function setDirty(data) {
                $('#rendered_html').addClass('dirty');
                $('.schedule-btn').addClass('disabled');
                $('.spam-btn').addClass('disabled');
                $('.send-btn').addClass('disabled');
            }
            
            $('[name="editor"]').hide();
		var beautify = ace.require("ace/ext/beautify");
		var editor = ace.edit("editor");

		var myCode = $('[name="editor"]').val();
		editor.getSession().setValue(myCode);
		editor.setTheme("ace/theme/monokai");
		editor.session.setMode("ace/mode/html");
		editor.setOptions({
			"enableEmmet": true,
			wrap: true,
			maxLines: 39,
			minLines: 39,
		});
		editor.on('blur', function(){
			var data = editor.getValue();
			tinymce.get('html').setContent(data);
		})
        editor.on("input", function() {
            // input is async event, which fires after any change events
            var isClean = editor.session.getUndoManager().isClean();
            if(!isClean) {
                setDirty()
            }
        })
		/* end editor */

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

       
        @if( !empty($news) && Route::currentRouteName() != 'newsletters.edit')
            var render = render_html( $('#html').val());
            $('#html').val(render);
            editor.setValue(render);
        @else 
            render_html( editor.getValue(html) );
        @endif

	});
</script>
@endsection {{-- end JS section  --}}