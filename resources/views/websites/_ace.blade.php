<script src="//cloud9ide.github.io/emmet-core/emmet.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/ace/1.2.8/ace.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/ace/1.2.8/ext-emmet.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/ace/1.2.8/ext-beautify.js" type="text/javascript"></script>
<script type="text/javascript">
var beautify = ace.require("ace/ext/beautify");
var editor = ace.edit("editor");
var myCode = $('[name="editor"]').val();
$(document).ready(function(){
    $('[name="editor"]').hide();
    editor.getSession().setValue(myCode);
    editor.setTheme("ace/theme/monokai");
    editor.session.setMode("ace/mode/html");
    editor.setOptions({
        "enableEmmet": true,
        wrap: true,
        maxLines: 39,
        minLines: 39,
        fontSize: "14pt",
    });
    editor.on('blur', function(){
        var data = editor.getValue();
        tinymce.get('body').setContent(data);
    });
    editor.on("input", function() {
        // input is async event, which fires after any change events
        var isClean = editor.session.getUndoManager().isClean();
        if(!isClean) {
            setDirty();
        }
        var x = document.getElementById("content");
        x.value = editor.getValue();
    });
    /* end editor */
});    
</script>
