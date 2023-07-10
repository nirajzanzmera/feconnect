<div class="modal fade" id="interview" tabindex="-1" role="dialog" aria-labelledby="interviewLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="container-fluid px-0">
                    <div class="row">
                        <h5 class="col modal-title" id="interviewLabel">Lead Value Calculator</h5>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="modal_form">
                    <div class="card-block">
                    
                        <fieldset class="form-group ">
                            <div class="col-md-12">                        
                                {{ csrf_field() }}
                            </div>
                        </fieldset>

                        <fieldset class="form-group ">
                            <div class="col-md-12">                        
                                <label for="leads_last" class="form-control-label"title="How many leads did you get last?">How many leads did you get last?</label>
                                <a class="btn btn-xs q-mark" tabindex="0" data-toggle="popover" data-placement="left" data-content="
                                    <p>
                                         (or do you estimate)
                                    </p>
                                    ">
                                    <i class="fa fa-btn fa-question-circle"></i>
                                </a>
                            </div>
                            <div class="input-group ml-3 mb-3 row">
                                <input type="text" class="form-control col-sm-9" placeholder="How many leads did you get last">
                                <div class="input-group-append">
                                    <select class="input-group-text" name="" id="">
                                        <option value="week">Week</option>
                                        <option value="month">Month</option>
                                        <option value="year">Year</option>
                                    </select>
                                </div>
                            </div>
                        </fieldset>
                        
                        <fieldset class="form-group ">
                            <div class="col-md-12">                        
                                <label for="customer_last" class="form-control-label"title="How many customers did you have last?">How many customers did you have last?</label>
                                <a class="btn btn-xs q-mark" tabindex="0" data-toggle="popover" data-placement="left" data-content="
                                    <p>
                                         (or do you estimate)
                                    </p>
                                    ">
                                    <i class="fa fa-btn fa-question-circle"></i>
                                </a>
                            </div>
                            <div class="input-group ml-3 mb-3 row">
                                <input type="text" class="form-control col-sm-9" placeholder="How many customers did you have last">
                                <div class="input-group-append">
                                    <select class="input-group-text" name="" id="">
                                        <option value="week">Week</option>
                                        <option value="month">Month</option>
                                        <option value="year">Year</option>
                                    </select>
                                </div>
                            </div>
                        </fieldset>
    
                        <fieldset class="form-group ">
                            <div class="col-md-12">                        
                                <label for="sales_last" class="form-control-label" title="How many sales did you have last?">How many sales did you have last?</label>
                                <a class="btn btn-xs q-mark" tabindex="0" data-toggle="popover" data-placement="left" data-content="
                                    <p>
                                         (or do you estimate)
                                    </p>
                                    ">
                                    <i class="fa fa-btn fa-question-circle"></i>
                                </a>
                            </div>
                            <div class="input-group ml-3 mb-3 row">
                                <input type="text" class="form-control col-sm-9" placeholder="How many sales did you have last?">
                                <div class="input-group-append">
                                    <select class="input-group-text" name="" id="">
                                        <option value="week">Week</option>
                                        <option value="month">Month</option>
                                        <option value="year">Year</option>
                                    </select>
                                </div>
                            </div>
                        </fieldset>
    
                        <fieldset class="form-group ">
                            <div class="col-md-12">                        
                                <label for="sales_last" class="form-control-label" title="How much revenue did you have last?">How much revenue did you have last? </label>
                                <a class="btn btn-xs q-mark" tabindex="0" data-toggle="popover" data-placement="left" data-content="
                                    <p>
                                         (or do you estimate)
                                    </p>
                                    ">
                                    <i class="fa fa-btn fa-question-circle"></i>
                                </a>
                            </div>
                            <div class="input-group ml-3 mb-3 row">
                                <input type="text" class="form-control col-sm-9" placeholder="How much revenue did you have last?">
                                <div class="input-group-append">
                                    <select class="input-group-text" name="" id="">
                                        <option value="week">Week</option>
                                        <option value="month">Month</option>
                                        <option value="year">Year</option>
                                    </select>
                                </div>
                            </div>
                        </fieldset>
    
                        <fieldset class="form-group ">
                            <div class="col-md-12">                        
                                <label for="sales_last" class="form-control-label" title="How much revenue did you have last?">About what % of your revenue do you get to keep? </label>
                                <a class="btn btn-xs q-mark" tabindex="0" data-toggle="popover" data-placement="left" data-content="
                                    <p>
                                         (or do you estimate)
                                    </p>
                                    ">
                                    <i class="fa fa-btn fa-question-circle"></i>
                                </a>
                            </div>
                            <div class="input-group ml-3 mb-3 row">
                                <input type="text" class="form-control col-sm-9" placeholder="About what % of your revenue do you get to keep?">
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </fieldset>
    
                        <div class="alert alert-info">
                            <em>
                                Store all values <br>
                                <strong>Note:</strong><br> 	
                                <p class="ml-3">
                                    Annualize numbers <br>
                                    cust<<sales => sales+=cust <br>
                                    leads<<cust => leads+=cust <br>
                                    %margin<=0 => %margin=5% <br>
                                </p>
                            </em>
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

});
</script>