@extends('layouts.app')
@section('content')
<div>
    <a href="{{route('teams.index')}}" class="btn btn-success btn-sm pull-right" style="margin-top: 22px;">
        <i class="fa fa-arrow-left"></i> Back
    </a>
    <h1 class="page-heading">Account Users for : "{{$team->name}}"</h1>
</div>

<div class="card">
    <div class="card-header">
        <h4 class="card-title">
            Users
        </h4>
    </div>
    @rtable([
        'header' => [
            ['label'=>'Name', 'field'=>'name', 'raw'=>true],
            ['label'=>'', 'field'=>'btns', 'raw'=>true],
        ],
        'rows' => $members
    ])@endrtable
</div>

<div class="card">
    <div class="card-header">
        <h4 class="card-title">
            Active Invites
        </h4>
    </div>
    @rtable([
        'header' => [
            ['cols'=>6, 'label'=>'Email / Invite', 'field'=>'name', 'raw'=>true],
            ['cols'=>2, 'label'=>'Created', 'field'=>'created', 'raw'=>true],
            ['cols'=>2, 'label'=>'Expires', 'field'=>'expires', 'raw'=>true],
            ['cols'=>2, 'label'=>'', 'field'=>'btns', 'raw'=>true],
        ],
        'rows' => $invites
    ])@endrtable
</div>
<div class="row-fluid">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    Invite Another User to Share Account
                </h4>
            </div>
            <div class="card-block">
                <form method="post" action="{{route('teams.members.invite', $team)}}">
                    {!! csrf_field() !!}
                    <div class="form-group row{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label class="col-md-4 form-control-label" style="text-align: right">E-Mail Address</label>
                        <div class="col-md-6">
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                            @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-btn fa-envelope-o"></i> E-mail Invitation to Share Account
                            </button>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6 col-md-offset-4">
                            <a href="{{ route('teams.members.inviteLink', $team) }}" class="btn btn-primary"><i
                                    class="fa fa-btn fa-link"></i> Create Invitation Link to Share Account
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.17.1/axios.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">
    $('document').ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.copy').on('click', function(e){
            e.preventDefault();
            var link = $(this).data('link');
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(link).select();
            document.execCommand("copy");
            $temp.remove();
            alert('Copied to Clipboard');
        });
        function copyToClipboard(element) {
            $temp.remove();
        }

        $('.delete').on('click', function (e) {
            e.preventDefault();
            var delete_url = $(this).data('url');
            var id = $(this).data('id');
            swal({
                title: "Are you sure?",
                text: "Are you sure that you want to Remove Sharing?",
                icon: "warning",
                dangerMode: true,
                buttons: [true, 'Remove'],
            })
            .then(willRemove => {
                 if (willRemove) {
                        $.ajax({
                            url: delete_url,
                            type: 'DELETE',
                            success: function (result) {
                                window.location = '{{ route('teams.members.index') }}';
                            }
                        });
                    }
            });
        });

    
            $('.owner').on('click', function (e) {
                e.preventDefault();
                var url = $(this).data('url');
                var id = $(this).data('id');
                swal({
                    title: "Are you sure?",
                    text: "Are you sure that you change the owner of this account?",
                    icon: "warning",
                    dangerMode: true,
                    buttons: [true, 'Change Owner'],
                })
                .then(willDelete => {
                    if (willDelete) {
                        $.ajax({
                            url: url,
                            type: 'PUT',
                            success: function (result) {
                                window.location = '{{ route('teams.members.index') }}';
                            }
                        });
                    }
                });
            });

            $('.delete_invite').on('click', function (e) {
                e.preventDefault();
                var url = $(this).data('url');
                var id = $(this).data('id');
                swal({
                    title: "Are you sure?",
                    text: "Are you sure that you want to delete this invite?",
                    icon: "warning",
                    dangerMode: true,
                    buttons: [true, 'Delete'],
                })
                .then(willDelete => {
                    if (willDelete) {
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            success: function (result) {
                                window.location = '{{ route('teams.members.index') }}';
                            }
                        });
                    }
                });
            });

 
    });
</script>
@endsection