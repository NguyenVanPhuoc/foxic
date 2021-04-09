@if($withdrawal->status == 'completed')
	<div>Yêu cầu {{ $withdrawal->title }} đã được duyệt.</div> 
@elseif($withdrawal->status == 'cancelled')
	<div>Yêu cầu {{ $withdrawal->title }} đã bị hủy.</div> 
@endif