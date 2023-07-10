@extends('layouts.app')
@section('content')
<div>
    <a href="{{route('campaigns.index')}}" class="btn btn-default btn-sm pull-right" style="margin-top: 22px;">
        <i class="fa fa-arrow-left"></i> Back
    </a>
    <h1 class="page-heading">Email Blasts - ads</h1>
</div>
<ol class="breadcrumb">
    <li><a href="{{ route('homebc') }}">Home</a></li>
    <li><a href="{{ route('campaigns.index') }}">Email Blasts</a></li>
    <li class="active">Ads</li>
</ol>
<form method="post" action="{{route('campaigns.newsletter.ads', $newsletter)}}">
    {!! csrf_field() !!}
    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="media">
                        <div class="media-body">
                            <h4 class="card-title">{{ $newsletter->name }} - Native Slots (ads)</h4>
                            <p class="card-subtitle">This newsletter containers {{ $newsletter->ad_limit }} slots that need to be filled</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @for($i = 1; $i <= $newsletter->ad_limit; $i++)
        <div class="col-md-6">
            
            <div class="card">
                <div class="card-header">
                    <div class="media">
                        <div class="media-body">
                            <h4 class="card-title">Native {{ $i }}</</h4>
                        </div>
                        <div class="media-right">
                            <a href="" class="btn btn-success disable" id="ad_{{ $i }}">ON</a>
                        </div>
                    </div>
                </div>
                <div class="card-block">
                    <div class="form-group">
                        <label for="title_{{$i}}">Title</label>
                        <input type="text" class="form-control ad_{{ $i }}" name="title_{{$i}}" id="title_{{$i}}" placeholder="Enter Title">
                    </div>
                    <div class="form-group">
                        <label for="description_{{$i}}">Description</label>
                        <textarea type="text" class="form-control ad_{{ $i }}" name="description_{{$i}}" id="description_{{$i}}" placeholder="Enter Description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="image_{{$i}}">Image Url</label>
                        <input type="text" class="form-control ad_{{ $i }}" name="image_{{$i}}" id="image_{{$i}}" placeholder="http://example.com/image.jpg">
                    </div>
                    <div class="form-group">
                        <label for="permalink{{$i}}">Link</label>
                        <input type="text" class="form-control ad_{{ $i }}" name="permalink_{{$i}}" id="permalink{{$i}}" placeholder="http://example.com/index.html">
                    </div>
                    
                </div>
            </div>
        </div>
        @endfor
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-block">
                    
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-plus"></i>
                            Generate Newsletter
                        </button>

                </div>
            </div>
        </div>
    </div>

</div>
</div>
</form>
@endsection


@section('js')
<script type="text/javascript">
    $(document).ready(function(){
        $('.disable').on('click', function(e) {
            e.preventDefault();
            var my_id = $(this).attr('id');
            $('.' + my_id).attr('disabled', function(_, attr){ return !attr});

            if( $(this).text() == 'OFF') {
                $(this).text('ON');
                $(this).toggleClass('btn-success');
                $(this).toggleClass('btn-warning');
            } else {
                $(this).text('OFF');
                $(this).toggleClass('btn-success');
                $(this).toggleClass('btn-warning');
            }

        });
    });
</script>
@endsection
