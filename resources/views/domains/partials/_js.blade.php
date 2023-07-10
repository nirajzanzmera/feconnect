<script src="https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js"></script>
<script type="text/javascript">
function search() {
    var template = $('#template').html();
    Mustache.parse(template);
    $('#search').html('<i class="fa fa-btn fa-spinner fa-spin"></i> Loading');
    var keyword = $('#keyword').val();
    keyword = keyword.replace('https://','').replace('http://','').replace('/','');
    $('#results').html('');
    $.ajax({
        url: '{{ route('domains.search') }}/' + keyword,
        type: 'GET',
        success: function(result) {
            $('#search').html('<i class="fa fa-btn fa-search"></i> Search');
            var rendered = Mustache.render(template, result);
            $('#results').html(rendered);
        }
    });
}

$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });   // optional, speeds up future uses

   $('#keyword').on("keypress", function(e) {
        /* ENTER PRESSED*/
        if (e.keyCode == 13) {
            search();
        }
    });
    $('#search').on('click', function() {
        search();
    });
   
});

</script>
@include('domains.partials._results')
