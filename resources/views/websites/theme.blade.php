@extends('layouts.app')



@section('content')
<div>
    <h1 class="page-heading">Websites</h1>
</div>

@include('websites._nav')

@if($errors->count() > 0)
<div class="alert alert-danger">
    @foreach ($errors->all() as $error)
    <div>{{ $error }}</div>
    @endforeach
</div>
@endif
<div class="row-fluid" id="app">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="media">
                    <div class="media-body media-middle">
                        <h4 class="card-title">{{ $website->name }}</h4>
                    </div>

                </div>
            </div>
            <div class="card-block">
                <form action="{{ route('websites.theme', $website) }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="row">
                        <div class="col-lg-12">
                            <legend>Theme</legend>
                            <div class="row form-group {{ $errors->has('template_id') ? ' has-error' : '' }}">
                                <label class="col-md-2 form-control-label" style="text-align:center;">Current</label>
                                <div class="col-md-10">
                                <!-- DISPLAY CURRENT THEME HERE -->
                                @foreach($curtemplate as $template)
                                    {{-- @if(old('template_id', !empty($website->template_id) ? $website->template_id : NULL ) == $template->id) --}}
                                        <div class="tmp-thumb">
                                            <div class="row flex-column align-items-center justify-content-center" >
                                                <div class="theme-img-container" style="background-image: url('{{ $template->thumburl ?? '' }}'">
                                                </div>
                                                <h5 style="text-align:center; padding-top:10px;" class="tmp-title">{{ $template->name }}</h5>
                                            </div>
                                        </div>
                                    {{-- @endif --}}
                                @endforeach
                                </div>

                            </div>
                            <hr>
                            <div class="row form-group {{ $errors->has('template_id') ? ' has-error' : '' }}">
                                <label class="col-md-2 form-control-label" style="text-align:center">Options</label>
                                <!--<div class="col-md-2"></div>-->
                                <div class="col-md-10">
                                        @foreach($templates as $template)
                                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 " style="padding-block: 10px; ">
                                                <div class="tmp-thumb">
                                                    <div class="row flex-column align-items-center justify-content-center" >
                                                        <div class="theme-img-container" style="background-image: url('{{ $template->thumburl ?? '' }}'">
                                                        </div>
                                                        <h5 style="text-align:center; padding-top:10px;" class="tmp-title">{{ $template->name }}</h5>
                                                        @if(!(old('template_id', !empty($website->template_id) ? $website->template_id : NULL ) == $template->id)) 
                                                        <div class="btn-group">
                                                            <!--<a href="{{ route('websites.theme', ['website'=>$website, 'template'=>$template]) }}" class="btn btn-default">
                                                                <i class="fa fa-arrow-up"></i>
                                                                &nbsp;Choose Theme
                                                            </a>-->
                                                            <button type="submit" class=" btn btn-default" name="template_id" value="{{ $template->id }}" >
                                                                <i class="fa fa-arrow-up"></i>
                                                                &nbsp;Choose Theme
                                                            </button>

                                                        </div>
                                                        @else
                                                        <div class="btn-group">
                                                            <i>Current Theme</i>
                                                        </div>

                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @if ($errors->has('template_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('template_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <fieldset class="form-group {{ $errors->has('logo') ? ' has-error' : '' }}">
                                <label for="logo" class="col-md-2 form-control-label"
                                    style="text-align:right">Logo</label>
                                <div class="col-md-8">
                                    <standalone v-on:standalone="standalone" v-on:close="showFile = false;" name="logo"
                                        image="{{ old('logo', !empty($website->logo) ? $website->logo : NULL ) }}"
                                        search_url="{{ route('content.images.search') }}"
                                        downup_url="{{ route('content.downUp') }}"
                                        imagelist_url="{{ route('content.images.list') }}"
                                        filelist_url="{{ route('content.images.list', ['show_files'=>true]) }}"
                                        event_url="{{ route('images.event') }}" folder="{{ $folder }}" sig="{{ $sig }}">
                                    </standalone>
                                </div>
                            </fieldset>


                            <legend>Advanced</legend>
                            <div class="row form-group {{ $errors->has('nav_color') ? ' has-error' : '' }}">
                                <label class="col-md-2 form-control-label">&nbsp;</label>
                                <div class="col-md-6">
                                    <a href="#" class="btn btn-default btn-sm" data-toggle="collapse"
                                        data-target="#collapseExample">
                                        <i class="fa fa-plus"></i>
                                        Show Advanced
                                    </a>
                                </div>
                            </div>


                            <div class="collapse" id="collapseExample">
                                <fieldset class="form-group {{ $errors->has('bg_image') ? ' has-error' : '' }}">
                                    <label for="bg_image" class="col-md-2 form-control-label" style="text-align:right">Background Image</label>
                                    <div class="col-md-8">
                                        <standalone v-on:standalone="standalone" v-on:close="showFile = false;" name="bg_image"
                                            image="{{ old('bg_image', !empty($website->bg_image) ? $website->bg_image : NULL ) }}"
                                            search_url="{{ route('content.images.search') }}" downup_url="{{ route('content.downUp') }}"
                                            imagelist_url="{{ route('content.images.list') }}"
                                            filelist_url="{{ route('content.images.list', ['show_files'=>true]) }}"
                                            event_url="{{ route('images.event') }}" folder="{{ $folder }}" sig="{{ $sig }}">
                                        </standalone>
                                    </div>
                                </fieldset>

                                <div class="row form-group {{ $errors->has('nav_color') ? ' has-error' : '' }}">
                                    <label class="col-md-2 form-control-label" style="text-align:right">Color Scheme (for Main Template only</label>
                                    <div class="col-md-8">
                                        <select class="form-control" name="nav_color">
                                            @foreach(['is-white'=>'white','is-transparent'=>'transparent','is-black'=>'black','is-light'=>'off-white','is-dark'=>'dark-grey','is-primary'=>'turquoise','is-link'=>'blue','is-info'=>'cyan','is-success'=>'green','is-warning'=>'yellow','is-danger'=>'red']
                                            as $key=>$value)
                                            <option class="{{ $key }}" value="{{ $key }}" {{ 
                                                                        (old('nav_color', !empty($website->nav_color) ? $website->nav_color : NULL ) == $key ) ? ' selected' : ''
                                                                     }}>
                                                {{ ucwords($value) }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('nav_color'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('nav_color') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <fieldset
                                    class="form-group {{ $errors->has('nav_color_override') ? ' has-error' : '' }}">
                                    <label for="nav_color_override" class="col-md-2 form-control-label"
                                        style="text-align:right" title="Background Color">Color Override</label>
                                    <div class="col-md-8">
                                        <input id="nav_color_override" class='form-control colorpicker'
                                            name="nav_color_override"
                                            value="{{ old('nav_color_override', !empty($website->nav_color_override) ? $website->nav_color_override : NULL ) }}" />
                                    </div>
                                    @if ($errors->has('nav_color_override'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('nav_color_override') }}</strong>
                                    </span>
                                    @endif
                                </fieldset>

                                

                                <fieldset class="form-group {{ $errors->has('bg_color') ? ' has-error' : '' }}">
                                    <label for="bg_color" class="col-md-2 form-control-label" style="text-align:right"
                                        title="Background Color">Background Color</label>
                                    <div class="col-md-8">
                                        <input id="bg_color" class='form-control colorpicker' name="bg_color"
                                            value="{{ old('bg_color', !empty($website->bg_color) ? $website->bg_color : NULL ) }}" />
                                    </div>
                                    @if ($errors->has('bg_color'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('bg_color') }}</strong>
                                    </span>
                                    @endif
                                </fieldset>
                            </div>


                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12">

                            <button class="btn btn-success">Update</button>

                        </div>
                    </div>
            </div>
            </form>
        </div>
    </div>


</div>
@endsection

@section('js')

<script src="{{ mix('/stuff/standalone.js') }}"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/spectrum.min.js"></script>
{{-- @include('layouts.partials._filemanager') --}}
<script type="text/javascript">
    $(document).ready(function(){
    var settings = {
        color: "{{ isset($website->nav_color) ? $website->nav_color : '' }}",
        showInput: true,
        allowEmpty:true,
        className: "full-spectrum",
        showInitial: true,
        showPalette: true,
        showSelectionPalette: true,
        maxSelectionSize: 10,
        preferredFormat: "hex",
        localStorageKey: "spectrum.demo",
        palette:  [
        ["rgb(0, 0, 0)", "rgb(67, 67, 67)", "rgb(102, 102, 102)",        "rgb(204, 204, 204)", "rgb(217, 217, 217)","rgb(255, 255, 255)"],        ["rgb(152, 0, 0)", "rgb(255, 0, 0)", "rgb(255, 153, 0)", "rgb(255, 255, 0)", "rgb(0, 255, 0)",        "rgb(0, 255, 255)", "rgb(74, 134, 232)", "rgb(0, 0, 255)", "rgb(153, 0, 255)", "rgb(255, 0, 255)"],         ["rgb(230, 184, 175)", "rgb(244, 204, 204)", "rgb(252, 229, 205)", "rgb(255, 242, 204)", "rgb(217, 234, 211)",         "rgb(208, 224, 227)", "rgb(201, 218, 248)", "rgb(207, 226, 243)", "rgb(217, 210, 233)", "rgb(234, 209, 220)",         "rgb(221, 126, 107)", "rgb(234, 153, 153)", "rgb(249, 203, 156)", "rgb(255, 229, 153)", "rgb(182, 215, 168)",         "rgb(162, 196, 201)", "rgb(164, 194, 244)", "rgb(159, 197, 232)", "rgb(180, 167, 214)", "rgb(213, 166, 189)",         "rgb(204, 65, 37)", "rgb(224, 102, 102)", "rgb(246, 178, 107)", "rgb(255, 217, 102)", "rgb(147, 196, 125)",         "rgb(118, 165, 175)", "rgb(109, 158, 235)", "rgb(111, 168, 220)", "rgb(142, 124, 195)", "rgb(194, 123, 160)",        "rgb(166, 28, 0)", "rgb(204, 0, 0)", "rgb(230, 145, 56)", "rgb(241, 194, 50)", "rgb(106, 168, 79)",        "rgb(69, 129, 142)", "rgb(60, 120, 216)", "rgb(61, 133, 198)", "rgb(103, 78, 167)", "rgb(166, 77, 121)",        "rgb(91, 15, 0)", "rgb(102, 0, 0)", "rgb(120, 63, 4)", "rgb(127, 96, 0)", "rgb(39, 78, 19)",         "rgb(12, 52, 61)", "rgb(28, 69, 135)", "rgb(7, 55, 99)", "rgb(32, 18, 77)", "rgb(76, 17, 48)"]],
    };

    settings.color = '{{ isset($website->nav_color_override) ? $website->nav_color_override : '' }}';
    $("#nav_color_override").spectrum(settings);

    settings.color = '{{ isset($website->bg_color) ? $website->bg_color : '' }}';
    $("#bg_color").spectrum(settings);


    $('#feed_website-feed_id').change(function() {
        if ($(this).val() == "") {
            $("#range").hide();
            $("#recurring").hide();
        }
        else {
            $("#range").show();
            $("#recurring").show();
        }
    });
})
</script>
@endsection


@section('css')
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/spectrum.min.css">
<style type="text/css">
    .theme-img-container {
        background-size: contain;
        background-position: center;
        border:1px solid #EEEEEE;
        background-repeat: no-repeat;
        width:185px;
        height:140px;
        margin:2px;
        background-color: #EEEEEE;
    }
    .is-white {
        background: hsl(0, 0%, 100%);
    }

    .is-black {
        background: hsl(0, 0%, 4%);
    }

    .is-light {
        background: hsl(0, 0%, 96%);
    }

    .is-dark {
        background: hsl(0, 0%, 21%);
    }

    .is-primary {
        background: hsl(171, 100%, 41%);
    }

    .is-link {
        background: hsl(217, 71%, 53%);
    }

    .is-info {
        background: hsl(204, 86%, 53%);
    }

    .is-success {
        background: hsl(141, 71%, 48%);
    }

    .is-warning {
        background: hsl(48, 100%, 67%);
    }

    .is-danger {
        background: hsl(348, 100%, 61%);
    }
</style>

@endsection