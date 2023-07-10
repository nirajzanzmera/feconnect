<style>
    .nopadding {
        padding: 0 5px 0 0 !important;
        margin: 0 !important;
    }
</style>
<div class="tab">
    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
        <label class="form-control-label">Website Name</label>
        <div class="">
            @if(Route::currentRouteName() === 'home')
            <input type="text" class="form-control" name="name" dusk="modal_name" value="{{ (!empty($team->name) && $team->name !== $g_user->name)  ? $team->name : NULL }}">
            @else
            <input type="text" class="form-control" name="name" dusk="modal_name" value="{{ old('name', (!empty($team->name)) ? $team->name : NULL ) }}">
            @endif
            @if ($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
            @endif
        </div>
    </div>
    @if(Route::currentRouteName() === 'home')
    <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
        <label class="form-control-label">Address</label>
        <div class="">
            <input type="text" class="form-control" name="address" value="{{ old('address', (!empty($team->address)) ? $team->address : NULL ) }}">
            @if ($errors->has('address'))
            <span class="help-block">
                <strong>{{ $errors->first('address') }}</strong>
            </span>
            @endif
        </div>
    </div>
    {{--<div class="form-group{{ $errors->has('address_2') ? ' has-error' : '' }}">--}}
        {{--<label class=" form-control-label">Address 2</label>--}}
        {{--<div class="">--}}
            {{--<input type="text" class="form-control" name="address_2" value="{{ old('address_2', (!empty($team->address_2)) ? $team->address_2 : NULL ) }}">--}}
            {{--@if ($errors->has('address_2'))--}}
            {{--<span class="help-block">--}}
                {{--<strong>{{ $errors->first('address_2') }}</strong>--}}
            {{--</span>--}}
            {{--@endif--}}
        {{--</div>--}}
    {{--</div>--}}
    <div class="col-xs-4 col-md-4 nopadding form-group{{ ($errors->has('city')) ? ' has-error' : '' }}">
        <label class=" form-control-label">City</label>
        <div class="">
            <input type="text" class="form-control" name="city" value="{{ old('city', (!empty($team->city)) ? $team->city : NULL ) }}">
            @if ($errors->has('city'))
            <span class="help-block">
                <strong>{{ $errors->first('city') }}</strong>
            </span>
            @endif
        </div>
    </div>
    <div class="col-xs-4 col-md-4 nopadding form-group{{ ($errors->has('state')) ? ' has-error' : '' }}">
        <label class="form-control-label">State</label>
        <div class="">
            <input type="text" class="form-control" name="state" value="{{ old('state', (!empty($team->state)) ? $team->state : NULL ) }}">
            @if ($errors->has('state'))
            <span class="help-block">
                <strong>{{ $errors->first('state') }}</strong>
            </span>
            @endif
        </div>
    </div>
    <div class="col-xs-4 col-md-4 nopadding form-group{{ ($errors->has('zip')) ? ' has-error' : '' }}">
        <label class="form-control-label">Zip</label>
        <div class="">
            <input type="text" class="form-control" name="zip" value="{{ old('zip', (!empty($team->zip)) ? $team->zip : NULL ) }}">
            @if ($errors->has('zip'))
            <span class="help-block">
                <strong>{{ $errors->first('zip') }}</strong>
            </span>
            @endif
        </div>
    </div>
    <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
        <label class="form-control-label">Phone</label>
        <div class="">
            @if(Route::currentRouteName() === 'home')
            <input type="text" class="form-control" name="phone" value="">
            @else
            <input type="text" class="form-control" name="phone" value="{{ old('phone', (!empty($team->phone)) ? $team->phone : auth()->user()->phone ) }}">
            @endif
            @if ($errors->has('phone'))
            <span class="help-block">
                <strong>{{ $errors->first('phone') }}</strong>
            </span>
            @endif
        </div>
    </div>
    <input type="hidden" name="interview" id="interview_complete" value="true">
    <div class="form-group{{ $errors->has('use_public') ? ' has-error' : '' }}">
        <label class="form-control-label"></label>
        <div class="">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="use_public" id="use_public"
                {{ old('use_public',
                    (!empty($team->use_public) || isset($settings->interview) && $settings->interview == 'pending') ? 'checked' : '') }} value="1">
                <label class="form-check-label" for="contact_us">Display this address and phone number on my website</label>
                @if ($errors->has('use_public'))
                <span class="help-block">
                    <strong>{{ $errors->first('use_public') }}</strong>
                </span>
                @endif
            </div>
        </div>
    </div>
    @else
        @if(($headless ?? false) != true)
        @if(Route::currentRouteName() == 'teams.edit')
        <p>
            <em>You can edit your website contact details on the <a href="{{ route('websites.edit', App\Website::first()) }}">Website Settings page</a>.</em>
        </p>
        @endif
        @endif
    @endif
</div>
@if(Route::currentRouteName() !== 'home')
<div class="row form-group{{ $errors->has('timezone') ? ' has-error' : '' }}">
    <label class="col-md-2 form-control-label">Timezone</label>
    <div class="col-md-9">
        <select name="timezone" class="form-control">
            <option></option>
            @foreach($timezones as $key => $value)
            @if(old('timezone', !empty($team->timezone) ? $team->timezone : NULL ) == $key)
            <option value="{{ $key }}" selected>
                {{ $key }}
            </option>
            @else
            <option value="{{ $key }}">
                {{ $key }}
            </option>
            @endif
            @endforeach
        </select>
        @if ($errors->has('timezone'))
        <span class="help-block">
            <strong>{{ $errors->first('timezone') }}</strong>
        </span>
        @endif
    </div>
</div>
@endif
@if(Route::currentRouteName() === 'home')
<div class="tab" style="{{ Route::currentRouteName() == 'home' ? 'display:none' : ''}}">
    <div id="socialform">
        @foreach(['facebook','twitter','linkedin','instagram', 'youtube', 'yelp'] as $field)
        <div class="row form-group{{ $errors->has($field) ? ' has-error' : '' }}">
            <label class="col-xs-2 col-md-2 form-control-label" style="text-align: right">
                <i class="fa fa-{{ ($field == 'website') ? 'globe' : $field }}" title="{{ $field }}"></i>
            </label>
            <div class="col-xs-9 col-md-9 ">
                <input type="text" class="form-control" name="{{ $field }}" ref="input-{{ $field }}" v-model="config.{{ $field }}.value" :placeholder="config.{{ $field }}.placeholder" v-on:blur="valid_input('{{ $field }}')">
                <div class="alert alert-warning" v-cloak v-if="config.{{ $field }}.invalid" >
                    <div v-html="config.{{ $field }}.suggestion"></div>
                    <a class="btn btn-default" v-on:click="use_suggestion('{{ $field }}')">Use Suggestion</a>
                </div>
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
@endif
@if(Route::currentRouteName() !== 'home' && ( empty(session('currentTeam')) ) )
<hr>
<div class="row form-group">
    <label class="col-md-2 form-control-label"></label>
    <div class="col-md-9">
        <div class="form-check">
            <input type="checkbox" class="form-check-input" value="1" name="menu_suppression"
            {{ (isset($team->pivot) && $team->pivot->menu_suppression == true) ? 'checked' : '' }}>
            <label class="form-check-label" for="menu_suppression">Remove from Account Switcher</label>
            <br /><small>Will only affect you, not other users with access to this account.</small>
        </div>
    </div>
</div>
<hr>
@endif

@section('js2')
    @include('fe.teamwork._social')
@endsection