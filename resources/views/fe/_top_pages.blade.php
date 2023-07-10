@if(count($team->websites) > 0)
@if(!empty($behavior))
<div class="card">
    <div class="card-header">
        <h4 class="card-title">{{ $team->name }} Top Pages
            <a class="btn btn-sm btn-secondary pull-right hidden-xl-up"  style="margin-top:-3px;" title="Website Analytics" href="{{ route('websites.analytics', ['website' => $website->id]) }}">
                <i class="fa fa-bar-chart"></i>
            </a>
        </h4>

    </div>

        <ul class="list-group" style="margin: .625rem;margin-top: 0;padding: 0;">
            <li class="list-group-item row hidden-lg-down">
                <div class="col-lg-8"><strong>Page</strong></div>
                <div class="col-lg-2"><strong>Views</strong></div>
                <div class="col-lg-2">
                    <a class="btn btn-sm btn-secondary pull-right"  title="Website Analytics" href="{{ route('websites.analytics', ['website' => $website->id]) }}">
                        <i class="fa fa-bar-chart"></i>
                    </a>
                </div>
            </li>
            @foreach (json_decode(json_encode($behavior),true) as $page)
            <li class="list-group-item row ">
                <div class="col-lg-8 ">
                    <label class="hidden-xl-up"><strong>Page: </strong></label>
                    {{ $page['page'] }}
                </div>
                <div class="col-lg-2 ">
                    <label class="hidden-xl-up"><strong>Views: </strong></label>
                    {{ $page['views'] }}
                </div>
                <div class="col-lg-2 pull-right">
                    @if (!empty($page['post_id']) || !empty($page['page_id']))
                            @if (!empty($page['post_id']))
                            <a class="btn btn-sm btn-secondary pull-right" title="Post Analytics" href="{{ route('post.analytics', ['post' => $page['post_id']]) }}">
                            @elseif (!empty($page['page_id']))
                            <a class="btn btn-sm btn-secondary pull-right" title="Page Analytics" href="{{ route('page.analytics', ['page' => $page['page_id']]) }}">
                            @endif
                            <i class="fa fa-bar-chart"></i>
                            </a>
                    @endif
                </div>
            </li>
        @endforeach
        </ul>
</div>
@endif
@endif