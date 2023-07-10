@extends('fe.layouts.guest')
@section('css')
<meta http-equiv="cache-control" content="max-age=0">
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="expires" content="-1">
<meta http-equiv="expires" content="Tue, 01 Jan 1980 11:00:00 GMT">
<meta http-equiv="pragma" content="no-cache">
@endsection

@section('content')

<iframe src="{{env('APIROOTENDPOINT').'/api/login_status'}}" style='  visibility: hidden;'></iframe>
Loading...
@endsection

@section('js')
<script type="text/javascript">
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $.ajax({
            type: "POST",
            url: "{{env('APIROOTENDPOINT').'/api/login'}}",
            data: JSON.stringify({ "email": '{{$rediruser}}', "password" : '{{$redirpass}}' }),
            contentType: "application/json",
            success: function (result) {
                    console.log(result);
                    location.href="{{route('home')}}";
                },
            error: function (result, status) {
                console.log(result);
                location.href="{{route('login_wapi')}}";
            }
        });


    });
</script>
@endsection