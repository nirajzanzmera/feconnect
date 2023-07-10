<fieldset class="form-group{{ $errors->has('mailbox') ? ' has-error' : '' }}">
    <label for="">Emailbox</label>
    <div class="input-group">
        @if(!empty($emailBox))
            {{ $emailBox->email }}
        @else
        <input name="mailbox" type="text" class="form-control" value="{{ old('mailbox', !empty($emailBox) ? $emailBox->mailbox : '') }}" autocomplete="off">
        <span class="input-group-addon">{{ '@' . $domain->domain }}</span>

        @endif
    </div>
    @if ($errors->has('mailbox'))
    <span class="help-block">
        <strong>{{ $errors->first('mailbox') }}</strong>
    </span>
    @endif
</fieldset>
<fieldset class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
    <label for="">{{ !empty($emailBox) ? 'Change ' : '' }}Password</label>
    <input name="password" type="password" class="form-control" value="" autocomplete="new-password">
    @if ($errors->has('password'))
    <span class="help-block">
        <strong>{{ $errors->first('password') }}</strong>
    </span>
    @endif
</fieldset>