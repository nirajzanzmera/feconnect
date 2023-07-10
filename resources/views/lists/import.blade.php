@extends('layouts.app')
@section('content')
<div>
	<a href="{{ route('lists.index' )}}" class="btn btn-default btn-sm pull-right" style="margin-top: 22px;">
		<i class="fa fa-arrow-left"></i> Back
	</a>
	<h1 class="page-heading">List - Import</h1>
</div>
<div class="row-fluid">
	<div class="col-md-12">
    	<div class="card">
			<div class="card-header">
				Import : <strong>{{ $file->original_filename }}</strong> : into : <strong>{{ $file->list->name }}</strong>
			</div>

				<form method="post" action="{{route('lists.import', $file)}}">
					{!! csrf_field() !!}
					<table class="table table-bordered table-striped">
						<thead>
                            <tr>
                                <th colspan="5">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" name="header_row" id="header_row" type="checkbox" value="true">
                                            Does the file include a header row?
                                        </label>
                                    </div>
                                </th>
                            </tr>
                            <tr>
                                <th>#</th>
                                <th>Type</th>
                                <th>Label</th>
                                <th>Row 1 from File</th>
                                <th>Row 2 from file</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($head as $key => $col)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td class="{{ $errors->has("col_" . $key) ? ' has-error' : '' }}">
                                    <select class="form-control drops" name="{{ "col_".$key }}">
                                        <option value="">--- Select ---</option>
                                        @foreach ($colTypes as $k => $val)
                                            <option value="{{ $k }}"
                                                @if($email_key === $key && $val == 'email')
                                                    selected
                                                @elseif($val == 'custom' && $email_key !== $key)
                                                    selected
                                                @endif
                                                >
                                                {{ $val }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has("col_".$key))
                                    <span class="help-block">
                                        <strong>{{ $errors->first("col_".$key) }}</strong>
                                    </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="form-group {{ ($errors->first("custom_col_".$key)) ? 'has-danger' : '' }}">
                                        <input type="text" class="form-control" name="custom_col_{{$key}}" id="custom_col_{{$key}}" value="{{ old("custom_col_".$key) }}"
                                        {{ ($email_key === $key) ? 'disabled': '' }}>
                                        <span class="help-block">
                                            <strong>{{ $errors->first("custom_col_".$key) }}</strong>
                                        </span>
                                    </div>
                                </td>
                                <td class="head_{{ $key }}">
                                    {{ $col }}
                                </td>
                                <td>  
                                    {{ isset($body[0][$key]) ? $body[0][$key] : '' }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                       
						<tfoot>
							<tr>
								<td colspan="5">
									<div class="row form-group" style="padding-left: 25px;">
											<input type="hidden" name="cols" value="{{ count($head) }}">
											<button type="submit" class="btn btn-success">
												<i class="fa fa-btn fa-save"></i> Start Import
											</button>
                                            <a href="{{ route('lists.upload', $file->list) }}" class="btn btn-warning">
                                                <i class="fa fa-btn fa-times-circle"></i>
                                                Cancel
                                            </a>
									</div>
								</td>
							</tr>
						</tfoot>
					</table>
				</form>

		</div>
	</div>
</div>
@endsection

@section('js')
<script type="text/javascript">
    $(document).ready(function(){
        $('.drops').on('change', function(){
            var myVal = $(this).val();
            var myName = '#custom_' + $(this).attr('name');
            if(myVal == 'ignore') {
                $( myName).prop('disabled', true);
                $( myName).val('');
            } else {
                $( myName).prop('disabled', false);
            }
        });
        var head = {!! json_encode($head) !!};
        $('#header_row').on('click', function(e){
            var myState = $(this).prop('checked');
            if (myState) {
                $.each(head, function(key, value){
                    var inputCol = '#custom_col_' + key;
                    if ($(inputCol).prop('disabled') != true ) {
                        $(inputCol).val(value);
                    }
                })
            } else {
                $.each(head, function(key, value){
                    var inputCol = '#custom_col_' + key;
                    if ($(inputCol).prop('disabled') != true ) {
                        $(inputCol).val('');
                    }
                })
            }
        });
    });
</script>
@endsection
