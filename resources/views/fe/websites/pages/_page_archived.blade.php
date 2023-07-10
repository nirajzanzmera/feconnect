<li id="{{ $page->id }}" class="list-group-item">
    <div class="row ">
        @if($page->type == 'permanent')
        <div class="col-xs-1" title="Can't be moved to a menu">
            <i class="fa fa-times" style="color:#ccc;"></i>
        </div>
        @else
        <div class="col-xs-1 drag" title="{{ empty($page->link) ? 'Page' : 'Link' }}">
            <i class="fa fa-arrows-v"></i>
        </div>
        @endif
        <div class="col-xs-11">
            <div class="col-xs-12 col-sm-7 col-md-6">
                {{ $page->title }} {{ !empty($page->link) ? " - $page->link" : '' }}

                @if($page->type == 'index')
                - <strong title="The main page of a website that contains links to other parts of the website"><em>Index</em></strong>
                @endif
                <div class="label label-{{ ($page->status == 'live') ? 'success' : 'default' }}" style="margin-left:15px;">
                    {{ $page->status }}
                </div>
                &nbsp;
                @if($page->title == 'Signup Confirmation')
                    <a class="btn btn-xs q-mark " tabindex="0" data-toggle="popover" data-placement="bottom" 
                        title="Signup Confirmation" 
                        data-content="
                        <p>
                            Signup Confirmation page informs your customer that they have signed up for your newsletter.
                        </p>
                        ">
                        <i class="fa fa-btn fa-question-circle"></i>
                    </a>
                @endif
                @if($page->title == 'Contact Confirmation')
                    <a class="btn btn-xs q-mark " tabindex="0" data-toggle="popover" data-placement="bottom" 
                        title="Contact Confirmation" 
                        data-content="
                        <p>
                            Contact Confirmation page informs your customer that the Contact Form was submitted.
                        </p>
                        ">
                        <i class="fa fa-btn fa-question-circle"></i>
                    </a>
                @endif

                @if($page->include_posts )
                    <em>(includes posts)
                        <a class="btn btn-xs q-mark" tabindex="0" data-toggle="popover" data-placement="bottom" 
                            title="This Page Includes Posts" 
                            data-content="
                            <ul>
                                <li>
                                    Pages are the permanent parts of your website. They appear in menus and can include a feed of posts on them.
                                </li>
                                <li>
                                    A post is like an article you write on your website, where the newest is the most relevant. Posts appear in a feed on pages that include them.
                                </li>
                                <li>
                                    Use posts for content like news. Use pages for content you would like to display permanently in your menus.
                                </li>
                                <li>
                                    <em><a  href='{{route('websites.posts.index', $website->id)}}'>Click here to edit posts</a></em>
                                </li>

                            </ul>
                            ">
                            <i class="fa fa-btn fa-question-circle"></i>
                        </a> 
                    </em>

                @endif 
                @if(empty($page->link))
                <span class="float-right">
                
                    @php
                        $page_stats = json_decode(json_encode($page_stats), true);
                    @endphp

                    @if(!empty($page_stats[$page->id]['views']))
                    <label>Views:</label>
                    {{ $page_stats[$page->id]['views'] }}
                    @endif
                </span>
                @endif
            </div>
            <div class="cox-xs-12 col-sm-5 col-md-6">
                <span class="float-right">
                    <div class="btn-group">
                        <a href="{{ route('websites.pages.show', ['website'=>$website->id, 'page'=>$page->id]) }}" class="btn btn-sm btn-info"
                            title="Preview"><i class="fa fa-eye"></i>
                        </a>
                        <a href="{{ route('websites.pages.edit', ['website'=>$website->id, 'page'=>$page->id]) }}" class="btn btn-sm btn-primary"
                            title="Edit"><i class="fa fa-edit"></i>
                        </a>
                        <a href="{{ route('websites.analytics', ['website'=>$website->id]) }}" class="btn btn-sm btn-secondary"
                            title="Analytics"><i class="fa fa-bar-chart"></i>
                        </a>
                        <div class="btn-group">
                            <div class="dropdown show">
                                <a class="btn btn-sm btn-default dropdown-toggle" href="#" id="dropdownMenuLink"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-bars"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">

                                    <a href="{{ route('websites.pages.show', ['website'=>$website->id, 'page'=>$page->id]) }}" class="dropdown-item"
                                        title="Preview"><i class="fa fa-eye"></i> Preview
                                    </a>
                                    <a href="#" data-href="https://www.yogurtconcoction.com/index.html"
                                        class="dropdown-item copy" title="Copy Link"><i class="fa fa-share"></i> Copy Link
                                    </a>
                                    <a href="{{ route('websites.pages.replicate', ['id'=>$website->id, 'page'=>$page->id]) }}"
                                        class="dropdown-item" title="Save as new page"><i class="fa fa-clone"></i> Save as new page
                                    </a>
                                    <a href="{{ route('websites.pages.edit', ['website'=>$website->id, 'page'=>$page->id]) }}"
                                        class="dropdown-item" title="Edit"><i class="fa fa-edit"></i> Edit
                                    </a>
                                    <a href="{{ route('websites.analytics', ['website'=>$website->id]) }}"
                                        class="dropdown-item" title="Analytics"><i class="fa fa-bar-chart"></i>
                                        Analytics
                                    </a>
                                    <a href="" title="Delete..." class="dropdown-item delete" data-id="{{$page->id}}"
                                       data-url="{{route('websites.page.delete', ['website'=>$website->id,'page'=>$page->id])}}">
                                        <i class="fa fa-trash-o"></i>
                                        Delete...
                                    </a>
                                    <a href="" title="Unarchived..." class="dropdown-item unarchive" data-id="{{$page->id}}"
                                       data-url="{{route('websites.page.unarchive', ['website'=>$website->id,'page'=>$page->id])}}">
                                        <i class="fa fa-file-archive-o"></i>
                                        Unarchive...
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </span>

            </div>
        </div>
    </div>
</li>
