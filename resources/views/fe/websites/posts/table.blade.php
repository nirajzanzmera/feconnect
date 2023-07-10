
<table id="example2" class="table table-striped table-bordered table-responsive" style="width:100%">
    <thead>
    <tr style="display: none">
        <th></th>
        <th></th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach($posts->data as $post)

        <tr class="" id="post_{{ $post->id }}">

                <td width="20%">
                    <img src="{{
                                !empty($post->image) ? $post->image : 'https://via.placeholder.com/250x160?text=No+Image'
                            }}" alt="" class="img-fluid" style="max-height:160px;">
                </td>
                <td width="60%">
                    <strong>Date:</strong> {{ \Carbon\Carbon::parse($post->start_time->date)->format('Y-m-d') }} &nbsp; <div class="label {{ $post->status == 'live' ? 'label-success' : 'label-default' }}"> {{ $post->status }}</div><br />
                    <strong>Title:</strong> <span class="post_title">{{ $post->title }} </span><br />

                   
                    <strong>Description:</strong> 
                    <span class="post_desc">{!! \Illuminate\Support\Str::limit(strip_tags($post->content), 256, $end='...') !!} 
                    </span>

                    @if (!empty($post_stats[$post->id]['views']))
                        <br />
                        <strong>Views:</strong> {{ $post_stats[$post->id]['views'] }}
                    @endif
                </td>
                <td width="20%">
                    {{-- @rowmenu(['items' => $post->btns])@endrowmenu --}}
                    <div class="btn-group pull-right">
                        <a href="{{route('websites.posts.show', ['website'=>$website->id,'post'=>$post->id])}}" title="Preview" class="btn btn-sm btn-info ">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a href="{{route('websites.posts.edit', ['website'=>$website->id,'post'=>$post->id])}}" title="Edit" class="btn btn-sm btn-primary ">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a href="{{route('websites.posts.analytics', ['website'=>$website->id,'post'=>$post->id])}}" title="Analytics" class="btn btn-sm btn-secondary ">
                            <i class="fa fa-bar-chart"></i>
                        </a>
                        <div class="btn-group">
                            <div class="dropdown show">
                                <a class="btn btn-sm btn-default dropdown-toggle" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-bars"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                    <a href="{{route('websites.posts.show', ['website'=>$website->id,'post'=>$post->id])}}" title="Preview" class="dropdown-item ">
                                        <i class="fa fa-eye"></i>
                                        Preview
                                    </a>
                                    <a href="{{route('websites.posts.edit', ['website'=>$website->id,'post'=>$post->id])}}" title="Edit" class="dropdown-item ">
                                        <i class="fa fa-edit"></i>
                                        Edit
                                    </a>

                                    {{-- PLEASE WATCH THE DATA-LINK ATTRIBUTE BELOW  --}}

                                    <a href="#" title="Copy Link" class="dropdown-item copy" data-link="https://www.yogurtconcoction.com/{{$post->id}}/image/index.html">
                                        <i class="fa fa-share"></i>
                                        Copy Link
                                    </a>
                                    {{-- PLEASE WATCH THE DATA-LINK ATTRIBUTE ABOVE  --}}


                                    <a href="{{route('websites.posts.edit', ['website'=>$website->id,'post'=>$post->id])}}" title="Save as new post" class="dropdown-item ">
                                        <i class="fa fa-clone"></i>
                                        Save as new post
                                    </a>
                                    <a href="{{route('websites.posts.analytics', ['website'=>$website->id,'post'=>$post->id])}}" title="Analytics" class="dropdown-item ">
                                        <i class="fa fa-bar-chart"></i>
                                        Analytics
                                    </a>
                                    <a href="" title="Delete..." class="dropdown-item delete" data-id="{{$post->id}}" data-url="{{route('websites.posts.delete', ['website'=>$website->id,'post'=>$post->id])}}">
                                        <i class="fa fa-trash-o"></i>
                                        Delete...
                                    </a>

                                </div>
                            </div>
                        </div>
                    </div>
                </td>
        </tr>
    @endforeach
    </tbody>
</table>
