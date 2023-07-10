<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
                {{ $domain->domain }} - Settings Summary
            </h4>
        </div>
        <div class="card-block">
            <div class="alert alert-info">
                <em>
                    You have changed your nameserver profile to a custom profile. Dataczar cannot
                    update your hosting or email records if you are not using Dataczar DNS as your nameserver.
                    <br /><br />
                    To edit your hosting <a href="{{ route('domains.advanced.lock', $domain) }}">click here to edit your nameservers</a> and choose Dataczar
                    DNS.
                </em>
            </div>
        </div>
    </div>
</div>