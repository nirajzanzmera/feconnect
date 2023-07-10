<div class="modal fade" id="interview" tabindex="-1" role="dialog" aria-labelledby="interviewLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="container-fluid px-0">
                    <div class="row">
                        <h5 class="col modal-title" id="interviewLabel">Tell us a little about your website</h5>
                    </div>
                    <div class="row">
                        <small class="col muted">This will display on your website.</small>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <form action="{{-- route('teams.update', $team) --}}" method="post" id="modal_form">
                    {{ method_field('PUT') }} {{ csrf_field() }}
                    @include('fe.teamwork._form',['timezones' => config('teamwork.timezones')])
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="Close" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" onclick="getElementById('modal_form').submit()" id="submit" >
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

    $(document).on('hidden.bs.modal', function(e) {
        //save stuff
        $('#interview_complete').val('delay');
        //$('#modal_form').submit(); // skip saving until we fix modal routes
    });

});
</script>