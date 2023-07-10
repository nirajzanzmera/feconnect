<div class="modal fade" id="interview" tabindex="-1" role="dialog" aria-labelledby="interviewLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="container-fluid px-0">
                    <div class="row">
                        <h5 class="col modal-title" id="interviewLabel">About You</h5>
                    </div>
                    <div class="row">
                        <small class="col muted">Set Up Your First Campaign</small>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <form action="{{-- route('teams.update', $team) --}}" method="post" id="modal_form">
                    {{ method_field('PUT') }} {{ csrf_field() }}
                    <div class="tab">

                            <div class="row form-group{{ $errors->has('headline') ? ' has-error' : '' }}">
                                <label class="col-md-2 form-control-label">Write Headline</label>
                                <a class="btn btn-xs q-mark" tabindex="0" data-toggle="popover" data-placement="left" data-content="
                                <p>
                                    Prepopulate business name
                                </p>
                                " data-original-title="" title="">
                                    <i class="fa fa-btn fa-question-circle"></i>
                                </a>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="headling" value="{{ old('headline', (!empty($team->headline)) ? $team->headline : NULL ) }}">
                                    @if ($errors->has('headling'))
                                        <span class="help-block">
                <strong>{{ $errors->first('headling') }}</strong>
            </span>
                                    @endif
                                </div>
                            </div>

                            <div class="row form-group{{ $errors->has('about_business') ? ' has-error' : '' }}">
                                <label class="col-md-2 form-control-label">About business</label>
                                <a class="btn btn-xs q-mark" tabindex="0" data-toggle="popover" data-placement="left" data-content="
                                <p>
                                    <i>What is your business best known for?</i>
                                    <i>What are you best known for?</i>
                                </p>
                                " data-original-title="" title="">
                                    <i class="fa fa-btn fa-question-circle"></i>
                                </a>
                                <div class="col-md-9">
                                    <textarea class="form-control" name="about_business">{{ old('about_business', (!empty($team->about_business)) ? $team->about_business : NULL ) }}</textarea>
                                    @if ($errors->has('about_business'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('about_business') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    Your Logo (optional)
                                </div>
                                <div class="card-block">
                                    <fieldset class="form-group">
                                        <label for="image" class="form-control-label">Set site logo</label>
                                        <div class="input-group">
                            <span class="input-group-btn">
                                <a href="" class="btn btn-primary filemanager"><i class="fa fa-picture-o"></i> Choose</a>
                            </span>
                                            <input id="featured_image" type="hidden" name="image" class="form-control">
                                        </div>
                                    </fieldset>
                                    <fieldset class="form-group ">
                                        <label for="about_logo" class="col-md-12 form-control-label" title="About featured image">About Featured Image</label>
                                        <input id="about_logo" type="text" class="form-control" name="about_logo" value="">
                                    </fieldset>

                                    <p>Provide about templates and lots of examples for customization</p>
                                    <i>Results in new About page in top menu and possible site logo</i>

                                </div>

                            </div>

                            <input type="hidden" name="interview" id="interview_complete" value="true">

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

});
</script>