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
                {{-- @if($page->type == 'index')
                    <a class="btn btn-xs q-mark" tabindex="0" data-toggle="popover" data-placement="left" 
                        title="Index page" 
                        data-content="
                        <p>
                            The index page (default, or home page) is what appears when the user enters your domain name without specifying a page.
                        </p>
                        ">
                        <i class="fa fa-btn fa-question-circle"></i>
                    </a>
                @endif --}}
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
                                    <em><a  href='{{route('websites.posts.index', ['website'=>$website])}}'>Click here to edit posts</a></em>
                                </li>

                            </ul>
                            ">
                            <i class="fa fa-btn fa-question-circle"></i>
                        </a> 
                    </em>

                @endif 
                @if(empty($page->link))
                <span class="float-right">
                    @if(!empty($page_stats[$page->id]['views']))
                    <label>Views:</label>
                    {{ $page_stats[$page->id]['views'] }}
                    @endif
                </span>
                @endif
            </div>
            <div class="cox-xs-12 col-sm-5 col-md-6">
                <span class="float-right">
                    
                    @rowmenu(['items' => $page->btns])@endrowmenu

                </span>
            </div>
        </div>
    </div>
</li>
