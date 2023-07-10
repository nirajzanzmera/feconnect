@extends('fe.layouts.app')
@section('content')
<style>
    .progress {
        display: -ms-flexbox;
        display: flex;
        height: 1rem;
        overflow: hidden;
        font-size: .75rem;
        background-color: #5e1616;
        border-radius: .25rem;
    }
    .progress-bar {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-direction: column;
        flex-direction: column;
        -ms-flex-pack: center;
        justify-content: center;
        color: #fff;
        text-align: center;
        white-space: nowrap;
        background-color: #007bff;
        transition: width .6s ease;
    }
    .media-icon .lock {
        opacity: 0.6;
        font-size: 3em;
    }
    .media-icon .fa-lock {
        position: absolute;
        left: 28px;
        transform: rotateZ(30deg);
        font-size: 2.6em;
    }
    .bg-danger {
        background-color: #E53935 !important;
    }
</style>
        <div>
            <h1 class="page-heading"> User Dashboard - {{$g_user->name}}</h1>
        </div>

        @include('fe.teamwork._nav')

        @foreach(json_decode(json_encode($datalist['Achievements']),true) as $key => $value)
            @if($value['id'] == $id)
            <div class="col-md-12">
                <div class="card py-3 h-card text-center">
                    <h5 class="mb-3 font-weight-bolder">
                        {{ $value['Title'] }}
                    </h5>

                    @if($value['AchievedDate']!=null)
                        <img style="max-height: 300px; max-width:100%;" src="{{ url('img/badges/'.$value['IconURL']) }}">

                    @else
                        <div class="progress">
                            <div class="progress-bar bg-danger" style="width:50%"></div>
                        </div>
                    @endif

                    @if(isset($value['link']))
                        <a class="btn btn-primary" href="{{url()->current() . $value['link']}}">
                            Restart Interview
                        </a>
                    @endif

                    <div class="row justify-content-center">
                        <p class="col-6 text-right">Title:</p>
                        <p class="col-6 text-left">{{ $value['Title'] }}</p>
                    </div>
                    <div class="row justify-content-center">
                        <p class="col-6 text-right">State:</p>
                        <p class="col-6 text-left">{{ $value['State'] }}</p>
                    </div>
                    <div class="row justify-content-center">
                        <p class="col-6 text-right">Phone Verified:</p>
                        <p class="col-6 text-left">{{ $value['AchievedDate'] }}</p>
                    </div>
                    <div class="row justify-content-center">
                        <p class="col-6 text-right">Locked:</p>
                        <p class="col-6 text-left">{{ $value['Locked'] }}</p>
                    </div>
                </div>

                @if($value['Progress']!="" && $value['ProgressCap']!="")
                <div class="col-md-12">
                    <div class="d-flex">
                        <div class="card col-2 py-2 text-center">Progress</div>
                        <div class="card col-10 py-2">
                            <div class="progress">
                                <?php $per = ($value['Progress'] / $value['ProgressCap'])*100; ?>
                                <div class="progress-bar bg-danger" style="width:{{ $per }}%"></div>
                            </div>
                            <p class="text-right">{{ $value['Progress'] }} / {{ $value['ProgressCap'] }}</p>
                        </div>
                    </div>

                </div>
                @endif
            </div>

            @endif
        @endforeach



@endsection

@section('js')
<script src="{{ mix('/stuff/standalone.js') }}"></script>
@endsection