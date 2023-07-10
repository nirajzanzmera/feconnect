{{-- <script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=aegf2fqf84iwno2lab9tv20w19scgxf6v6rcxkzqf180rigs"></script> --}}
{{--
//https://www.youtube.com/embed/SCRlAide8xU
//https://www.youtube.com/watch?v=SCRlAide8xU
//https://youtu.be/SCRlAide8xU
--}}

<script src="https://src.dzr.io/tinymce/4.9.3/tinymce.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
   
    @if(strpos(Route::currentRouteName(), 'websites.pages') !==false )
    tinymce.PluginManager.add('inserter', function(editor, url) {
        // Add a button that opens a window
        editor.addButton('contact', {
            text: 'Contact Form',
            tooltip: 'Insert Contact Form',
            icon: 'code',
            onclick: function() {
                editor.insertContent('@{{{ contact_form }}}');
            }
        });

        // Adds a menu item to the tools menu
        editor.addMenuItem('contact', {
            text: 'Contact Form',
            context: 'insert',
            icon: 'code',
            onclick: function() {
                // Open window with a specific url
                editor.insertContent('@{{{ contact_form }}}');
            }
        });
    });
    @endif
    var editor_config = {
        schema: 'html5',
        body_class: 'tiny',
        content_css : '{{ asset('assets/css/tiny.css?v=1') }},https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.0/normalize.min.css,https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.4/css/bulma.min.css,https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css',
       
        protect: [
            /\<\/?(if|endif)\>/g, // Protect <if> & </endif>
        ],
        height: "520",
        selector: "#body",
        branding: false,
        menu: {
            edit: {title: 'Edit', items: 'undo redo | cut copy paste pastetext | selectall'},
            insert: {title: 'Insert', items: 'link | image | media | contact'},
            format: {title: 'Format', items: 'bold italic underline strikethrough superscript subscript | formats | removeformat'},
            table: {title: 'Table', items: 'inserttable tableprops deletetable | cell row column'},
            /*tools: {title: 'Code', items: 'code'}*/
        },
        plugins: [
            @if(strpos(Route::currentRouteName(), 'websites.pages') !==false )"inserter",@endif
            "noneditable",
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code",
            "insertdatetime media table contextmenu paste ",
            "media image textcolor",
            "spellchecker",
        ],
        convert_urls: false,
        default_link_target: "_blank",
        toolbar: " undo redo | fontselect | forecolor | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | image media | contact ",
        
        fontsize_formats: "8pt 10pt 11pt 12pt 14pt 18pt 24pt 36pt",
        path_absolute: '/',
        valid_children : "+body[style]",
        media_url_resolver: function (data, resolve) {
            var url = data.url;
            var parseQueryString = function( queryString ) {
                var params = {}, queries, temp, i, l;
                // Split into key/value pairs
                queries = queryString.split("&");
                // Convert the array of strings into an object
                for ( i = 0, l = queries.length; i < l; i++ ) {
                    temp = queries[i].split('=');
                    params[temp[0]] = temp[1];
                }
                return params;
            };

            if (url.indexOf('youtube.com/watch') !== -1 ) {
                var queryString = url.split("?")[1];
                var video = parseQueryString(queryString)['v'];
                url = 'https://www.youtube.com/embed/'+ video +'?rel=0';
            }

            if(url.indexOf('youtu.be') !== -1 ) {
                var video = url.split('/');
                video = video.slice(-1)[0];
                url = 'https://www.youtube.com/embed/'+ video +'?rel=0';
            }

            var embedHtml = '<div style="position: relative; width: 100%; height: 0; padding-bottom: 56.25%;"><iframe style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" src="'
            + url + '" frameborder="0" allowfullscreen="allowfullscreen"></iframe></div>'
            resolve({html: embedHtml});
            
            // resolve({html: ''});
           
        },

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
        
        setup:function(ed) {
            ed.on('change', function(e) {
                var x = document.getElementById("content");
                x.value = ed.getContent(); 
                
                vue_app.site_data.post.content = ed.getContent();
            });
        },
    }; //end tinymce
    tinymce.init(editor_config);
       


});
</script>
