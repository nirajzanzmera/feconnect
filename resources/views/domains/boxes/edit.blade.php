@extends('layouts.app')
@section('content')

@include('domains._nav')

<div class="row-fluid">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header">
                <div class="media">
                    <div class="media-body">
                        <h4 class="card-title pull-left">Email Box: {{ $emailBox->mailbox . "@" . $domain->domain }}</h4>
                    </div>
                </div>
            </div>
            <div class="card-block">
                <legend>Email Box</legend>
                <form action="{{ route('domains.email_boxes.update', ['domain' => $domain, 'emailBox' => $emailBox]) }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

                    <fieldset class="form-group{{ $errors->has('aliases') ? ' has-error' : '' }}">
                        <label for="">Aliases</label>
                        <div class="input-group">
                            <textarea name="aliases" class="form-control">{{ old('aliases', $emailBox->aliases) }}</textarea>
                        </div>
                        @if ($errors->has('aliases'))
                        <span class="help-block">
                            <strong>{{ $errors->first('aliases') }}</strong>
                        </span>
                        @endif
                    </fieldset>

                    <button class="btn btn-success">
                        <i class="fa fa-save"></i>
                        Update Email Box
                    </button>
                </form>

                <hr>
                


            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header">
                <div class="media">
                    <div class="media-body">
                        <h4 class="card-title pull-left">Connection Information</h4>
                    </div>
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <td>
                            <strong>Webmail</strong>
                        </td>
                    </tr>
                </thead>
                <tr>
                    
                    <td align="center"><a href="https://mail.dataczar.com" target="_blank">https://mail.dataczar.com</a></td>
                </tr>
            </table>
            
                <table class="table">
                    <thead>
                        <tr>
                            <td colspan="2">
                                <strong>Server Information</strong>
                            </td>
                        </tr>
                    </thead>
                    <tr>
                        <td align="right" style="width: 50%"><strong>Username:</strong></td>
                        <td>your email address</td>
                    </tr>
                    <tr>
                        <td align="right" style="width: 50%"><strong>Password:</strong></td>
                        <td>your email password</td>
                    </tr>
                    <tr>
                        <td align="right" style="width: 50%"><strong>IMAP/POP/SMTP hostname:</strong></td>
                        <td>mail.dataczar.com</td>
                    </tr>
                </table>
            
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td colspan="4">
                            <strong>Port Numbers</strong>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>&nbsp;</td>
                        <td><strong>SSL Enabled</strong></td>
                        <td><strong>SSL disabled</strong></td>
                        <td><strong>TLS</strong></td>
                    </tr>
                    <tr>
                        <td><strong>IMAP</strong></td>
                        <td>993</td>
                        <td>143</td>
                        <td>n/a</td>
                    </tr>
                    <tr>
                        <td><strong>POP3</strong></td>
                        <td>995</td>
                        <td>110</td>
                        <td>n/a</td>
                    </tr>
                    <tr>
                        <td><strong>SMTP</strong></td>
                        <td>465</td>
                        <td>8025</td>
                        <td>25, 587</td>
                    </tr>
                </tbody>
            </table>
        </div> {{-- card --}}
    </div>
</div>
</div>

</div>
@endsection
@section('js')

@endsection