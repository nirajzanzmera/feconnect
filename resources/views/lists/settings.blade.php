@extends('fe.layouts.app')
@section('content')
<div>
    <h1 class="page-heading">Settings</h1>
</div>
<ol class="breadcrumb">
    <li><a href="{{ route('homebc') }}">Home</a></li>
    <li><a href="{{ route('lists.index') }}">Lists</a></li>
    <li class="active">{{ $list->name }}</li>
</ol>
@include('lists._nav')
<div class="row-fluid">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                Update Lists Settings
            </div>
            <div class="card-block">
                <form method="post" action="{{ route('lists.update', $list->id) }}">
                    {!! csrf_field() !!}
                    {{ empty($list) ? '' : method_field('PUT') }}
                    
                    <div class="row form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label class="col-md-2 form-control-label">Name</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="name" value="{{ old('name', !empty($list->name) ? $list->name : NULL ) }}">
                            @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="row form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label class="col-md-2 form-control-label">Default List</label>
                        <div class="col-md-2">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="default" value="true"
                                {{ old('default', ($default_list_id == $list->id) ? 'checked' : '' ) }}>
                            </label>
                            @if ($errors->has('default'))
                            <span class="help-block">
                                <strong>{{ $errors->first('default') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="row form-group{{ $errors->has('default_sender') ? ' has-error' : '' }}">
                        <label class="col-md-2 form-control-label">Default Sender</label>
                        <div class="col-md-6">
                            <select name="default_sender" id="" class="form-control">
                                <option value=""></option>
                                @foreach($senders as $sender)
                                    @if ($sender->id == $default_sender)
                                    <option value="{{ $sender->id }}" selected>{{ $sender->email }}</option>
                                    @else
                                    <option value="{{ $sender->id }}">{{ $sender->email }}</option>
                                    @endif
                                @endforeach
                            </select>
                            
                            @if ($errors->has('default_sender'))
                            <span class="help-block">
                                <strong>{{ $errors->first('default_sender') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>


                    {{-- 
                    <div class="row form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label class="col-md-2 form-control-label">Tracking Link Override:</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="tracking_link_override" value="{{ old('tracking_link_override', $list->trk_api) }}" placeholder="http://trk.example.com">
                            @if ($errors->has('tracking_link_override'))
                            <span class="help-block">
                                <strong>{{ $errors->first('tracking_link_override') }}</strong>
                            </span>
                            @endif
                            <div class="alert alert-info">
                                Please create a CNAME DNS Record that points to trk.dzrstat.com before changing this setting.
                            </div>
                        </div>
                    </div>
                     --}}
                    
                    <div class="row form-group">
                        <div class="col-md-6 col-md-offset-2">
                            <button type="submit" class="btn btn-success">
                            <i class="fa fa-btn fa-save"></i> Update
                            </button>
                        </div>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                Newsletter Sign Up Form Generator
            </div>
            <div class="card-block">
                <div class="form-group" id="redir_send_section">
                    <label for="redir">Where would you like the form to redirect after the user has signed up?</label>
                    <input type="text" class="form-control" id="redir" placeholder="Enter redirect url"><br/>
                    <button id="redir_send" class="btn btn-primary">Get Sign Up Form</button>
                </div>
                <div id="results"  style="display:none">
                    <legend>Copy and paste this form into your website to allow users to sign up.</legend><br/>
                <pre><code id="instructions"></code></pre>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@section('js')
<script type="text/javascript">
    $(document).ready(function(){
        $('#redir_send').on('click', function(){
            var redir = $('#redir').val();
            $.get( "{{  route('lists.generate_signup',$list->id) }}/?redir="+encodeURIComponent(redir), function( data ) {
                $( "#instructions" ).text( data );
            });
            $('#redir_send_section').hide('slow');
            $('#results').show('slow');
        });
    });
</script>
@endsection
