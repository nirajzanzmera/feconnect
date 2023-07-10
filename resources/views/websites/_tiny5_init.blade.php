
    var init = {
        schema: 'html5',
        body_class: 'tiny',
        content_css : '{{ asset('assets/css/tiny.css?v=1.4') }},https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.0/normalize.min.css,https://cdnjs.cloudflare.com/ajax/libs/bulma/0.8.1/css/bulma.min.css,https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css',
        content_style: 'P {margin-bottom: 1em;}',
        protect: [
            /\<\/?(if|endif)\>/g, // Protect <if> & </endif>
        ],
        height: "520",
        selector: "#body",
        branding: false,
        menubar: 'edit insert format table tools',
        menu: {
            edit: {title: 'Edit', items: 'undo redo | cut copy paste pastetext | selectall | codeview'},
            insert: {title: 'Insert', items: 'link | image | media | contact | image_left | image_right | 2cols | 3cols'},
            format: {title: 'Format', items: 'bold italic underline strikethrough superscript subscript | formats | removeformat'},
            table: {title: 'Table', items: 'inserttable tableprops deletetable | cell row column'},
            tools: {title: 'Edit Code', items: 'codeview'}, 
        },
        plugins: [
            @if(strpos(Route::currentRouteName(), 'websites.pages') !==false )"inserter",@endif
            "noneditable",
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks",
            "insertdatetime media table contextmenu paste ",
            "media image textcolor",
            "tinymcespellchecker",
            "advcode"
        ],
        convert_urls: false,
        default_link_target: "_blank",
        toolbar: "undo redo | codeview | fontselect | forecolor | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | image media | contact",
        toolbar_mode: "floating",
        theme: 'silver',
        mobile: {
          menubar: 'edit insert format table',
          toolbar_mode: "floating",
        },
        fontsize_formats: "8pt 10pt 11pt 12pt 14pt 18pt 24pt 36pt",
        path_absolute: '/',
        valid_children : "+body[style]",

        language: 'en_US',
        language_url: '{{url('js/en_US.js')}}',

        media_url_resolver: function (data, resolve) {
            var url = data.url;
            var parseQueryString = function (queryString) {
                var params = {},
                    queries, temp, i, l;
                // Split into key/value pairs
                queries = queryString.split("&");
                // Convert the array of strings into an object
                for (i = 0, l = queries.length; i < l; i++) {
                    temp = queries[i].split('=');
                    params[temp[0]] = temp[1];
                }
                return params;
            };

            if (url.indexOf('youtube.com/watch') !== -1) {
                var queryString = url.split("?")[1];
                var video = parseQueryString(queryString)['v'];
                url = 'https://www.youtube.com/embed/' + video + '?rel=0';
            }

            if (url.indexOf('youtu.be') !== -1) {
                var video = url.split('/');
                video = video.slice(-1)[0];
                url = 'https://www.youtube.com/embed/' + video + '?rel=0';
            }

            var embedHtml = '<p>&nbsp;<p/><br /><div style="position: relative; width: 100%; height: 0; padding-bottom: 56.25%;"><iframe style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" src="' +
                url + '" frameborder="0" allowfullscreen="allowfullscreen"></iframe></div><br /><p>&nbsp;<p/>'
            resolve({
                html: embedHtml
            });

            // resolve({html: ''});

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
        
        setup:function(editor) {
            editor.ui.registry.addButton('codeview', {
                icon: 'sourcecode',
                onAction: function (_) {
                    zE.hide();
                    editor.execCommand('mceCodeEditor');
                }
            }),
            editor.ui.registry.addMenuItem('codeview', {
                text: 'Source Code',
                icon: 'sourcecode',
                onAction: function (_) {
                    zE.hide();
                    editor.execCommand('mceCodeEditor');
                }
            }),
            
            editor.ui.registry.addMenuItem('image_left', {
                text: 'Image Left',
                context: 'insert',
                {{-- icon: 'sourcecode', --}}
                onAction: function() {
                    editor.execCommand('mceInsertContent', false, image_left);
                }
            }),
            
            editor.ui.registry.addMenuItem('image_right', {
                text: 'Image Right',
                context: 'insert',
                {{-- icon: 'sourcecode', --}}
                onAction: function() {
                    editor.execCommand('mceInsertContent', false, image_right);
                    {{-- editor.insertContent(); --}}
                }
            }),

            editor.ui.registry.addMenuItem('2cols', {
                text: '2 Columns',
                context: 'insert',
                {{-- icon: 'sourcecode', --}}
                onAction: function() {
                    editor.execCommand('mceInsertContent', false, col_2);
                    {{-- editor.insertContent(); --}}
                }
            }),

            editor.ui.registry.addMenuItem('3cols', {
                text: '3 Columns',
                context: 'insert',
                {{-- icon: 'sourcecode', --}}
                onAction: function() {
                    editor.execCommand('mceInsertContent', false, col_3);
                    {{-- editor.insertContent(); --}}
                }
            }),

        @if(strpos(Route::currentRouteName(), 'websites.pages') !==false )
            window.tinymce.PluginManager.add('inserter', function(editor, url) {
                // Add a button that opens a window
                editor.ui.registry.addButton('contact', {
                    text: 'Contact Form',
                    tooltip: 'Insert Contact Form',
                    {{-- icon: 'sourcecode', --}}
                    onAction: function() {
                        editor.insertContent('@{{{ contact_form }}}');
                    }
                });

                // Adds a menu item to the tools menu
                editor.ui.registry.addMenuItem('contact', {
                    text: 'Contact Form',
                    context: 'insert',
                    icon: 'sourcecode',
                    onAction: function() {
                        // Open window with a specific url
                        editor.insertContent('@{{{ contact_form }}}');
                    }
                });
            });
        @endif
        }
    }; //end tinymce
