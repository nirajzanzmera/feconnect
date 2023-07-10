@section('css')
<link rel="stylesheet" href="https://src.dzr.io/connect/4/examples/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="https://src.dzr.io/connect/4/examples/css/bootstrap-timepicker.min.css">
@endsection
@if($errors->count() > 0)
<div class="alert alert-danger">
    @foreach ($errors->all() as $error)
    <div>{{ $error }}</div>
    @endforeach
</div>
@endif
<div class="row">
    <div class="col-md-6">
        <fieldset class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
            <label for="title" class="post">Title</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Enter title"  value="{{ old('title', !empty($page->title) ? $page->title : NULL ) }}">
            @if($errors->has('title'))
            <span class="help-block">
                <strong>{{ $errors->first('title') }}</strong>
            </span>
            @endif
        </fieldset>
        <fieldset class="form-group {{ $errors->has('link') ? ' has-error' : '' }}">
            <label for="link" class="post">Link</label>
            <input type="text" class="form-control" id="link" name="link" placeholder="Enter link"  value="{{ old('link', !empty($page->link) ? $page->link : NULL ) }}">
            @if ($errors->has('link'))
            <span class="help-block">
                <strong>{{ $errors->first('link') }}</strong>
            </span>
            @endif
        </fieldset>
        <fieldset class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control">
                @foreach(['live','draft','archived'] as $val)
                @if( old('status', !empty($page->status) ? $page->status : 'live') == $val )
                <option value="{{ $val }}" selected>{{ ucwords($val) }}</option>
                @else
                <option value="{{ $val }}">{{ ucwords($val) }}</option>
                @endif
                @endforeach
                {{-- <option value="hide">DELETE</option> --}}
            </select>
            @if ($errors->has('status'))
            <span class="help-block">
                <strong>{{ $errors->first('status') }}</strong>
            </span>
            @endif
        </fieldset>
    </div>
    <div class="col-md-6">
        <fieldset class="form-group {{ $errors->has('menu') ? ' has-error' : '' }}">
            <label for="headline" class="post">Select Menu(s) to add {{ $type }} to:</label>
            @foreach($website->menus as $menu)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="menu[]" value="{{ $menu->id }}" id="menu_{{ $menu->id }}" {{ ( !empty($page) && !empty($page->menus->where('id', $menu->id)->first())) || ( !empty($menu_id) && $menu_id == $menu->id)  ? ' checked' : '' }}>
                <label class="form-check-label" for="menu_{{ $menu->id }}">
                    {{ $menu->name }}
                </label>
            </div>
            @endforeach
        </fieldset>
    </div>
</div>

@section('js')
<script type="text/javascript">
    $(document).ready(function(){
        $('#submit_btn').on('click', function(e){
            e.preventDefault();
            $('#submit_btn').attr("disabled", true);
            $('#page_form').submit();
        });
    });
</script>

<script src="https://src.dzr.io/connect/4/assets/vendor/bootstrap-datepicker.min.js"></script>
<script src="https://src.dzr.io/connect/4/assets/vendor/bootstrap-timepicker.js"></script>
@endsection

