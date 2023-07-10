@extends('fe.layouts.app')
@section('content')


        <div>
            <h1 class="page-heading">Websites</h1>
        </div>

        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="https://connect.dataczar.com/_home">Home</a></li>
            <li class="breadcrumb-item ">
                <a href="{{ url('websites') }}">
                    Websites
                </a>
            </li>
            <li class="breadcrumb-item ">
                <a href="{{ url('websites/'.$main->website_id) }}">
                    {{ $site_name }}
                </a>
            </li>
            <li class="breadcrumb-item active">
                Edit
            </li>
        </ol>

        @include('fe.websites._nav', ['hidebreadcrumbs'=>true])

        @if($errors->count() > 0)
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
            @endforeach
        </div>
        @endif

        <div class="row-fluid">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="media">
                            <div class="media-body media-middle">
                                <h4 class="card-title">{{ $site_name }} - Settings</h4>
                            </div>

                        </div>
                    </div>
                    <div class="card-block">
                        <form action="{{ url('websites/'.$main->website_id) }}" method="POST" id="website_form">
                            <div class="row">

                                @csrf
                                <input type="hidden" name="_method" value="PUT">
                                <div class="col-lg-6">

                                    <legend>Business Information</legend>

                                    <div class="row form-group ">
                                        <label class="col-md-2 form-control-label" style="text-align:right">Website Name</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control form-control-success" name="name" value="{{ $site_name }}">
                                        </div>
                                    </div>

                                    <fieldset class="form-group ">
                                        <label for="address_1" class="col-md-2 form-control-label" style="text-align:right">
                                            Address
                                        </label>
                                        <div class="col-md-8">

                                            <input id="address" class="form-control colorpicker" name="address" value="{{ $settings->address->address}}">
                                        </div>
                                    </fieldset>
                                    <fieldset class="form-group ">
                                        <label for="address_1" class="col-md-2 form-control-label" style="text-align:right">
                                            Address 2
                                        </label>
                                        <div class="col-md-8">

                                            <input id="address_2" class="form-control colorpicker" name="address_2" value="{{ $settings->address->address_2 }}">
                                        </div>
                                    </fieldset>
                                    <fieldset class="form-group ">
                                        <label for="address_1" class="col-md-2 form-control-label" style="text-align:right">
                                            City
                                        </label>
                                        <div class="col-md-8">

                                            <input id="city" class="form-control colorpicker" name="city" value="{{ $settings->address->city }}">
                                        </div>
                                    </fieldset>
                                    <fieldset class="form-group ">
                                        <label for="address_1" class="col-md-2 form-control-label" style="text-align:right">
                                            State
                                        </label>
                                        <div class="col-md-8">

                                            <input id="state" class="form-control colorpicker" name="state" value="{{ $settings->address->state }}">
                                        </div>
                                    </fieldset>
                                    <fieldset class="form-group ">
                                        <label for="address_1" class="col-md-2 form-control-label" style="text-align:right">
                                            Zip
                                        </label>
                                        <div class="col-md-8">

                                            <input id="zip" class="form-control colorpicker" name="zip" value="{{ $settings->address->zip }}">
                                        </div>
                                    </fieldset>
                                    <fieldset class="form-group ">
                                        <label for="address_1" class="col-md-2 form-control-label" style="text-align:right">
                                            Phone
                                        </label>
                                        <div class="col-md-8">

                                            <input id="phone" class="form-control colorpicker" name="phone" value="{{ $settings->address->phone }}">
                                        </div>
                                    </fieldset>

                                    <legend>Social Links</legend>


                                    <div id="socialform">
                                        <div class="row form-group">
                                            <label class="col-md-2 form-control-label" style="text-align: right;">
                                                <i title="facebook" class="fa fa-facebook"></i></label>
                                            <div class="col-md-9">
                                                <input type="text" dusk="facebook" name="facebook" placeholder="https://www.facebook.com/username" class="form-control" value="{{ $settings->social_links->facebook }}">
                                                <!----></div></div>
                                        <div class="row form-group">
                                            <label class="col-md-2 form-control-label" style="text-align: right;">
                                                <i title="twitter" class="fa fa-twitter"></i></label>
                                            <div class="col-md-9"><input type="text" dusk="twitter" name="twitter" placeholder="https://www.twitter.com/username" class="form-control" value="{{ $settings->social_links->twitter }}"> <!----></div>
                                        </div>
                                        <div class="row form-group">
                                            <label class="col-md-2 form-control-label" style="text-align: right;">
                                                <i title="linkedin" class="fa fa-linkedin"></i></label>
                                            <div class="col-md-9"><input type="text" dusk="linkedin" name="linkedin" placeholder="https://www.linkedin.com/in/example-profile" class="form-control" value="{{ $settings->social_links->linkedin }}">
                                                <!----></div>
                                        </div>
                                        <div class="row form-group">
                                            <label class="col-md-2 form-control-label" style="text-align: right;">
                                                <i title="instagram" class="fa fa-instagram"></i></label>
                                            <div class="col-md-9"><input type="text" dusk="instagram" name="instagram" placeholder="https://www.instagram.com/username" class="form-control" value="{{ $settings->social_links->instagram }}"> <!----></div>
                                        </div>
                                        <div class="row form-group">
                                            <label class="col-md-2 form-control-label" style="text-align: right;">
                                                <i title="youtube" class="fa fa-youtube"></i></label>
                                            <div class="col-md-9"><input type="text" dusk="youtube" name="youtube" placeholder="https://www.youtube.com/channel/example-channel" class="form-control" value="{{ $settings->social_links->youtube }}">
                                                <!----></div>
                                        </div>
                                        <div class="row form-group">
                                            <label class="col-md-2 form-control-label" style="text-align: right;">
                                                <i title="yelp" class="fa fa-yelp"></i></label>
                                            <div class="col-md-9">
                                                <input type="text" dusk="yelp" name="yelp" placeholder="https://www.yelp.com/biz/example-name" class="form-control" value="{{ $settings->social_links->yelp }}"> <!----></div>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-lg-6">

                                    <legend>Brand</legend>
                                    <fieldset class="form-group ">
                                        <label for="logo" class="col-md-2 form-control-label" style="text-align:right">Logo</label>
                                        <div id="app" class="col-md-8"><div>
                                                @if($logo != "")
                                                <div style="position: relative; width: 150px;">
                                                    <a href="" class="btn btn-xs btn-danger clear_holder" style="position: absolute; top: 5px; right: 5px;">
                                                        <i class="fa fa-times"></i></a>
                                                    <img src="{{ $logo }}" class="img img-thumbnail" width="150px">
                                                </div>
                                                @endif
                                                <div class="input-group">
                                                    <span class="input-group-btn"><a href="" class="btn btn-primary filemanager">
                                                            <i class="fa fa-picture-o"></i> Choose
                                                        </a>
                                                    </span>
                                                    <input id="featured_image" type="hidden" name="logo"
                                                           class="form-control" value="{{ $logo }}">
                                                </div> <!----></div>
                                        </div>
                                    </fieldset>

                                    <legend>Engagement</legend>
                                    <div class="row form-group ">
                                        <label class="col-md-2 form-control-label" style="text-align:right"></label>
                                        <div class="col-md-8">
                                            <div class="form-check">
                                                <label class="form-check-label" for="use_public">
                                                    <input class="form-check-input" type="checkbox" id="use_public" name="use_public" @if($settings->use_public == true) checked @endif>
                                                    Include Business Address
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row form-group ">
                                        <label class="col-md-2 form-control-label" style="text-align:right"></label>
                                        <div class="col-md-8">
                                            <div class="form-check">
                                                <label class="form-check-label" for="newsletter_signup">
                                                    <input class="form-check-input" type="checkbox" id="newsletter_signup" name="newsletter_signup" checked="">
                                                    Include Newsletter Signup
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row form-group ">
                                        <label class="col-md-2 form-control-label" style="text-align:right"></label>
                                        <div class="col-md-8">
                                            <div class="form-check">
                                                <label class="form-check-label" for="powered_by">
                                                    <input class="form-check-input" type="checkbox" id="powered_by" name="powered_by">
                                                    Include Powered by Dataczar Image
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <legend>Defaults</legend>

                                    <div class="row form-group">
                                        <label class="col-md-2 form-control-label" style="text-align:right"></label>
                                        <div class="col-md-8">
                                            <div class="form-check">
                                                <label class="form-check-label" for="default_website">

                                                    <i class="fa fa-check-square-o"></i>
                                                    Default Website
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <label class="col-md-2 form-control-label" style="text-align:right"></label>
                                        <div class="col-md-8">
                                            <label class="form-check-label" for="default_list_id">
                                                Newsletter List
                                            </label>
                                            <select name="default_list_id" class="form-control">
                                                <option value="{{ $settings->default_list_id }}" selected="">
                                                    default
                                                </option>
                                            </select>
                                        </div>
                                    </div>


                                    <legend>Advanced</legend>
                                    <div class="row form-group ">
                                        <label class="col-md-2 form-control-label">&nbsp;</label>
                                        <div class="col-md-6">
                                            <a href="#" class="btn btn-default btn-sm" data-toggle="collapse" data-target="#collapseExample">
                                                <i class="fa fa-plus"></i>
                                                Show Advanced
                                            </a>
                                        </div>
                                    </div>
                                    <div class="collapse" id="collapseExample">
                                        <legend>Feed Import</legend>
                                        <fieldset class="form-group">
                                            <label class="col-md-2 form-control-label" style="text-align:right" for="feed_website.feed_id">Feed</label>
                                            <select name="feed_website-feed_id" id="feed_website-feed_id" class="form-control col-md-6">
                                                <option value="" selected="">
                                                </option>
                                            </select>
                                            <a href="{{ route('content.feeds.create') }}">Add Feed</a>
                                        </fieldset>
                                        <fieldset id="range" class="form-group" style="display: none;">
                                            <label class="col-md-2 form-control-label" style="text-align:right" for="feed_website-range">Range</label>
                                            <select name="feed_website-range" id="feed_website-range" class="form-control col-md-2">
                                                <option value="all">all</option>
                                                <option value="new">new</option>
                                            </select>
                                        </fieldset>
                                        <fieldset id="recurring" class="form-group" style="display: none;">
                                            <label class="col-md-2 form-check-label" style="text-align:right" for="feed_website-recurring">Recurring</label>

                                            <input class="col-md-1 form-check-input" style="align:left" type="checkbox" name="feed_website-recurring" value="1" checked="">
                                        </fieldset>

                                        <legend>Global</legend>

                                        <div class="row form-group ">
                                            <label class="col-md-2 form-control-label" style="text-align:right">adsense id</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control form-control-success" name="adsense_id" value="" placeholder="ca-pub-0000000000000000">
                                            </div>
                                        </div>
                                    </div>
                                </div>




                                <div class="row form-group">
                                    <div class="col-md-8 col-md-offset-2">
                                        <button class="btn btn-success" type="submit" id="submit_btn">Update</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


@endsection