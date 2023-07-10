<style type="text/css">

    .popover {
        max-width: 60%;
    }
    @media (min-width: 576px) {
        .popover {
            max-width: 600px;
            
        }
    }
</style>

<script type="text/javascript">
$(document).ready(function () {
    $('[data-toggle="popover"]').popover({
      trigger: 'focus', 
      html: true,
    });
});
</script>
