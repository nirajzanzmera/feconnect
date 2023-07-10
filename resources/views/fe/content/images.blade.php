@extends('fe.layouts.app')
@section('content')

    @include('fe.content._nav')

    <div class="row" id="app">
        <div class="col-xl-12">
            <image-manager
                search_url="https://connect.dataczar.com/pexels/search"
                downup_url="https://connect.dataczar.com/images/down_up"
                imagelist_url="https://connect.dataczar.com/content/list"
                filelist_url="https://connect.dataczar.com/content/list?show_files=1"
                delete_url="https://connect.dataczar.com/image"
                event_url="https://connect.dataczar.com/images/event"
                folder="photos/675"
                sig="5afe6879eca85e70de39c093d1941b9a"
                context="content"
                file_sig="d4bd18ae099c03eaf101bb21441e324d"
                file_folder="files/675"
                type="page"
                field_name=""
                v-on:url="useImage"
                tools_link="https://connect.dataczar.com/content/content-tools"
                menu_off="1"
                default_tab="images" 
            >
            </image-manager>
        </div>
    </div>


@endsection

@section('css')
    <style type="text/css">
    </style>
@endsection

@section('js')
    @include('fe.layouts._popover')
    <script src="{{ asset('/stuff/images.js') }}"></script>
@endsection