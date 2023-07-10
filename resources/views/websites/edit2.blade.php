@extends('layouts.app')



@section('content')
@if($headless != true and $hidetitle != true)
<div>
    <h1 class="page-heading">Websites</h1>
</div>
@endif

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
                        <h4 class="card-title">{{ $website->name }} - Settings</h4>
                    </div>

                </div>
            </div>
            <div class="card-block">
                <form action="{{ route('websites.update', $website) }}" method="POST" id="website_form">
                <div class="row">
              
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="col-lg-6">

<legend>Business Information</legend>

<div class="row form-group {{ $errors->has('name') ? ' has-error' : '' }}">
    <label class="col-md-2 form-control-label" style="text-align:right">Website Name</label>
    <div class="col-md-8">
        <input type="text" class="form-control form-control-success" name="name"
            value="{{ old('name', !empty($website->name) ? $website->name : NULL ) }}">
        @if ($errors->has('name'))
        <span class="help-block">
            <strong>{{ $errors->first('name') }}</strong>
        </span>
        @endif
    </div>
</div>
{{-- TODO: be sure email is implemented --}}
@foreach(['address', 'address_2', 'city', 'state', 'zip', 'phone', 'email'] as $field)
<fieldset class="form-group {{ $errors->has($field) ? ' has-error' : '' }}">
    <label for="address_1" class="col-md-2 form-control-label" style="text-align:right">
        {{ ucwords(str_replace('_', ' ', $field)) }}
    </label>
    <div class="col-md-8">

        <input id="{{ $field }}" class='form-control colorpicker' name="{{ $field }}"
            value="{{ old($field, isset($website->street_address->{$field}) ? $website->street_address->{$field} : NULL ) }}" />
    </div>
    @if ($errors->has($field))
    <span class="help-block">
        <strong>{{ $errors->first($field) }}</strong>
    </span>
    @endif
</fieldset>
@endforeach

<legend>Social Links</legend>


<div id="socialform">
    @foreach([/* 'website', */'facebook','twitter','linkedin','instagram', 'youtube', 'yelp'] as $field)
    <div class="row form-group{{ $errors->has($field) ? ' has-error' : '' }}">
        <label class="col-md-2 form-control-label" style="text-align: right">
            <i class="fa fa-{{ ($field == 'website') ? 'globe' : $field }}" title="{{ $field }}"></i>
        </label>
        <div class="col-md-9">
            <input type="text" class="form-control" dusk="{{ $field }}" name="{{ $field }}" >
            @if ($errors->has($field))
            <span class="help-block">
                <strong>{{ $errors->first($field) }}</strong>
            </span>
            @endif
        </div>
    </div>
    @endforeach
</div>

</div>

<div class="col-lg-6">
    <legend>Logo</legend>
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
            If you don't have a logo, you can use our <a href="http://logo.dataczar.com" target="_blank">Logo tool</a> to create one.
        </div>
    </fieldset>

    <legend>Engagement</legend>
    <div class="row form-group {{ $errors->has('use_public') ? ' has-error' : '' }}">
        <label class="col-md-2 form-control-label" style="text-align:right"></label>
        <div class="col-md-8">
            <div class="form-check">
                <label class="form-check-label" for="use_public">
                    <input class="form-check-input" type="checkbox" id="use_public" name="use_public"
                        {{ (old('use_public', !empty($website->use_public) ? $website->use_public : NULL ) == 1 ) ? 'checked' : ''  }}>
                    Include Business Address
                </label>
            </div>
            @if ($errors->has('use_public'))
            <span class="help-block">
                <strong>{{ $errors->first('use_public') }}</strong>
            </span>
            @endif
        </div>
    </div>
    <div class="row form-group {{ $errors->has('use_public') ? ' has-error' : '' }}">
        <label class="col-md-2 form-control-label" style="text-align:right"></label>
        <div class="col-md-8">
            <div class="form-check">
                <label class="form-check-label" for="use_public">
                    <input class="form-check-input" type="checkbox" id="use_public" name="use_public"
                        {{ (old('use_public', !empty($website->use_public) ? $website->use_public : NULL ) == 1 ) ? 'checked' : ''  }}>
                    Include a Map to Your Address
                </label>
            </div>
            @if ($errors->has('use_public'))
            <span class="help-block">
                <strong>{{ $errors->first('use_public') }}</strong>
            </span>
            @endif
        </div>
    </div>
    <div class="row form-group {{ $errors->has('newsletter_signup') ? ' has-error' : '' }}">
        <label class="col-md-2 form-control-label" style="text-align:right"></label>
        <div class="col-md-8">
            <div class="form-check">
                <label class="form-check-label" for="newsletter_signup">
                    <input class="form-check-input" type="checkbox" id="newsletter_signup" name="newsletter_signup"
                        {{ (old('newsletter_signup', !empty($website->newsletter_signup) ? $website->newsletter_signup : NULL ) == 1 ) ? 'checked' : ''  }}>
                    Include Newsletter Signup
                </label>
            </div>
            @if ($errors->has('newsletter_signup'))
            <span class="help-block">
                <strong>{{ $errors->first('newsletter_signup') }}</strong>
            </span>
            @endif
        </div>
    </div>
    {{-- TODO: implement newsletter_prompt --}}
    <div class="row form-group">
        <div class="col-md-2"></div>
        <label class="col-md-2 form-control-label" style="text-align: right">
            Prompt:
        </label>
        <div class="col-md-5">
            <input type="text" class="form-control" dusk="newsletter_prompt" name="newsletter_prompt" value="Sign Up for our Newsletter!">
        </div>
        <div class="col-md-1">                        
            <a class="btn btn-xs q-mark pull-right" tabindex="0" data-toggle="popover" data-placement="left" title="Newsletter Prompt" data-content="
                <ul>
                    <li>This text will appear on your website next to the newsletter sign up form at the bottom of every page.</li>
                </ul>
                ">
                <i class="fa fa-btn fa-question-circle"></i>
            </a>
        </div>
    </div>
    <div class="row form-group {{ $errors->has('powered_by') ? ' has-error' : '' }}">
        <label class="col-md-2 form-control-label" style="text-align:right"></label>
        <div class="col-md-8">
            <div class="form-check">
                <label class="form-check-label" for="powered_by">
                    <input class="form-check-input" type="checkbox" id="powered_by" name="powered_by"
                        {{ (old('powered_by', !empty($website->powered_by) ? $website->powered_by : NULL ) == 1 ) ? 'checked' : ''  }}>
                    Include Powered by Dataczar Image
                </label>
            </div>
            @if ($errors->has('powered_by'))
            <span class="help-block">
                <strong>{{ $errors->first('powered_by') }}</strong>
            </span>
            @endif
        </div>
    </div>



    <legend>Defaults</legend>

    <div class="row form-group">
        <label class="col-md-2 form-control-label" style="text-align:right"></label>
        <div class="col-md-8">
            <div class="form-check">
                <label class="form-check-label" for="default_website">
                {{--  {{  $website->id }} == {{ $website->team->default_website_id  }}<br /> --}}
                    @if($website->id == $website->team->default_website_id)
                    <i class="fa fa-check-square-o"></i>
                    Default Website
                    @else
                    <input class="form-check-input" type="checkbox" id="default_website" name="default_website">
                    Make Default Website
                    @endif
                </label>
            </div>
        </div>
    </div>

    <div class="row form-group">
        <label class="col-md-2 form-control-label" style="text-align:right"></label>
        <div class="col-md-8">
            <label class="form-check-label" for="default_list_id">
                Newsletter List
            </label>
            <select name="default_list_id" class="form-control">
                @foreach ($lists as $list)
                    @if ($list->id == optional($website->default_list)->id)
                        <option value="{{ $list->id }}" selected>
                            {{ $list->name }}
                        </option>
                    @else
                        <option value="{{ $list->id }}">
                            {{ $list->name }}
                        </option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>



    @if (!empty($website))
    <legend>Advanced</legend>
    <div class="row form-group {{ $errors->has('nav_color') ? ' has-error' : '' }}">
        <label class="col-md-2 form-control-label">&nbsp;</label>
        <div class="col-md-6">
            <a href="#" class="btn btn-default btn-sm" data-toggle="collapse" data-target="#collapseExample">
                <i class="fa fa-plus"></i>
                Show Advanced
            </a>
        </div>
    </div>
    <div class="collapse" id="collapseExample">
        <legend>Settings</legend>
        <fieldset class="form-group {{ $errors->has('logo') ? ' has-error' : '' }}">
            <label for="logo" class="col-md-2 form-control-label"
                style="text-align:right">Favicon</label>
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
            <div class="col-md-1">                        
                <a class="btn btn-xs q-mark pull-right" tabindex="0" data-toggle="popover" data-placement="left" title="Custom Favicon" data-content="
                    <ul>
                        <li>Your Favicon is the icon that appears at the top of the browser next to your URL.</li>
                        <li>This icon will appear when visitors bookmark your site.</li>
                        <li>Dataczar will generate an automatic default Favicon for you, but you can choose a custom Favicon using this option.</li>
                        <li>For best results a Favicon image should be square shaped.</li>
                    </ul>
                    ">
                    <i class="fa fa-btn fa-question-circle"></i>
                </a>
            </div>
        </fieldset>
        {{-- TODO: implement noindex --}}
        <fieldset class="form-group">
            <label class="col-md-2 form-control-label" style="text-align:right"></label>
            <div class="col-md-8">
                <div class="form-check">
                    <label class="form-check-label" for="noindex">
                        <input class="form-check-input" type="checkbox" id="noindex" name="noindex">
                        Hide Your Website from Search Engines
                    </label>
                </div>
            </div>
            <div class="col-md-1">                        
                <a class="btn btn-xs q-mark pull-right" tabindex="0" data-toggle="popover" data-placement="left" title="Hide Your Website from Search Engines" data-content="
                    <ul>
                        <li>Normally Dataczar includes information in your website that allows search engines to find and search your website.</li>
                        <li>If you don't want people to be able to find your website on search engines check this box.</li>
                    </ul>
                    ">
                    <i class="fa fa-btn fa-question-circle"></i>
                </a>
            </div>
        </fieldset>
        @if(Auth::user()->admin == true )
            <legend>Feed Import</legend>
            <fieldset class="form-group{{ $errors->has('feeds') ? ' has-error' : '' }}">
                <label class="col-md-2 form-control-label" style="text-align:right" for="feed_website.feed_id">Feed</label>
                <select name="feed_website-feed_id" id="feed_website-feed_id" class="form-control col-md-6">
                    <option value=""
                        {{
                    (old('feed_website-feed_id', !empty($website->feeds->first()->id) ? $website->feeds->first()->id : NULL ) == NULL) ? ' selected' : ''}}>
                    </option>
                    @foreach($feeds as $feed)
                    <option value="{{ $feed->id }}" {{
                        (old('feed_website-feed_id', !empty($website->feeds->first()->id) ? $website->feeds->first()->id : NULL ) == $feed->id) ? ' selected' : ''
                    }}>
                        {{ $feed->name ?? $feed->url }}
                    </option>
                    @endforeach
                </select>
                <a href="{{ route('feeds.index') }}">Add Feed</a>
                @if ($errors->has('feeds'))
                <span class="help-block">
                    <strong>{{ $errors->first('feeds') }}</strong>
                </span>
                @endif
            </fieldset>
            <fieldset id="range" class="form-group{{ $errors->has('status') ? ' has-error' : '' }}"
                style="display: {{ !empty($website->feeds->first()->id) ? 'block;' : 'none;' }}">
                <label class="col-md-2 form-control-label" style="text-align:right" for="feed_website-range">Range</label>
                <select name="feed_website-range" id="feed_website-range" class="form-control col-md-2">
                    @foreach(['all', 'new'] as $val)
                    <option value="{{ $val }}" {{
                        (old('feed_website-range', !empty($website->feeds->first()->pivot->range) ? $website->feeds->first()->pivot->range : NULL ) == $val) ? ' selected' : ''
                    }}>{{ $val }}</option>
                    @endforeach
                </select>
            </fieldset>
            <fieldset id="recurring" class="form-group{{ $errors->has('status') ? ' has-error' : '' }}"
                style="display: {{ !empty($website->feeds->first()->id) ? 'block;' : 'none;' }}">
                <label class="col-md-2 form-check-label" style="text-align:right"
                    for="feed_website-recurring">Recurring</label>
                {{-- default to checked if non-existent --}}
                <input class="col-md-1 form-check-input" style="align:left" type="checkbox" name="feed_website-recurring"
                    value="1" {{
                    old('feed_website-recurring',
                        ( !empty($website->feeds->first()->pivot->recurring)
                            ? true
                            : ( isset($website->feeds->first()->pivot->recurring)
                                ? false
                                : true ) ) )
                        ? ' checked'
                        : ''
                }}>
            </fieldset>
        @endif

        <legend>Global</legend>
        @if(Auth::user()->admin == true )
        <fieldset class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
            <label class="col-md-2 form-control-label" style="text-align:right" for="status">Header Scripts - admin
                only</label>
            <textarea name="scripts" id="scripts" class="form-control col-md-8">{{ $website->scripts ?? '' }}</textarea>
            @if ($errors->has('scripts'))
            <span class="help-block">
                <strong>{{ $errors->first('scripts') }}</strong>
            </span>
            @endif
        </fieldset>
        @endif

        <div class="row form-group {{ $errors->has('adsense_id') ? ' has-error' : '' }}">
            <label class="col-md-2 form-control-label" style="text-align:right">adsense id</label>
            <div class="col-md-8">
                <input type="text" class="form-control form-control-success" name="adsense_id"
                    value="{{ old('adsense_id', !empty($website->adsense_id) ? $website->adsense_id : NULL ) }}"
                    placeholder="ca-pub-0000000000000000">
                @if ($errors->has('adsense_id'))
                <span class="help-block">
                    <strong>{{ $errors->first('adsense_id') }}</strong>
                </span>
                @endif
            </div>
        </div>
    </div>
    @endif
</div>

                    <div class="row form-group">
                        <div class="col-md-8 col-md-offset-2">
                            <button class="btn btn-success" type="submit" id="submit_btn">Update</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<style type="text/css">
    .placeholder {
        height: 50px;
    }
</style>


 <script src="{{ mix('/stuff/standalone.js') }}"></script> 

<script src="//cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/spectrum.min.js"></script>
{{-- @include('layouts.partials._filemanager') --}}
<script type="text/javascript">
$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('[data-toggle="popover"]').popover({
      trigger: 'focus', 
      html: true,
    });


    window.dirty = false;
    $('.form-control, .form-check-input').on('change', function(e) {
        window.dirty = true;
    });
    window.onbeforeunload = function() {
        if(window.dirty) {
            return "Are you sure you want to navigate away?";
        }
    }
    $('#submit_btn').on('click', function(e){
        e.preventDefault();
        window.dirty = false;
        $('#submit_btn').attr("disabled", true);
        $('#website_form').submit();
    });

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
@include('teamwork._web_social')
@endsection


@section('css')
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/spectrum.min.css">
<style type="text/css">
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