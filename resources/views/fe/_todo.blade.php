
    @if($datalist['todo_cnt'])
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    Account Setup - Next Steps
                </h4>
            </div>
            <style type="text/css">
                .material-icons.green {
                    color: green;
                }
                .feed-image img{
                    width: 100%;
                }
            </style>
            <ul class="list-group">
                @foreach($datalist['todo'] as $key => $value)
                    <li class="list-group-item @if($value['Status']== 'DONE')  list-group-item-success @endif">
                        <div class="media">
                            <div class="media-left media-middle">
                                <i class="material-icons md-24 @if($value['Status']== 'DONE') green @endif">@if($value['Status']== 'DONE') check_box @else check_box_outline_blank @endif</i>
                            </div>
                            <div class="media-body media-middle">
                                <strong>{{ $value['Title'] }}</strong>
                                @if($value['Status']== 'TODO')
                                    <p>{{ $value['Description'] }}
                                        <br />
                                        <a href="{{ route($value['Route']) }}">{{ $value['Link_title'] }}</a>
                                    </p>
                                @endif
                            </div>
                            <div class="media-right media-middle">
                                @if($value['Status']== 'TODO') TODO @else DONE @endif
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
@endif
