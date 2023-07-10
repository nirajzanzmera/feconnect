<div class="btn-group">
    <a href="{{ route('domains.edit', $domain->id) }}"
        class="btn btn-default{{ Route::currentRouteName() == 'domains.edit' ? '  btn-primary active' : '' }}">Hosting</a>
    <a href="{{ route('domains.advanced', $domain->id) }}"
        class="btn btn-default{{ Route::currentRouteName() == 'domains.advanced' ? '  btn-primary active' : '' }}">Advanced</a>
</div>
<hr>