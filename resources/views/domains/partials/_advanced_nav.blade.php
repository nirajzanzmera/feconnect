<div class="btn-group">
    <a href="{{ route('domains.advanced.lock', $domain->id) }}"
        class="btn btn-default{{ Route::currentRouteName() == 'domains.advanced.lock' ? '  btn-primary active' : '' }}">
        <i class="fa fa-lock"></i>
        Domain Lock
    </a>
    <a href="{{ route('domains.advanced.index', $domain->id) }}"
        class="btn btn-default{{ Route::currentRouteName() == 'domains.advanced.index' ? '  btn-primary active' : '' }}"
        v-if="data.advanced_lock_status == false">
        <i class="fa fa-list-ol"></i>
        Name Servers
    </a>
</div>
<hr>