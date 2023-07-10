<div class="modal fade" id="interview" tabindex="-1" role="dialog" aria-labelledby="interviewLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="container-fluid px-0">
                    <div class="row">
                        <h5 class="col modal-title" id="interviewLabel">About Your Offer</h5>
                    </div>
                    <div class="row">
                        <small class="col muted">The most common thing people pay you for (create a lead generation campaign).</small>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <form action="{{-- route('teams.update', $team) --}}" method="post" id="modal_form">
                    {{ method_field('PUT') }} {{ csrf_field() }}
                    <div class="tab">

                        @if(Route::currentRouteName() === 'home')

                            <div class="alert alert-info">
                                <em>
                                    Write one line at a time to fit in google adwords and build campaign page.
                                </em>
                            </div>
                            <fieldset class="form-group ">
                                <div class="col-md-12">
                                    <label for="headline1" class="form-control-label" title="Write Headline 1-30">Write Headline 1</label>
                                    <a class="btn btn-xs q-mark" tabindex="0" data-toggle="popover" data-placement="left" data-content="
                            <p>
                                Prepopulate previous
                            </p>
                            " data-original-title="" title="">
                                        <i class="fa fa-btn fa-question-circle"></i>
                                    </a>
                                </div>
                                <div class="col-md-12">
                                    <input id="headline1" type="text" maxlength="30" class="form-control" name="headline1" value="">
                                </div>
                            </fieldset>

                            <fieldset class="form-group ">
                                <div class="col-md-12">
                                    <label for="headline2" class="form-control-label" title="Write Headline of 30 characters">Write Headline 2</label>
                                </div>
                                <div class="col-md-12">
                                    <input id="headline2" type="text" maxlength="30" class="form-control" name="headline2" value="">
                                </div>
                            </fieldset>

                            <fieldset class="form-group ">
                                <div class="col-md-12">
                                    <label for="headline3" class="form-control-label" title="Write Headline of 30 characters">Write Headline 3</label>
                                </div>
                                <div class="col-md-12">
                                    <input id="headline3" type="text" maxlength="30" class="form-control" name="headline3" value="">
                                </div>
                            </fieldset>


                            <fieldset class="form-group ">
                                <label for="description1" class="col-md-12 form-control-label">Description 1</label>
                                <div class="col-md-12">
                                    <textarea id="description1" type="text" maxlength="90" class="form-control" name="description1" value="" rows="3"></textarea>
                                </div>

                            </fieldset>

                            <fieldset class="form-group ">
                                <label for="description2" class="col-md-12 form-control-label">Description 2</label>
                                <div class="col-md-12">
                                    <textarea id="description2" type="text" maxlength="90" class="form-control" name="description2" value="" rows="3"></textarea>
                                </div>

                            </fieldset>

                            <fieldset class="form-group">
                                <label for="image" class="form-control-label">Product / service picture (optional)</label>
                                <div class="input-group">
                    <span class="input-group-btn">
                        <a href="" class="btn btn-primary filemanager"><i class="fa fa-picture-o"></i> Choose</a>
                    </span>
                                    <input id="featured_image" type="hidden" name="image" class="form-control">
                                </div>
                            </fieldset>

                            <div class="alert alert-info">
                                <em>
                                    The end result will be a leadgen campaign as <a title="Learn More" href="#">“Learn More”</a> landing page linked with button at bottom of the index and in top menu using the same words.
                                </em>
                            </div>

                            <input type="hidden" name="interview" id="interview_complete" value="true">

                        @else
                            @if($headless != true)
                                @if(!empty(App\Website::first()) && Route::currentRouteName() == 'teams.edit')
                                    <p>
                                        <em>You can edit your website contact details on the <a href="{{ route('websites.edit', App\Website::first()) }}">Website Settings page</a>.</em>
                                    </p>
                                @endif
                            @endif
                        @endif
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