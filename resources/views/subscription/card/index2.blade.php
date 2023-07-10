@extends('layouts.app')
@section('content')
@if($headless != true and $hidetitle != true)
<div>
    <h1 class="page-heading">Payment Methods</h1>
</div>
@endif
@include('subscription._nav')
<div class="row-fluid">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="media">
                    <div class="media-body">
                        <h4 class="card-title">
                            Payment Methods
                        </h4>
                        <p class="card-subtitle"></p>
                    </div>
                    <div class="media-right media-middle">
                        
                    </div>
                </div>
            </div>
            @rtable([
                'header' => [
                    ['cols'=>2, 'label'=>'Type', 'field'=>'type', 'raw' => true], 
                    ['cols'=>3, 'label'=>'Account Ending', 'field'=>'ending'],
                    ['cols'=>3, 'label'=>'Expiration', 'field'=>'expiration'],
                    ['cols'=>4, 'label'=>'', 'field'=>'btns', 'raw'=>true],
                ],
                'rows' => $methods
                ])
            @endrtable
        </div>
    </div>
</div>


<div class="row-fluid">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="media">
                    <div class="media-body">
                        <h4 class="card-title">
                            Add Card
                        </h4>
                        <p class="card-subtitle"></p>
                    </div>
                    <div class="media-right media-middle">
                        
                    </div>
                </div>
            </div>
            <div class="card-block">
                @if( auth()->user()->currentTeam->hasCardOnFile() )
                    <form action="{{ route('plans.card_update') }}" method="post" id="payment-form">
                        {{ method_field('PUT') }}
                @else
                    <form action="{{ route('teams.payments.store', auth()->user()->currentTeam) }}?redir=plans.index" method="post"
                        id="payment-form">
                @endif
                        {!! csrf_field() !!}
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
                        <button type="submit" class="btn btn-primary" id="submit_btn">
                            {{ auth()->user()->currentTeam->hasCardOnFile() ? 'Update Card' : 'Add Card' }}</button>
                    </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
    @include('layouts.partials._stripejs')

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
             $('.delete').on('click', function(e){
                e.preventDefault();
                swal({
                    title: "Are you sure?",
                    text: "Are you sure that you want to request the deletion of this payment method?",
                    icon: "warning",
                    dangerMode: true,
                    buttons: [true, 'DELETE'],
                })
                .then(willDelete => {
                    if (willDelete) {
                        var url = $(this).data('url');
                        var id = $(this).data('id');
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            success: function(result) {
                                window.location.reload(true);
                            }
                        });
                    }
                });
            });
    
        });
    </script>


@endsection
