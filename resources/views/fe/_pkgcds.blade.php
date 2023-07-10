
@if(!empty($pkgcds))
<div class="card">
    <div class="card-header">
        <h4 class="card-title">
            My eBooks
        </h4>
    </div>
    <div class="list-group">
        @foreach($pkgcds as $item)
        <a class="list-group-item" href="{{ $item->path }}" target="_blank">
            <div class="media">
                <div class="media-left">
                    <i class="material-icons text-muted-dark">file_download</i>
                </div>
                <div class="media-body media-middle">
                    {{ $item->description }}
                </div>
                <div class="media-right">
                    1.7MB
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endif
