@extends('layouts.app')
@section('content')
<div>
    <h1 class="page-heading">Update Billing</h1>
</div>
<ol class="breadcrumb">
    <li><a href="">Home</a></li>
    <li><a href="">Accounts</a></li>
    <li>Update Billing</li>
</ol>
@include('subscription._nav')
<link rel="stylesheet" href="https://src.dzr.io/connect/4/examples/css/bootstrap-datepicker.min.css">
<div class="row-fluid">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="media">
                    <div class="media-body">
                        <h4 class="card-title">Payment Methods</h4>
                    </div>
                    <div class="media-right">
                        <a href="#" class="btn btn-sm btn-success">
                            <i class="fa fa-plus"></i>
                            Add Payment Method
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-block card-block-light" style="margin: .625rem;margin-top: 0;padding: 0;">
                <ul class="list-group">
                    <li class="list-group-item row hidden-lg-down row ">
                        <div class="col-lg-2"><strong>Type:</strong></div>
                        <div class="col-lg-3"><strong>Account Ending:</strong></div>
                        <div class="col-lg-3"><strong>Expiration:</strong></div>
                        <div class="col-lg-4"></div>
                    </li>
                                        <li class="list-group-item row" id="camp_6628">
                    <div class="col-xl-2">
                        <label class="hidden-xl-up">Type:</label>
                        Visa 
                        &nbsp;
                        &nbsp;
                        <div class="label label-success">
                            Default
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <label class="hidden-xl-up">Account Ending:</label>
                        x1234                     
                    </div>

                    <div class="col-xl-3">
                        <label class="hidden-xl-up">Expiration:</label>
                        12/22                     
                    </div>
                    <div class="col-xl-4">                    
                        <div class="btn-group pull-right">
                    <a 
            href="#" 
            title="Set Default"
            class="btn btn-sm btn-info " 
            target="_blank"                     >
                        <i class="fa fa-cog"></i> Set Default
                    </a>
                                        <a 
            href="#" 
            title="Add Funds Now"
            class="btn btn-sm btn-primary " 
                                >
                        <i class="fa fa-plus-circle"></i>
                    </a>
                <div class="btn-group">
                    <div class="dropdown show">
                        <a class="btn btn-sm btn-default dropdown-toggle" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bars"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                            <a 
                                                href="#" 
                                                title="Set Default"
                                                class="dropdown-item " 
                                
                                                                  >   
                                            <i class="fa fa-cog"></i>
                                            Set Default
                                    </a>
                                <a 
                                    href="#" 
                                    title="Add Funds Now"
                                    class="dropdown-item " 
                                                        >   
                                            <i class="fa fa-plus-circle"></i>
                        Add Funds Now
                                    </a>
                                <a 
                                    href="#" 
                                    title="Delete..."
                                    class="dropdown-item " 
                                                        >   
                                            <i class="fa fa-trash"></i>
                        Delete...
                                    </a>
                              
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="media">
                    <div class="media-body">
                        <h4 class="card-title">Add Card</h4>
                        <p class="card-subtitle"></p>
                    </div>
                    <div class="media-right media-middle">
                        

                    </div>
                </div>
            </div>
            <div class="card-block">

                     <form action="" method="post" id="payment-form">

                        <div class="row form-group">
                            <label class="col-md-12 form-control-label">Credit or debit card</label>
                            <div class="col-md-12">
                                <div id="card-element" class="form-control">
                                    <!-- a Stripe Element will be inserted here. -->
                                </div>
                                <span class="help-block">
                                    <div id="card-errors" role="alert"></div>
                                </span>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" id="submit_btn"> Add Card</button>

                    </form>
                </form> 
                
            </div>
            

        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="media">
                    <div class="media-body">
                        <h4 class="card-title">Add Bank Account</h4>
                        <p class="card-subtitle"></p>
                    </div>
                    <div class="media-right media-middle">
                        

                    </div>
                </div>
            </div>
            <div class="card-block">

                     <form action="" method="post" id="payment-form">

                        <div class="row form-group">
                            <label class="col-md-12 form-control-label">Bank Account Number</label>
                            <div class="col-md-12">
                                <div id="card-element" class="form-control">
                                    <!-- a Stripe Element will be inserted here. -->
                                </div>
                                <span class="help-block">
                                    <div id="card-errors" role="alert"></div>
                                </span>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" id="submit_btn"> Add Account</button>

                    </form>
                </form> 
                
            </div>
            

        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="media">
                    <div class="media-body">
                        <h4 class="card-title">Billing Settings:</h4>
                    </div>
                    <div class="media-right media-middle">
                        <a class="btn btn-xs q-mark" tabindex="0" data-toggle="popover" data-placement="left" title="How Billing Works" data-content="
                            <ul>
                                <li>You will be billed on your billing cycle date or when your credit limit is exceeded</li>
                                <li>Your credit limit will automatically increase based on your level of activity</li>
                                <li>Any declined balance will be immediately due.</li>
                            </ul>
                            ">
                            <i class="fa fa-btn fa-question-circle"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-block card-block-light">

                <fieldset class="form-group ">
                    <label for="underamount" class="col-md-5 form-control-label" style="text-align:right;"
                        title="Under Amount">Bill when under this amount:
                    </label>
                    <div class="col-md-4">
                        <input id="underamount" class='form-control colorpicker' name="underamount"
                            value="" />
                    </div>
                    <div class="col-md-1">                        
                        <a class="btn btn-xs q-mark pull-right" tabindex="0" data-toggle="popover" data-placement="left" title="Bill When Under This Amount" data-content="
                            <ul>
                                <li>When the account balance falls below this level you will automatically be billed to restore this balance.</li>
                                <li>These billing controls allow you to prepay to give you more time to deal with any issues with your payment method and prevent service interruptions</li>
                                <li>You can remove them at any time and your billing will revert to current basis</li>
                            </ul>
                            ">
                            <i class="fa fa-btn fa-question-circle"></i>
                        </a>

                    </div>
                </fieldset>
                <fieldset class="form-group ">
                    <label for="addamount" class="col-md-5 form-control-label" style="text-align:right;"
                        title="Add Amount">Add this amount to billing:
                    </label>
                    <div class="col-md-4">
                        <input id="amount" class='form-control colorpicker' name="addamount"
                            value="" />
                    </div>
                    <div class="col-md-1">                        
                        <a class="btn btn-xs q-mark pull-right" tabindex="0" data-toggle="popover" data-placement="left" title="Add This Amount to Billing" data-content="
                            <ul>
                                <li>When you are billed, you will be billed what is due plus this additional amount to maintain a greater balance.</li>
                                <li>These billing controls allow you to prepay to give you more time to deal with any issues with your payment method and prevent service interruptions</li>
                                <li>You can remove them at any time and your billing will revert to current basis</li>
                            </ul>
                            ">
                            <i class="fa fa-btn fa-question-circle"></i>
                        </a>

                    </div>

                </fieldset>
                <fieldset class="form-group ">
                    <label for="addamount" class="col-md-5 form-control-label" style="text-align:right;"
                        title="Add Amount">Billing cycle date:
                    </label>
                    <div class="col-md-4">
                        <input id="datepicker" name="publish_date" class=" form-control" type="text"
                            value=""
                            autocomplete="nope">
                    </div>
                    <div class="col-md-1 ">                        
                        <a class="btn btn-xs q-mark pull-right" tabindex="0" data-toggle="popover" data-placement="left" title="Billing Cycle Date" data-content="
                            <ul>
                                <li>You can select a new billing cycle end date within the next 30 days</li>
                                <li>You will be billed on your current cycle date, and then additionally on this date on a pro-rated basis</li>
                                <li>You will then be billed monthly on that new day of the month going forward</li>
                                <li>These billing controls allow you to prepay to give you more time to deal with any issues with your payment method and prevent service interruptions</li>
                                <li>You can remove them at any time and your billing will revert to current basis</li>
                            </ul>
                            ">
                            <i class="fa fa-btn fa-question-circle"></i>
                        </a>

                    </div>

                </fieldset>
                <button class="btn btn-success">Update Settings</button>

            </div>
        </div>
    </div>
</div>
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

@endsection
@section('js')
<script src="https://src.dzr.io/connect/4/assets/vendor/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
    $('[data-toggle="popover"]').popover({
      trigger: 'focus', 
      html: true,
    });
    $.fn.plusDatePicker = function () {
        if (! this.length) return;
        if (typeof $.fn.datepicker != 'undefined') {
            this.datepicker({
                autoclose: true,
                todayHighlight: true,
                startDate: '+1d',
                endDate: '+30d'
            });
        }
    };
    $('#datepicker').plusDatePicker();
});

</script>

@endsection
