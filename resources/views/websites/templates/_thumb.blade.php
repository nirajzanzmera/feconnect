<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
    <div class="tmp-thumb">

        <img src="{{ $template->thumburl }}" class="img img-thumbnail" style="background:white">
        
        <h5 class="tmp-title">{{ $template->name }}</h5>

        @rowmenu([
            'btn_group_class' => '',
            'items'=>
            [
                [
                    'display' => 'Create Page',
                    'route' => route('websites.pages.create', ['website'=>$website, 'template'=>$template, 'menu'=>$menu]),
                    'icon' => 'fa fa-plus',
                    'color' => 'btn-success',
                ],
                [
                    'hide'=> true,
                    'display' => 'Create Post',
                    'route' => route('websites.posts.create', ['website'=>$website, 'template'=>$template]),
                    'icon' => 'fa fa-plus',
                    'color' => 'btn-primary',
                ],
            ]
        ])@endrowmenu
        &nbsp;

        {{-- <div class="btn-group">
            <a href="{{ route('websites.posts.create', ['website'=>$website, 'template'=>$template]) }}" class="btn btn-default">
                <i class="fa fa-edit"></i>
                Create Post
            </a>
            <a href="{{ route('websites.pages.create', ['website'=>$website, 'template'=>$template]) }}" class="btn btn-default">
                <i class="fa fa-bookmark"></i>
                Create Page
            </a>
        </div>
 --}}
        
    </div>
</div>
