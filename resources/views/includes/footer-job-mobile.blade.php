<div class="bottom-bar desktop-hide">
	<ul class="bottom-bar__content"> 
	

	<li class="bottom-bar__item"><div class="item">
		<a href="{{ URL::previous() }}" class="parent">
		<i class="fa fa-arrow-left" aria-hidden="true"></i>
		<p>Về Danh Sách</p>
		</a>
		</div>
	</li>

	<li class="bottom-bar__item"><div class="item">
		<a href="tel:{{$job->phone}}" class="parent text-danger font-weight-bold">
		<i class="fa fa-phone fa-2x" aria-hidden="true"></i>
		<p class="font-weight-bold">Gọi Điện</p></a></div>
	</li>
</div>

<div id="phonering-alo-phoneIcon" class="mobile-hide phonering-alo-phone phonering-alo-green phonering-alo-show">
	
<a href="{{route('post.job')}}" class="hotline-wrap font-weight-bold h5">
	<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
	Đăng Tin
</a>
