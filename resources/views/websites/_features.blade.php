<figure class="figure img-thumbnail" style="max-width: 110px; min-height: 200px; overflow:hidden; text-align: center;">
    <a href="{{ route('websites.create.preview', ['template_id'=>$template->id]) }}">
        <img src="{{ $template->thumburl }}" class="">
        <figcaption class="figure-caption text-center">
        {{ $template->name }}
        </figcaption>
    </a>
</figure>
