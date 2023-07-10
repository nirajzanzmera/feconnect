@if(!empty($website->id))
    <div class="card">
        <div class="card-header">
            <h4 class="card-title row">

                <div class="col-6 col-sm-4 col-md-5 px-0 px-xl-2">
                    Recent Posts
                </div>
                <div class="col-6 col-sm-8 col-md-7 pr-0">
                    <a class="btn btn-sm btn-secondary pull-right hidden-xs" title="Add Post" href="{{ route( 'post.quick_create', [ 'website' => $website->id ] ) }}">
                        <i class="fa fa-plus"></i>
                        Quick Add Post
                    </a>
                </div>
            </h4>

        </div>

        <ul id="posts" class="list-group" style="margin: 0;margin-top: 0;padding: 0;">

            @foreach(json_decode(json_encode($posts ?? []),true) as $key => $post)
            @if($loop->iteration > 3)
            @break
            @endif
            <li class="list-group-item">
                <div class="row">
                    <div class="col-lg-10">
                        <img style="max-width:150px; margin-right:10px;" class="float-left" src="{{ $post['image'] }}" alt="">
                        <h4><a href="{{ route('websites.posts.edit',['website'=>$post['website_id'],'post'=>$post['id'] ]) }}">{{ $post['title'] }}</a></h4>
                        <p class=""><small>{!! substr(strip_tags($post['content']),0,100) !!}</small></p>
                        <p class="mb-0"><small><i>Posted {{ $post['created_at'] }}</i></small></p>
                        @if(isset($post['views']) && $post['views']>0)
                        <p class=""><small>
                                <b>Views: </b>{{ $post['views'] ?? '' }}
                        </small></p>
                        @endif
                    </div>
                    <div class='col-lg-2'>
                        <div class="btn-group pull-right">
                            <a href="{{ route('websites.posts.edit',['website'=>$post['website_id'],'post'=>$post['id'] ]) }}" title="Edit" class="btn btn-sm btn-primary ">
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </li>
            @endforeach
            <li class="list-group-item center">
                <a type="submit" href="{{ route( 'websites.posts.index', [ 'website' => $website->id ] ) }}" class="btn btn-default" title="See More">
                    See More
                </a>
            </li>
        </ul>
    </div>
    @endif
