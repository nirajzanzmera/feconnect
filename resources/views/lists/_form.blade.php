<form method="post" action="{{ route('lists.store') }}" id="lists_form">
    {!! csrf_field() !!}
    
    <div class="row form-group{{ $errors->has('name') ? ' has-error' : '' }}">
        <label class="col-md-2 form-control-label">Name</label>
        <div class="col-md-6">
            <input type="text" class="form-control" name="name" value="{{ old('name') }}">
            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
    </div>
    
    <div class="row form-group">
        <div class="col-md-6 col-md-offset-2">
            <button type="submit" class="btn btn-success">
            <i class="fa fa-btn fa-save"></i> Create
            </button>
        </div>
    </div>
</form>


@section('js2')
<script type="text/javascript">
$(document).ready(function(){
    $("form").submit(function (e) {
        $(".btn").attr("disabled", true);
        return true;
    });
});
</script>
@endsection
