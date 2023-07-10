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
    <div class="card-block">
        <ul class="list-group">
            <li class="list-group-item row hidden-lg-down">
                <div class="col-lg-10"><strong>Name</strong></div>
                <div class="col-lg-2"><strong></strong></div>
            </li>
            @foreach($team->users AS $user)
            <li class="list-group-item row">
                <div class="col-lg-10">
                    <label class="hidden-xl-up"><strong>Name: </strong></label>
                    {{$user->name}}
                    @if(auth()->user()->getKey() == $user->getKey())
                    - <div class="label label-success">owner</div>
                    @endif
                </div>
                <div class="col-lg-2">
                    @if(auth()->user()->isOwnerOfTeam($team))
                    @if(auth()->user()->getKey() !== $user->getKey())
                    <div class="btn-group pull-right ">
                        <div class="dropdown show">
                            <a class="btn btn-sm btn-default dropdown-toggle" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-bars"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                @if(auth()->user()->isOwnerOfTeam($team))
                                    <a href="#" title="Set as Owner" class="dropdown-item owner" data-id="{{ $user->id }}" data-url="{{ route('teams.members.owner', ['new_owner'=>$user->id]) }}">   
                                        <i class="fa fa-user"></i> Set as Owner...
                                    </a>
                                @endif
                                <a href="#" title="Remove sharing" class="dropdown-item delete" data-id="{{ $user->id }}" data-url="{{ route('teams.members.destroy', $user) }}">   
                                    <i class="fa fa-trash-o"></i> Remove sharing...
                                </a>     
                            </div>
                        </div>                                                
                    </div>                                                

                    @endif
                    @endif
                </div>
            </li>
            @endforeach
        </ul>
    </div>

</div>
<div class="card">
    <div class="card-header">
        <h4 class="card-title">
            Active Invites
        </h4>
    </div>
    <div class="card-block">
        <ul class="list-group">
            <li class="list-group-item row hidden-lg-down">
                <div class="col-lg-6"><strong>E-mail / Link</strong></div>
                <div class="col-lg-2"><strong>Created</strong></div>
                <div class="col-lg-2"><strong>Expires</strong></div>
                <div class="col-lg-2"><strong></strong></div>
            </li>
            @foreach($team->invites AS $invite)
            <li class="list-group-item row ">
                <div class="col-lg-6"><label class="hidden-xl-up"><strong>E-mail / Link: </strong></label>
                    @if($invite->email !== 'link')
                        {{$invite->email}}<br />
                    @endif
                    {{ route( 'teams.accept_invite',  $invite->accept_token ) }} 
                </div>
                <div class="col-lg-2"><label class="hidden-xl-up"><strong>Created:</strong></label>
                    {{ $invite->created_at->format("F j, Y") }}
                </div>
                <div class="col-lg-2"><label class="hidden-xl-up"><strong>Expires:</strong></label>
                    n/a
                </div>
                <div class="col-lg-2">
                    <div class="btn-group pull-right">
                        @if($invite->email !== 'link')
                            <a href="{{route('teams.members.resend_invite', $invite)}}" title="Resend invite" class="btn btn-sm btn-primary">
                                <i class="fa fa-envelope-o"></i>
                            </a>
                        @endif
                        <a href="#" title="Copy Link" class="btn btn-info btn-sm copy" data-link="{{ route( 'teams.accept_invite',  $invite->accept_token ) }}">
                            <i class="fa fa-btn fa-copy "></i>
                        </a>
                        <div class="btn-group ">
                            <div class="dropdown show">
                                <a class="btn btn-sm btn-default dropdown-toggle" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-bars"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                    @if($invite->email !== 'link')
                                    <a href="{{route('teams.members.resend_invite', $invite)}}" class="dropdown-item">
                                        <i class="fa fa-envelope-o"></i> Resend invite
                                    </a>
                                    @endif
                                    <a href="#" class="dropdown-item copy" data-link="{{ route( 'teams.accept_invite',  $invite->accept_token ) }}">
                                        <i class="fa fa-copy "></i> 
                                        Copy Link
                                    </a>
                                    <a href="#" title="Delete invitation" class="dropdown-item delete_invite" data-id="{{ $invite->id }}" data-url="{{ route('teams.members.destroy_invite', $invite) }}">   
                                        <i class="fa fa-trash-o"></i> Delete invitation...
                                    </a>     

                                </div>
                            </div> 
                        </div>                                               
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
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
                            <a href="{{ route('teams.members.inviteLink', $team) }}" class="btn btn-primary"><i class="fa fa-btn fa-link"></i> Create Invitation Link to Share Account
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
    $('document').ready(function(){

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
            var url = $(this).data('url');
            var id = $(this).data('id');
            swal({
                title: "Are you sure?",
                text: "Are you sure that you want to Remove Sharing?",
                icon: "warning",
                dangerMode: true,
                buttons: [true, 'REMOVE'],
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
