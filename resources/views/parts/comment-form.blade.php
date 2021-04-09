@if(Auth::check())
	<form id="form-comment" action="{{ route('comment.store',['comic_id'=>$comic->id]) }}" method="POST">
		{{ csrf_field() }}
		<div class="form-group">
			<textarea class="form-control" rows="5" name="frm_content"></textarea>
		</div>
		<div class="text-right">
			@if($sticker_packages_count > 0)<a href="javascript:void(0)" class="btn btn-default show_sticker">{{ __('Stickers') }}</a>@endif
			<input type="hidden" name="type">
			<button type="submit" class="btn btn-primary">{{ __('Gửi ') }}<i class="fa fa-paper-plane"></i></button>
		</div>
		@include('parts.sticker-packages')
	</form>
@else
	<h4 class="notify">{!! __('Vui lòng ').'<a href="'.route('storeLoginCustomer').'">'.__('đăng nhập').'</a>'.__(' để sử dụng chức năng này!') !!}</h4>
@endif