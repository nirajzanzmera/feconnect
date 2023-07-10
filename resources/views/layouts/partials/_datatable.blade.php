<div class="col-md-12" id="app">
    <data-table endpoint="{{ !empty($parent) ? route($route, ['parent'=>$parent, 'parent_id'=>$parent_id]) : route($route) }}"
        limit="{{ !empty($limit) ? $limit : '' }}"
    >
            
    </data-table>
</div>

@section('js')
    <script src="{{ mix('/stuff/datatable.js') }}"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.17/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.4/lodash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.17.1/axios.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script src="{{ asset('js/datatable.js') }}"></script> --}}
@endsection

@section('css')

<style type="text/css">
    .sortable {
        cursor:pointer;
    }

    .arrow {
        display: inline-block;
        vertical-align: middle;
        width: 0;
        height: 0;
        margin-left: 5px;
        opacity: 0.6;
    }
    .arrow-asc{
        border-left: 4px solid transparent;
        border-right: 4px solid transparent;
        border-bottom: 4px solid #222;
    }
    .arrow-desc{
        border-left: 4px solid transparent;
        border-right: 4px solid transparent;
        border-top: 4px solid #222;
    }
</style>

@endsection
