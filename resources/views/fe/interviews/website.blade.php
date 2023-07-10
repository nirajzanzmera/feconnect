<div class="modal fade" id="interview" tabindex="-1" role="dialog" aria-labelledby="interviewLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="container-fluid px-0">
                    <div class="row">
                        <div class="col text-right steps">Step 1 of 2</div>
                        <div class="col text-right steps" style="display:none">Step 2 of 2</div>
                    </div>
                    <div class="row">
                        <h5 class="col modal-title" id="interviewLabel">Tell us a little about your website</h5>
                        <h5 class="col modal-title" id="interviewLabel" style="display:none">Your Online and
                            Social Links</h5>
                    </div>
                    <div class="row">
                        <small class="col muted">This will display on your website.</small>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <form action="{{-- route('teams.update', $team) --}}" method="post" id="team_form">
                    {{ method_field('PUT') }} {{ csrf_field() }}
                    @include('fe.teamwork._form',['timezones' => config('teamwork.timezones')])
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="Close" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="back" style="display: none;">
                    <i class="fa fa-chevron-left"></i>
                    Back
                </button>
                <button type="button" class="btn btn-primary" id="next">
                    Next
                    <i class="fa fa-chevron-right"></i>
                </button>
                <button type="button" class="btn btn-success" onclick="getElementById('team_form').submit()" id="submit" style="display:none">
                    <i class="fa fa-save"></i>
                    Save changes
                </button>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('assets/vendor/jquery.min.js') }}"></script>

<script type="text/javascript">
$(document).ready(function() {
    $('#interview').modal();

    $('#next').on('click', function(e) {
        toggleStuff();
    });
    $('#back').on('click', function(e) {
        toggleStuff();
    });
    $(document).on('hidden.bs.modal', function(e) {
        //save stuff
        $('#interview_complete').val('delay');
        //$('#team_form').submit(); // skip saving until we fix modal routes
    });

    function toggleStuff() {
        $('.tab').toggle();
        $('.steps').toggle();
        $('.modal-title').toggle();
        $('#back').toggle();
        $('#next').toggle();
        $('#submit').toggle();
    }
});
</script>