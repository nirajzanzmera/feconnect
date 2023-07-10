<div class="row">
    <div class="col-md-4 laser">
        @if(Route::currentRouteName() == 'newsletters.create.website.preview' || Route::currentRouteName() == 'newsletters.create.feed.preview')
        <a href="" class="laser-btn btn btn-circle btn-success"><i class="fa fa-check"></i></a>
        @else
        <a href="" class="laser-btn btn btn-circle btn-primary">1<!-- <i class="fa fa-check"></i>  --></a>
        @endif
        <div>
            Select Template
        </div>
    </div>
    <div class="col-md-4 laser">
        <a href="" class="laser-btn btn btn-circle btn-primary">
            2
            <!-- <i class="fa fa-check"></i>  -->
        </a>
        <div>
            Select Feed
        </div>
    </div>
    <div class="col-md-4 laser">
        <a href="" class="laser-btn btn btn-circle btn-primary">
            3
            <!-- <i class="fa fa-check"></i> -->
        </a>
        <div>
            Create Newsletter
        </div>
    </div>
</div>
@section('css')
<style type="text/css">
.laser {
    padding:10px; 
    text-align: center;
}
.laser-btn {
    position: relative;
    z-index: 2;
}
.laser:after {
    content: '';
    position: absolute;
    background: #448aff;
    display: block;
    width: 100%;
    height: 5px;
    top: 30px;
    left: 50%;
    z-index: 1;
}
.laser:last-child::after {
    background: transparent;
}
 @media only screen and (max-width: 768px) {
    .laser:after {
        background: transparent;
    }
}
</style>
@endsection
