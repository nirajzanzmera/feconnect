@extends('layouts.app')
@section('content')
<h1 class="page-heading">Create a new account</h1>
<div class="row-fluid">
	<div class="col-md-6 col-md-offset-3">
		<div class="card card-primary">
			<div class="card-block">
				<form method="post" action="{{route('teams.store')}}">
					{!! csrf_field() !!}
					@include('teamwork._form')
                    <div class="row form-group">
                        <div class="col-md-9 col-md-offset-2">
                            <button type="submit" class="btn btn-success">
                            <i class="fa fa-btn fa-save"></i> Create
                            </button>
                        </div>
                    </div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection

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
