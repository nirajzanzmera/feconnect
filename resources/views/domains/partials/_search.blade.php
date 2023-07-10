<div class="card-block">
    <div class="row form-group">
        <label class="col-md-2 form-control-label" style="text-align:right">Search</label>
        <div class="col-md-8">
            <input type="text" class="form-control" id="keyword" placeholder="Find your domain name" value="{{ $value ?? '' }}">
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-8 col-md-offset-2">
            <button type="submit" class="btn btn-success" id="search">
                <i class="fa fa-btn fa-search"></i> Search
            </button>
        </div>
    </div>
</div>
<ul class="list-group" id="results">
    <li class="list-group-item">Results</li>
</ul>

@section('js2')

    @include('domains.partials._js')

    @if(!empty($value)) 
    <script>
        $(document).ready(function(){
            search();
        });
    </script>
    @endif

@endsection
