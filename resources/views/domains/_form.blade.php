

<div class="row form-group{{ $errors->has('domain') ? ' has-error' : '' }}">
    <label class="col-md-2 form-control-label" style="text-align:right">From Name</label>
    <div class="col-md-8">
        <input type="text" class="form-control" name="domain" value="{{ old('domain', !empty($domain->domain) ? $domain->domain : NULL ) }}" required>
        @if ($errors->has('domain'))
        <span class="help-block">
            <strong>{{ $errors->first('domain') }}</strong>
        </span>
        @endif
    </div>
</div>

</div>

