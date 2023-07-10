@extends('fe.layouts.app')
@section('content')
<div>
    <h1 class="page-heading">Upload</h1>
</div>
<ol class="breadcrumb">
    <li><a href="{{ route('homebc') }}">Home</a></li>
    <li><a href="{{ route('lists.index') }}">Lists</a></li>
    <li class="active">{{ $list->name }}</li>
</ol>
@include('lists._nav')
<div class="row-fluid">
    <div class="col-md-12">
        <div class="card">
            <div class="dropzone" id="my-dropzone"></div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                Files
            </div>
            <table class="table">
                <thead class="thead-">
                    <tr>
                        <td>name</td>
                        <td>rows</td>
                        <td>processed</td>
                        <td>imported</td>
                        <td>status</td>
                        <td></td>
                        <td>date</td>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($file))
                        @foreach($files as $file)
                        <tr>
                            <td>{{ $file->original_filename }}</td>
                            <td id="rows_{{$file->id}}">{{ $file->rows }}</td>
                            <td id="rows_processed_{{$file->id}}">{{ $file->rows_processed }}</td>
                            <td id="rows_imported_{{$file->id}}">{{ $file->rows_imported }}</td>
                            <td id="status_{{$file->id}}">{{ $file->status }}</td>
                            <td>
                                @if($file->status == 'pending')
                                <div class="btn-group">
                                    <a href="{{ route('lists.import', $file) }}" class="btn btn-sm btn-primary">
                                        <i class="fa fa-upload"></i>
                                        Import
                                    </a>
                                    <a href="{{ route('lists.import.cancel', $file) }}" class="btn btn-sm btn-secondary">
                                        <i class="fa fa-times-circle"></i>
                                        Cancel
                                    </a>
                                </div>
                                @endif
                            </td>
                            <td>{{ $file->created_at }}</td>
                        </tr>
                        @if($file->status == 'processing')
                        <tr id="bar_{{ $file->id }}">
                            <td colspan="6">
                                <progress class="progress progress-striped progress-success" id="{{ $file->id }}" value="0"
                                    max="100"></progress>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

@endsection

@section('js')
<link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.2.0/min/dropzone.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.2.0/min/dropzone.min.js"></script>
<script type="text/javascript">
    Dropzone.autoDiscover = false;


$(function() {
    // event listeners
    var myDropzone = new Dropzone("#my-dropzone",{
        url: '#',
        uploadMultiple: false,
        method: 'post',
        autoQueue: false,
        autoProcessQueue: false,
        acceptedFiles: ".csv",
        dictDefaultMessage: "Drop CSV files here or Click to open file browser. <br /> File will be imported into \"{{ $list->name }}\" List.",
    });

    myDropzone.on("addedfile", function(file) {
        var ext = file.name.substr(file.name.lastIndexOf('.') + 1);
        console.log(ext);
        
        if(ext.toLowerCase() != 'csv') {
            alert("csv only please.");
            myDropzone.removeFile(file);
        } else {
            $.get('/upload/signed?type=' + file.type + '&folder={{ $list_folder }}&sig={{ $list_sig }}', function(json){
                myDropzone.options.url = json.attributes.action;
                file.additionalData = json.additionalData;
                myDropzone.processFile(file);
            });
            
        }
        return false;

    });
    
    myDropzone.on('sending', function(file, xhr, formData) {
        xhr.timeout = 99999999;
        // Add the additional form data from the AWS SDK to the HTTP request.
        for (var field in file.additionalData) {
            formData.append(field, file.additionalData[field]);
        }
    });

    myDropzone.on('success', function(file) {
        if( file.accepted == true) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('{{ route('lists.upload', $list->id) }}', {
                'original_filename': file.name,
                'path': file.additionalData.key
            }).done(function( data ) {
                if(data.status == 'success') {
                    window.location.replace('{{ route('lists.import') }}/' + data.file);
                } else {
                    alert('something went wrong...');
                }
            });
        }
    });

    function GetProgress() {
        $('.progress').each(function() {
            var bar = $(this);
            var barId = bar.attr('id');
            $.get('{{ route('lists.import') }}/' + barId + '/show', function(data){
                bar.val(data.percent);
				$('#rows_' + barId).html(data.rows);
				$('#rows_processed_' + barId).html(data.rows_processed);
				$('#rows_imported_' + barId).html(data.rows_imported);
				if(data.percent == 100) {
                    $('#status_' + barId).html('imported');
					$('#bar_' + barId ).hide();
                    bar.removeClass('progress');
				}

			});
		});
	
	}

	var myInterval = setInterval(GetProgress, 1000);
	

});



</script>
@endsection
