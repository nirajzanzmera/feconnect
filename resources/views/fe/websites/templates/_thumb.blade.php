<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 items">
    <div class="tmp-thumb">

        <a class="btn btn-primary fancybox" style="background-color: white; border: none" href="{{ substr( $template->thumb, 0, 4 ) === "http" ? $template->thumb : "https://dataczar-public.s3.us-west-2.amazonaws.com/".$template->thumb }}"
           data-caption="{{ substr( $template->thumb, 0, 4 ) === "http" ? $template->thumb : "https://dataczar-public.s3.us-west-2.amazonaws.com/".$template->thumb }}"
        >
        <img src="{{ substr( $template->thumb, 0, 4 ) === "http" ? $template->thumb : "https://dataczar-public.s3.us-west-2.amazonaws.com/".$template->thumb }}" class="img img-thumbnail" style="background:white"/>

        </a>
        <h5 class="tmp-title">{{ $template->name }}</h5>
        {{-- @rowmenu([
            'btn_group_class' => '',
            'items'=>
            [
                [
                    'display' => 'Create Page',
                        'route' => route('websites.pages.create', ['website'=>$website->id, 'template'=>$template->id, 'menu'=>$menu]),
                    'icon' => 'fa fa-plus',
                    'color' => 'btn-success',
                ],
                [
                    'hide'=> true,
                    'display' => 'Create Post',
                    'route' => route('websites.posts.create', ['website'=>$website->id, 'template'=>$template->id]),
                    'icon' => 'fa fa-plus',
                    'color' => 'btn-primary',
                ],
            ]
        ])@endrowmenu --}}
        &nbsp;

        <div class="btn-group">
            <a href="{{ route('websites.posts.create', ['website'=>$wid, 'template'=>$template->id]) }}" class="btn btn-sm btn-success">
                <i class="fa fa-plus"></i>
                Create Post
            </a>
            <a href="{{ route('websites.pages.create', ['website'=>$wid, 'template'=>$template->id]) }}" class="btn btn-sm btn-default">
                <i class="fa fa-bookmark"></i>
                Create Page
            </a>
        </div>


    </div>
</div>
