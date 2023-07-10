@extends( $window == true ? 'fe.layouts.guest' : 'fe.layouts.app')

@section('content')

@if($window)
    @include('fe.images._nav')
@else
    @include('fe.content._nav')
@endif
<div class="row" id="app">
    <div class="col-xl-12">
        <image-manager

            @if(isset($type) && $type=='icons')
                search_url="{{ route('content.flaticon.search') }}"
            @else
                search_url="{{ route('content.images.search') }}"
            @endif

            downup_url="{{ route('content.downUp') }}"
            imagelist_url="{{ route('content.images.list') }}"
            filelist_url="{{ route('content.images.list', ['show_files'=>true]) }}"
            delete_url="{{ route('content.images.delete') }}"
            event_url="{{ route('images.event') }}"
            view_url="{{ route('images.view') }}"
            file_view_url="{{ route('file.view') }}"
            folder="{{ $folder }}"
            sig="{{ $sig }}"
            context="{{ $context }}"
            file_sig="{{ $file_sig }}"
            file_folder="{{ $file_folder }}"
            type="{{ ($window) ? 'iframe' : 'page' }}"
            field_name="{{ $field_name }}"
            v-on:url="useImage"
            tools_link="{{ route('content.tools') }}"
            menu_off="{{ ($window) ? false : true }}"
            default_tab="{{ $tab }}"
        >
        </image-manager>
    </div>
</div>
@endsection

@section('js')

<script src="{{ mix('/stuff/images.js') }}"></script>

@endsection
