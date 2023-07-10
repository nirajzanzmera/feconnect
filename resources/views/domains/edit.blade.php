@extends('fe.layouts.app')

@section('css')
<style>
    .form-control-label {
        font-weight: bold;
    }
</style>
@endsection

@section('content')
@include('domains._nav')
<div class="row-fluid" id="app">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    {{ $domain->domain }}  - Hosting
                </h4>
            </div>
            <div class="card-block">
                <form method="POST" action="{{ route('domains.update', $domain->id) }}">
                    {{ method_field('PUT') }}
                    {!! csrf_field() !!}

                    @include('domains._settings_nav')

                    <div class="row form-group">
                        <label class="form-control-label">Select site for www.{{ $domain->domain }}:</label>
                        {{-- websites variable not available  --}}
                        @if (!empty($websites)) 
                        <select class="form-control" name="website_id" v-model="website_id">
                            @foreach($websites as $website)
                            <option value="{{ $website->id }}"
                                {{ (old('website_id', !empty($domain->website_id) ? $domain->website_id : NULL ) == $website->id) ? ' selected' : '' }}>
                                Website: {{ $website->name }}
                            </option>
                            @endforeach
                            <option value="0">Redirect to another URL</option>
                        </select>
                        @endif
                    </div>
                    
                    <div class="row form-group" v-cloak v-if="website_id == '' || website_id == 0">
                        <label class="form-control-label">Redirect</label>
                        
                            <input v-on:keyup="helper" type="text"
                                value="{{ old('forwards_to', !empty($url) ? $url->forwards_to : ""  ) }}"
                                class="form-control" name="forwards_to" placeholder="https://" v-model="forwards_to">
                            <input type="hidden" class="form-control" name="host" value="">

                            @if ($errors->has('forwards_to'))
                            <span class="help-block">
                                <strong>{{ $errors->first('forwards_to') }}</strong>
                            </span>
                            @endif
                        
                    </div>

                    <div class="row">
                        <div class="alert alert-info">
                            <em>
                                <strong>Note:</strong> Changes made here may take up 24 hours to propagate, though they
                                usually only take 5 minutes or less.
                            </em>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-8 col-md-offset-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-btn fa-save"></i> Update
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.17/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.17.1/axios.min.js"></script>
<script>
    var app = new Vue({
    el: '#app',
    data () {
        return {
            'selected': '{{ !empty($website) ? ($website->id ?? '') : null }}',
            'website_id': '{{ $domain->website_id ?? '' }}',
            'forwards_to': '{{ !empty($url) ? $url->forwards_to : "" }}'
        }
    },
    methods: {
        helper: function (event) {
            if(this.forwards_to == '') {
                this.website_id = this.selected;
            }
        }
    },
    mounted() {
       
    },
})
</script>
@endsection