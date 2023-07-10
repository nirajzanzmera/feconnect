@extends('layouts.app')
@section('content')

@include('domains.partials._nav')

<div class="row-fluid">
    @if($custom_nameservers == true)
        @include('domains.partials._nswarning')
    @else
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    Built in Dataczar records:
                </h4>
            </div>
            @rtable([
                'header' => [
                    ['label'=>'Type', 'field'=>'type'],
                    ['label'=>'Host', 'field'=>"host"],
                    ['label'=>'Answer', 'field'=>"answer"],
                    ['label'=>'', 'field'=>'help', 'raw'=>true],
                ],
                'rows' => $dns_records->where('author', 'dataczar') ?? []
            ])@endrtable
        </div>
    </div>
    @endif

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    Subdomains
                </h4>
            </div>
            @rtable([
            'header' => [
                ['label'=>'Type', 'field'=>'type'],
                ['label'=>'Subdomain', 'field'=>"subdomain"],
                ['label'=>'Destination Record', 'field'=>"answer"],
                ['label'=>'', 'field'=>""],
            ],
                'rows' => $dns_records->where('author', 'user')->where('type', 'CNAME')?? []
            ])@endrtable
        </div>
    </div>

    {{-- 
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    Additional User Records
                </h4>
            </div>
            @rtable([
            'header' => [
                ['label'=>'Type', 'field'=>'type', 'edit'=>$types],
                ['label'=>'Name Record', 'field'=>"host", 'edit'=>'<input type="test" v-model="host">'],
                ['label'=>'Destination Record', 'field'=>"answer", '<input type="test" v-model="answer">'],
            ],
            'rows' => $dns_records->where('author', 'user') ?? []
            ])@endrtable
        </div>
    </div> 
    --}}

</div>
@endsection

@section('js')
    @include('layouts.partials._popover')
@endsection