
	@if (Auth::check())
		@php 
			$user = Auth::user(); 
		@endphp
		<aside class="avatar">
			{!! image($user->image, 230, 230, $user->name) !!}
			<button type="button" id="pro-picture" class="library" data-route="{{ route('avatarProfile') }}"><i class="fal fa-camera"></i></span>
		</aside>
		<aside class="pro-name">
			<h4>{{ $user->name }}</h4>
		</aside>
		<aside class="pro-info">
			<ul class="list-item list-unstyled">
				<li class="point">
					<i class="fas fa-level-up-alt"></i>
					<span>Cấp độ: {{ ($user->level_id != '') ? getLevelByUser($user->level_id) : '' }}</span>
				</li>
				<li class="birthday">
					<i class="fal fa-calendar"></i>
					<span>Sinh nhật: {{ ($user->birthday != '') ? customDateConvert($user->birthday) : '00-00-0000' }}</span>
				</li>
			</ul>
		</aside>
	@endif