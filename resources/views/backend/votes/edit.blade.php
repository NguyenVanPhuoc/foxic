@extends('backend.layout.index')
@section('title','Sửa')
@section('content')
	<div id="create-writer" class="container catProduct-page product-page route">
		<div class="head">
			<a href="{{ route('votesAdmin') }}" class="back-icon"><i class="fa fa-angle-left" aria-hidden="true"></i> {{ _('Tất cả') }}</a>
			<h1 class="title">{{ _('Sửa tác giả') }}</h1>
		</div>
		<div class="main">
			<form action="{{ route('editVoteAdmin', $votes->id) }}" class="dev-form activity-form" method="POST" name="create_writer" role="form">
				{{ csrf_field() }}
				<div class="form-group">
					<label for="title">{{ _('Tên') }}<small class="required">(*)</small></label>
					<input type="text" name="title" class="form-control" placeholder="Nhập tên " value="{{ $votes->title }}">
				</div>
				<div id="frm-vote" class="form-group">
					<label for="vote">{{ __('Số phiếu') }}<small class="required">(*)</small></label>
					<input type="text" name="vote" class="form-control"  placeholder="Nhập số phiếu" value="{{ $votes->vote }}">
				</div>
				<div id="frm-amount" class="form-group">
					<label for="amount">{{ __('Số lượng xu hoặc point') }}<small class="required">(*)</small></label>
					<input type="text" name="amount" class="form-control"  placeholder="Nhập số lượng xu hoặc point" value="{{ $votes->amount }}">
				</div>
				<div id="frm-choose" class="form-group">
					<div class="form-group custom-controls-stacked d-block my-3" >
						<label for="choose_point" class="lb-choose_point">{{ _('Chọn loại muốn đổi') }}</label>
						<div class="radio radio-success radio-inline">
							<input name="choose_point" type="radio" id="yes" class="custom-control-input" value="0" @if($votes->choose_point == '0') {{ "checked" }} @endif>
							<label for="yes">{{ _('Xu') }}</label>
						</div>
						<div class="radio radio-success radio-inline">
							<input name="choose_point" type="radio" id="no" class="custom-control-input" value="1" @if($votes->choose_point == '1') {{ "checked" }} @endif>
							<label for="no">{{ _('Point') }}</label>
						</div>
					</div>
				</div>
				
				<div class="group-action">
					<button type="submit" name="submit" class="btn">{{ _('Cập nhật') }}</button>
					<a href="{{ route('votesAdmin') }}" class="btn btn-cancel">{{ _('Huỷ') }}</a>
				</div>
			</form>
		</div>
	</div>
@endsection