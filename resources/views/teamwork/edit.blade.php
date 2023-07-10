@extends('layouts.app')


@section('content')

<h1 class="page-heading">Edit Account {{$team->name}}</h1>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Edit Account {{ $team->name }}</h4>
            </div>
            <div class="card-block">
                <form  method="post" action="{{route('teams.update', $team)}}">
                    {{ method_field('PUT') }}
                    {!! csrf_field() !!}
                    @include('teamwork._form')
                    <div class="row form-group">
                        <div class="col-md-9 col-md-offset-2">
                            <button type="submit" class="btn btn-success">
                            <i class="fa fa-btn fa-save"></i> Update
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
                    
               
@endsection
