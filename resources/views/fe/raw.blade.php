

<!DOCTYPE html>
<html class="bootstrap-layout"  lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="noindex">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Connect - {{ $page_title ?? ucwords(str_replace('.', ' ', str_replace(['index', 'show'], '', Route::currentRouteName()))) }}</title>
    <!-- Material Design Icons  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Roboto Web Font -->
    <link href="https://fonts.googleapis.com/css?family=Lato:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en" rel="stylesheet">
    <!-- App CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link type="text/css" href="{{ asset('assets/css/style.min.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('assets/css/print.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('assets/css/tiny.css') }}" rel="stylesheet">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/fontawesome/4.5.0/css/font-awesome.min.css">
    @yield('css')

</head>
<body class="layout-container top-navbar si-l3-md-up">

<!-- End Google Tag Manager (noscript) -->


<!-- Content -->


<div class="row-fluid">
    <div class="card" id="success_message" style="display: none">

    </div>

    <div class="card" id="form_show">
        <div class="card-block card-block-light">
            <div class="card-block">
                <form id="new_request" class="request-form" data-form="" data-form-type="request" onsubmit="return validation()"
                      action="https://connect.dataczar.com/api/contact?data=eyJkYXRhIjp7ImFjY291bnRfaWQiOjU0LCJ3ZWJzaXRlX2lkIjoyODEsInJlZGlyIjoiaHR0cHM6XC9cL3d3dy5kYXRhY3phci5jb21cL2NvbnRhY3RfY29uZmlybWF0aW9uLmh0bWwiLCJwYWdlX2lkIjoxMDI0LCJ0b2tlbl9pZCI6ImQ0NzRjejRyIn0sInNpZyI6IjI5ODYzYWY1M2M3MGFjOTBhZmQzMTQyMWI2NGFjYTY0In0=" accept-charset="UTF-8" method="post">
                    <input type="hidden" name="_method" value="POST">
                    {{ @csrf_field() }}
                    <div class="tab">
                        <div class="row form-group">
                            <label class="col-md-2 form-control-label">Name</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="name" id="dcz_name" aria-required="true">
                            </div>
                        </div>
                    </div>
                    <div class="tab">
                        <div class="row form-group">
                            <label class="col-md-2 form-control-label">Email Address</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="email" id="dcz_email" aria-required="true">
                                <strong><span id="email_msg" style="color: #dd4b39; margin: 5px 0 10px 0;"></span></strong>
                            </div>
                        </div>
                    </div>
                    <div class="tab">
                        <div class="row form-group">
                            <label class="col-md-2 form-control-label">Phone</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="phone" id="dcz_phone" aria-required="true">
                            </div>
                        </div>
                    </div>
                    <div class="tab">
                        <div class="row form-group">
                            <label class="col-md-2 form-control-label">Subject</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="subject" id="dcz_subject" aria-required="true">
                            </div>
                        </div>
                    </div>
                    <div class="tab">
                        <div class="row form-group">
                            <label class="col-md-2 form-control-label">Message</label>
                            <div class="col-md-9">
                                <textarea class="form-control" name="message" id="dcz_message"></textarea>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row form-group">
                        <div class="col-md-9 col-md-offset-2">
                            <button type="submit" class="btn btn-success" id="dcz_submit_contact">
                                <i class="fa fa-btn fa-save"></i> Submit
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>


<!-- jQuery -->
<script src="{{ asset('assets/vendor/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('assets/vendor/tether.min.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap.min.js') }}"></script>
<!-- AdminPlus -->
<script src="{{ asset('assets/vendor/adminplus.js') }}"></script>
<!-- App JS -->
<script src="{{ asset('assets/js/main.min.js') }}"></script>
<!-- Theme Colors -->
<script src="{{ asset('assets/js/colors.js') }}"></script>

<script src="{{ asset('assets/js/jquery-ui.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-datetimepicker.js') }}"></script>
<script type="text/javascript">
    //    $(document).on('click','#dcz_submit_contact',function(e){
    //        //$("#new_request").ajaxForm({url: 'server.php', type: 'post'})
    //        var myForm = document.getElementById('new_request');
    //        var formData = new FormData(myForm);
    //
    //        $.post("https://connect.dataczar.com/api/contact?data=eyJkYXRhIjp7ImFjY291bnRfaWQiOjU0LCJ3ZWJzaXRlX2lkIjoyODEsInJlZGlyIjoiaHR0cHM6XC9cL3d3dy5kYXRhY3phci5jb21cL2NvbnRhY3RfY29uZmlybWF0aW9uLmh0bWwiLCJwYWdlX2lkIjoxMDI0LCJ0b2tlbl9pZCI6ImQ0NzRjejRyIn0sInNpZyI6IjI5ODYzYWY1M2M3MGFjOTBhZmQzMTQyMWI2NGFjYTY0In0=", function(formData, status){
    //            alert("Data: " + formData + "\nStatus: " + status);
    //        });
    //
    //    });

    //    $('#new_request').ajaxForm(function() {
    //        alert("Thank you for your comment!");
    //    });

//    $(document).on('click','#dcz_submit_contact',function(e){
//        var nm = document.getElementById('dcz_name').value;
//        var email = document.getElementById('dcz_email').value;
//        var phone = document.getElementById('dcz_phone').value;
//        var subject = document.getElementById('dcz_subject').value;
//        var message = document.getElementById('dcz_message').value;
//        $.ajax({
//            url: 'https://connect.dataczar.com/api/contact',
//            type: 'POST',
//            data: { 'dcz_name': nm, 'dcz_email':email,'dcz_phone':phone, 'dcz_subject':subject,'dcz_message':message},
//            success: function success(data) {
//                alert('Thank you for contacting us.');
//                document.getElementById('form_show').style.display="none";
//                document.getElementById('success_message').style.display="block";
//                document.getElementById('success_message').innerHTML="Thank you for contacting us.";
//            },
//            error: function error(xhr, status, _error) {
//                if (xhr.status == 400) {
//                    swal('Error!', xhr.responseText, 'error');
//                } else {
//                    swal('Error!', 'failed', 'error');
//                }
//            }
//        });
//    });

</script>
<script type="text/javascript">
    function validation()
    {
        var flag = 0;

        if(document.getElementById("dcz_email").value.split(" ").join("") == "")
        {
            document.getElementById('email_msg').innerHTML = 'The email is required.';
            document.getElementById("dcz_email").focus();
            document.getElementById("dcz_email").style.borderColor ='#dd4b39';
            document.getElementById('email_msg').style.display = 'block';
            flag=1;
        }
        else
        {
            var email1 = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if (!document.getElementById("dcz_email").value.match(email1)) {
                document.getElementById('email_msg').innerHTML = 'The email must be a valid email address.';
                document.getElementById("dcz_email").style.borderColor ='#dd4b39';
                document.getElementById('email_msg').style.display = 'block';
                flag=1;
            }
            else
            {
                document.getElementById("dcz_email").style.borderColor ='#d2d6de';
                document.getElementById('email_msg').style.display = 'none';
            }
        }

        if(flag==1){
            return false;
        }
    }
</script>

</body>

</html>
