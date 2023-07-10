<div class="modal fade" id="interview" tabindex="-1" role="dialog" aria-labelledby="interviewLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="container-fluid px-0">
                    <div class="row">
                        <h5 class="col modal-title" id="interviewLabel">Choose a Username</h5>
                    </div>
                    <div class="row">
                        <small class="col muted">Help people find your business</small>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <form action="{{ route('plans.username') }}" method="POST" id="modal_form">
                    <div class="card-block">
                        <div class="row form-group">
                            <label class="col-md-12 form-control-label" style="font-weight: bold;">
                                Your Business:
                            </label>
                            <input name="username" id="username" type="text" class="form-control" value="" placeholder="" required>
                        </div>
                    </div>
                    <div class="card-block" style="text-align: center">
                        <div class="row">
                            <h4>Your website could be: <span id="domain"></span></h4>
                        </div>
                    </div>
                    <div class="card-block" style="text-align: center">
                        <div class="row form-group">
                            {{ csrf_field() }}
                        </div>
                    </div>
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

    $('#username').on('input blur keyup paste', function () {
            var username = $(this).val() + "";
            username = username.replace(/[^a-z0-9-]/ig, '').toLowerCase() + '.com';
            $('#domain').html(username);
    });

});
</script>