@extends('fe.layouts.app')
@section('content')
    {{-- @if($headless != true and $hidetitle != true) --}}
    <div>
        <h1 class="page-heading">
            Referrals
        </h1>
    </div>
    {{-- @endif --}}
    @include('fe.billing._nav')

    @if($errors->count() > 0)
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <div class="media">
                <div class="media-body">
                    <h4 class="card-title">
                        Referral Program
                    </h4>
                </div>
                <div class="media-right media-middle">
                    <a class="btn btn-xs q-mark" tabindex="0" data-toggle="popover" data-placement="left" title="" data-content="
            <ul>
                <li>Share your personal referral code with your friends and family</li>
                <li>Any user that signs up using your referral code, upgrades and completes their free trial will then receive a $10 credit to their
                    account</li>
                <li>For each person you refer who signs up for Dataczar, upgrades and completes their free trial, you get a $10 credit to your
                    account</li>
            </ul>
            " data-original-title="How The Dataczar Referral Program Works">
                        <i class="fa fa-btn fa-question-circle"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="card-block">
            Tell a friend to sign up with your referral code, give $10, get $10.
            Your Referral code: <strong>{{ $owner->referral_code }}</strong>
            <br>
            <br>
            Your Registration Referral Link: <strong>https://connect.dataczar.com/register/{{ $owner->referral_code }}</strong>&nbsp;&nbsp;
            <a href="#" class="btn btn-info btn-sm copy pull-right" data-link="https://connect.dataczar.com/register/{{ $owner->referral_code }}">
                <i class="fa fa-btn fa-copy "></i>
                Copy Link
            </a>
            <br>
            <br>

            Home Page Referral Link: <strong>https://www.dataczar.com/?rc={{ $owner->referral_code }}</strong>&nbsp;&nbsp;
            <a href="#" class="btn btn-info btn-sm copy pull-right" data-link="https://www.dataczar.com/?rc={{ $owner->referral_code }}">
                <i class="fa fa-btn fa-copy "></i>
                Copy Link
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
                Referrals
            </h4>
        </div>
        <table class="table table-striped">
            <thead class="">
            <tr>
                <th>Date</th>
                <th>Customer</th>
                <th>Customer Code</th>

                <th>Status</th>
            </tr>

            @foreach($referrers as $referrer)
                <tr>
                    <th>{{ $referrer->created_at }}</th>
                    <th>{{ $referrer->name }}</th>
                    <th>{{ $referrer->referral_code }}</th>
                    <th>{{ $referrer->status }}</th>
                </tr>
            @endforeach
            </thead>
        </table>
    </div>


@endsection

@section('js')
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
    <link rel="stylesheet" type="text/css"
          href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.standalone.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('[data-toggle="popover"]').popover({
                trigger: 'focus',
                html: true,
            });
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard-polyfill/2.8.6/clipboard-polyfill.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.copy').on('click', function(e) {
                e.preventDefault();
                var link = $(this).data('link');
                clipboard.writeText(link);
                alert('Copied to Clipboard');
            });
        });
    </script>
    <script src="/stuff/notifications.js?id=4725b93ed3d1c87eb95e"></script>

@endsection