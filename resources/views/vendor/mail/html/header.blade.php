<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'StemmaStudy')
<img src="{{ asset('/image/icon150.png') }}" class="logo" alt="StemmaStudy">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
