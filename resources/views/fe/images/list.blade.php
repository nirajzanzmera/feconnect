    @if($subdir !== '')
        <a href="" data-dir="" data-field_name="{{ $field_name }}" class="list-group-item folder">
            <i class="fa fa-fw fa-arrow-left"></i>
            ../
        </a>
        <li class="list-group-item">
            <i class="fa fa-fw fa-folder-open"></i>
            {{ $subdir }}
        </li>
    @endif
    @foreach ($dirs as $dir)
    <a href="" data-dir="{{ pathinfo($dir)['basename']}}" data-field_name="{{ $field_name }}" class="list-group-item folder">
        <i class="fa fa-fw fa-folder"></i>
        {{ pathinfo($dir)['basename'] }}
    </a>
    @endforeach
    @foreach ($files as $file)
    <li class="list-group-item">
        <div class="media">
            <div class="media-left">
                <a href="">
                    <div class="square">
                        <div class="img-thumb select" style="background-image: url('{{ $baseurl . $file }}');" data-url="{{ $baseurl . $file }}">&nbsp;</div>
                    </div>
                </a>
            </div>
            <div class="media-body media-middle">

                {{-- {{ pathinfo($file)['basename'] }} --}}
                
                <div class="btn-group pull-right">
                    {{-- <a href="{{ $baseurl . $file }}" target="_blank" class="btn btn-sm btn-info" title="Preview">
                        <i class="fa fa-eye"></i>
                        Preview
                    </a> --}}
                    <a href="" class="btn btn-sm btn-primary select" title="Use this image" data-url="{{ $baseurl . $file }}">
                        <i class="fa fa-mouse-pointer"></i>
                        Select
                    </a>
                    {{--
                    <a href="" class="btn btn-sm btn-danger" title="Delete...">
                        <i class="fa fa-trash"></i>
                        Delete...
                    </a>
                    --}}
                </div>
            </div>
        </div>
    </li>
    @endforeach
