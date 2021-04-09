@if($type=="news" && $transactions)
	@php $count = 0; $type = empty($_GET["type"])? 'news' : $_GET["type"]@endphp
	<table id="news-transactions" class="table table-striped list">
		<thead class="thead-dark">
			<tr>
				<th id="check-all" scope="col" class="check">
					<div class="checkbox checkbox-success">
						<input id="check" type="checkbox" name="checkAll">
						<label for="check"></label>
					</div>
				</th>
				<th class="stt">STT</th>
				<th class="image hidden-424">Ảnh bài viết</th>
				<th class="title">Tiêu đề</th>
				<th class="start-time hidden-768"">Ngày kích hoạt</th>
				<th class="end-time hidden-667">Loại tin</th>
				<th class="status hidden-768">Trạng thái</th>
				<th class="member hidden-480">Thành viên</th>
				<th class="action">Tác vụ</th>
			</tr>
		</thead>
		<tbody>
			@foreach($transactions as $item) @php $count++; $status = checkStatusVip($item->end_time) @endphp
			<tr id="item-{{$item->vip_id}}">
				<td class="check">
					<div class="checkbox checkbox-success">
						<input id="article-{{$item->vip_id}}" type="checkbox" name="checkAll" value="{{$item->vip_id}}">
						<label for="article-{{$item->vip_id}}"></label>
					</div>
				</td>
				<td class="stt">{{$count}}</td>
				<td class="image hidden-424"><a href="{{ route('editNewsProfile',['id'=>$item->id]) }}" data-img="{{getImgUrlConfig($item->image,135,100)}}">{!!image($item->image, 100,50, $item->name)!!}</a></td>
				<td class="title"><a href="{{ route('editNewsProfile',['id'=>$item->id]) }}">{{$item->title}}</a></td>
				<td class="start-time hidden-768">{{dateShow($item->start_time)}}</td>
				<td class="package hidden-667">{{$item->package_title}}</td>
				<td class="status status-{{$status['value']}} hidden-768"><span>{{ $status['title'] }}</span></td>
				<td class="member hidden-480">
	                <a href="{{ route('editAdmin',['id'=>$item->user_id]) }}">{{$item->username}}</a>
				</td>
				<td class="action">
					<a href="{{route('deleteTransactionAdmin',['type'=>$type,'id'=>$item->vip_id])}}" class="delete"><i class="fa fa-close" aria-hidden="true"></i></a>
					@handheld<a href="javascript:void(0);" class="view"><i class="fa fa-eye" aria-hidden="true"></i></a>@endhandheld
				</td>
			</tr>
				@handheld
					<tr class="item-{{ $item->vip_id }} info-detail">
						<td colspan="14">
							<div class="box">
								<ul class="list-unstyled">
									<li>Tiêu đề: <strong><a href="{{ route('editBlogAdmin',['id'=>$item->id]) }}">{{$item->title}}</a></strong></li>
									<li>Ngày kích hoạt: <strong>{{ $item->start_time }}</strong></li>
									<li>Loại tin: <strong>{{$item->package_title}}</strong></li>
									<li>Trạng thái: <strong>{{ $status['title'] }}</strong></li>
									<li>Thành viên: <strong><a href="{{ route('editAdmin',['id'=>$item->user_id]) }}">{{ $item->username }}</a></strong></li>
								</ul>
								<a href="{{ route('editBlogAdmin',['id'=>$item->id]) }}" class="read-more"><i class="fa fa-angle-right" aria-hidden="true"></i>Chi tiết</a>
							</div>
						</td>
					</tr>
				@endhandheld
			@endforeach
		</tbody>
	</table>
@endif