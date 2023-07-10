<div class="card" id="blog_slider" style="display: none">
    {{--
    <div class="card-header">
        <h4 class="card-title row">

            <div class="col-6 col-sm-4 col-md-5 px-0 px-xl-2">
                Blogs
            </div>
        </h4>

    </div>
    --}}
    <ul id="posts" class="list-group" style="margin: 0;padding: 0;">

        <li class="list-group-item" style="margin: 0;padding: 0;">
            <!--Carousel Wrapper-->
            <div id="multi-item-example" class="carousel slide carousel-multi-item" data-ride="carousel">

                <!--Controls-->
                <div class="controls-top" style="position: absolute;
                    right: 2%;
                    z-index: 111111;
                    text-align: center;
                    bottom: 2%;">
                    <a class="btn-floating" href="#multi-item-example" data-slide="prev"><i class="fa fa-chevron-left"></i></a>
                    <a class="btn-floating" href="#multi-item-example" data-slide="next"><i class="fa fa-chevron-right"></i></a>
                </div>
                <!--/.Controls-->
                <!--Slides-->
                <div class="carousel-inner" role="listbox" id="blogs">

                    {{--<!--First slide-->--}}
                    {{--<?php $cnt = 1; ?>--}}
                    {{--@foreach($blog as $key => $value)--}}
                    {{--<div class="carousel-item @if($cnt==1)active @endif">--}}

                        {{--<div class="row">--}}
                            {{--<div class="col-md-12">--}}
                                {{--<div class="card mb-2">--}}
                                    {{--<div class="card-header">--}}
                                    {{--<h4 class="card-title">{{ $value->title }}</h4>--}}
                                    {{--</div>--}}
                                    {{--<img class="card-img-top" src="{{ $value->image }}" alt="{{ $value->title }}" style="float: left;--}}
    {{--width:  100%;--}}
    {{--height: 300px;--}}
    {{--object-fit: cover;--}}
{{--">--}}
                                    {{--<div class="card-body center" >--}}
                                        {{--<p class="card-text">{!! substr($value->content,0,300)  !!}</p>--}}
                                        {{--<a class="btn btn-primary" href="#">Learn More</a>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                    {{--</div>--}}
                    {{--<?php $cnt++; ?>--}}
                    {{--<!--/.First slide-->--}}
                    {{--@endforeach--}}

                </div>
                <!--/.Slides-->

            </div>
            <!--/.Carousel Wrapper-->
        </li>

    </ul>
</div>




