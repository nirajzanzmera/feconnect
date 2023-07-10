<div class="row form-group{{ $errors->has('name') ? ' has-error' : '' }}">
    <label class="col-md-2 form-control-label">Name</label>
    <div class="col-md-6">
        <input type="text" class="form-control" name="name" value="{{ old('name', !empty($newsletter->name) ? $newsletter->name : NULL ) }}">
        @if ($errors->has('name'))
        <span class="help-block">
            <strong>{{ $errors->first('name') }}</strong>
        </span>
        @endif
    </div>
</div>
<div class="row form-group{{ $errors->has('website_id') ? ' has-error' : '' }}">
    <label class="col-md-2 form-control-label">Dataczar Website</label>
    <div class="col-md-6">
        <select name="website_id" id="website_id" class="form-control">
            <option></option>
            @foreach ( $websites as $website)
            <option value="{{ $website->id }}" {{ ( isset($newsletter->website_id) && $website->id === $newsletter->website_id ) ? 'selected' : '' }}>{{ $website->name }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="row form-group{{ $errors->has('feed_id') ? ' has-error' : '' }}">
    <label class="col-md-2 form-control-label">Feed</label>
    <div class="col-md-6">
        <select name="feed_id" id="feed_id" class="form-control">
            <option></option>
            @foreach ( $feeds as $feed)
            <option value="{{ $feed->id }}" {{ ( !empty($newsletter->feed_id) && $feed->id === $newsletter->feed_id ) ? 'selected' : '' }}>{{ $feed->display }}</option>
            @endforeach
            
        </select>
    </div>
</div>
<div class="row form-group{{ $errors->has('name') ? ' has-error' : '' }}">
    <label class="col-md-2 form-control-label">How many posts to fetch?</label>
    <div class="col-md-6">
        
        <select name="post_limit" class="form-control">
            @for($i = 0; $i < 10; $i++)
            <option {{ ($newsletter->post_limit == $i) ? 'selected' : '' }}>{{ $i }}</option>
            @endfor
        </select>
        @if ($errors->has('post_limit'))
        <span class="help-block">
            <strong>{{ $errors->first('post_limit') }}</strong>
        </span>
        @endif
    </div>
</div>

@section('js2')
<script type="text/javascript">
$(document).ready(function(){
    $('#website_id').on('change', function(){
        var myVal = $(this).val();
        if(myVal !== ''){
            $('#feed_id').val('')
        }
    });
    $('#feed_id').on('change', function(){
        var myVal = $(this).val();
        if(myVal !== ''){
            $('#website_id').val('')
        }
    });
});
</script>

@endsection
{{-- 
<div class="row form-group{{ $errors->has('name') ? ' has-error' : '' }}">
    <label class="col-md-2 form-control-label">Native Slots (ads)</label>
    <div class="col-md-6">
        <select name="ad_limit" class="form-control">
            @for($i = 0; $i < 10; $i++)
            <option {{ ($newsletter->ad_limit == $i) ? 'selected' : '' }}>{{ $i }}</option>
            @endfor
        </select>
        @if ($errors->has('ad_limit'))
        <span class="help-block">
            <strong>{{ $errors->first('ad_limit') }}</strong>
        </span>
        @endif
    </div>
</div>
 --}}
