<table cellpadding="10" cellspacing="0" class="panel{{  isset($panel_class) ? " $panel_class" : '' }}">
<tr>
<td colspan="3" class="panel-head">
<span class="copy">
{{ isset($head) ? $head : '' }}
</span>
</td>
</tr>
@if(isset($rows))
@foreach ($rows as $item)
@if(!empty($item['text']))
<tr>
<td width="15%" align="center">
<img src="https://s3-us-west-2.amazonaws.com/dataczar-public/src/img/{{ $item['icon'] }}" alt="" width="15px">
</td>
<td>
@if( !empty($item['url']) ) 
<a href="{{ $item['url'] }}">{{ $item['text'] }}</a>
@else
{{ $item['text'] }}
@endif
</td>
<td width="15%" align="center">
@if(isset($item['icon-right']))
<img src="https://s3-us-west-2.amazonaws.com/dataczar-public/src/img/{{ $item['icon-right'] }}" alt="" width="15px">
@else(isset($item['status']))
{{ $item['status'] }} 
@endif
</td>
</tr>
@endif
@endforeach
@endif
@if(!empty($slot))
<tr>
<td colspan="3">
{{ $slot }}
</td>
</tr>
@endif
</table>
