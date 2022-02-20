<div class="bottom-bar desktop-hide">
	<ul class="bottom-bar__content"> 
	<li class="bottom-bar__item"><div class="item"><a href="{{route('posted.jobs')}}" class="parent">
		<i class="fa fa-bars" aria-hidden="true"></i>
		<p>Tin Đã Đăng</p></a></div></li>

	<li class="bottom-bar__item"><div class="item">
		<a href="{{route('post.job')}}" class="parent text-danger font-weight-bold">
		<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
		<p>Đăng Tin</p>
		</a>
		</div>
	</li>


	@if(Auth::guard('company')->check())
        <li class="bottom-bar__item">
            <img src="{{Auth::guard('company')->user()->logo}}">
        </li>
    @endif

	@if(!Auth::user() && !Auth::guard('company')->user())
        <li class="bottom-bar__item">
            <div class="item">
                <a href="{{route('login')}}" class="nav-link">
                    <i class="fa fa-user-o" aria-hidden="true"></i>
                    <p>{{__('Đăng nhập')}}</p>
                </a> 
            </div>
        </li>						                            
    @endif

	
	</ul>
</div>

<div id="phonering-alo-phoneIcon" class="mobile-hide phonering-alo-phone phonering-alo-green phonering-alo-show">
	
<a href="{{route('post.job')}}" class="hotline-wrap font-weight-bold h5">
	<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
	Đăng Tin
</a>
