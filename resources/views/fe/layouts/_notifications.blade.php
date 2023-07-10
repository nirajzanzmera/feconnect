<div id="notifications">
    <notifications ref="nots" nots_url="{{ route('notifications.data') }}"
        nots_index="{{ route('notifications.index') }}"
        base_url = "{{route('home')}}"
        mark_all="{{ route('notifications.markAll') }}"></notifications>
</div>