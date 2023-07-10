<tr>
    <td></td>
    <td></td>
    <td>
        @if(!isset($cc) || $cc == true)
        @if(empty($current_plan) || empty($active_sub))
        <form action="{{ route('plans.add', ['id'=>2]) }}" method="POST">
            {{  csrf_field() }}
            <button id="choose_basic" type="submit"
                class="btn btn-sm btn-success {{ (!empty($active_sub) &&  !empty($current_plan) && $current_plan->id == 2) ? ' disabled' : ''}}">
                Choose
            </button>
        </form>
        @else
        <form action="{{ route('plans.swap', ['id'=>2]) }}" method="POST">
            {{  csrf_field() }}
            <button id="switch_basic" type="submit"
                class="btn btn-sm btn-primary{{ (!empty($active_sub) &&  !empty($current_plan) && $current_plan->id == 2 ) ? ' disabled' : ''}}">
                Switch
            </button>
        </form>
        @endif
        @else
        <a href="{{ $pkgcds['basic'] }}" id="addtocart-basic" class="btn btn-sm btn-primary">Add to Cart</a>
        @endif
    </td>
    <td>
        @if(!isset($cc) || $cc == true)
        @if(empty($current_plan) || empty($active_sub))
        <form action="{{ route('plans.add', ['id'=>3]) }}" method="POST">
            {{  csrf_field() }}
            <button type="submit"
                class="btn btn-sm btn-primary {{ (!empty($active_sub) &&  !empty($current_plan) && $current_plan->id == 3) ? ' disabled' : ''}}">
                Choose
            </button>
        </form>
        @else
        <form action="{{ route('plans.swap', ['id'=>3]) }}" method="POST">
            {{  csrf_field() }}
            <button id="switch_pro" type="submit"
                class="btn btn-sm btn-primary{{ (!empty($active_sub) &&  !empty($current_plan) && $current_plan->id == 3 ) ? ' disabled' : ''}}">
                Switch
            </button>
        </form>
        @endif
        @else

        <a href="{{ $pkgcds['pro'] }}" id="addtocart-pro" class="btn btn-sm btn-primary">Add to Cart</a>

        @endif
    </td>
    <td>
            @if(!isset($cc) || $cc == true)
            @if(empty($current_plan) || empty($active_sub))
            <form action="{{ route('plans.add', ['id'=>4]) }}" method="POST">
                {{  csrf_field() }}
                <button type="submit"
                    class="btn btn-sm btn-primary {{ (!empty($active_sub) &&  !empty($current_plan) && $current_plan->id == 4) ? ' disabled' : ''}}">
                    Choose
                </button>
            </form>
            @else
            <form id="switch_free_form" action="{{ route('plans.swap', ['id'=>4]) }}" method="POST">
                {{  csrf_field() }}
                <button id="switch_free" type="submit"
                    class="btn btn-sm btn-primary{{ (!empty($active_sub) &&  !empty($current_plan) && $current_plan->id == 4) ? ' disabled' : ''}}">
                    Switch
                </button>
            </form>
            @endif
            @else
            <a href="{{ $pkgcds['deluxe'] }}" id="addtocart-deluxe" class="btn btn-sm btn-primary">Add to Cart</a>
            @endif
        </td>
        <td></td>
</tr>
@section('js2')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){

        $('#switch_free').on('click', function(e){
            e.preventDefault();

        swal({
            title: "Are you sure?",
            text: "Are you sure you want to lose access to {{ auth()->user()->currentTeam->domain ?? 'your custom domain name' }}?",
            icon: "warning",
            dangerMode: true,
            buttons: [true, 'Confirm'],
        })
        .then(willSwitchFree => {
            if (willSwitchFree) {
                $('#switch_free_form').submit()
            }
        });
    });
});

</script>
@endsection