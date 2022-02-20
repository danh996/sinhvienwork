<!--Footer-->
<!-- <div class="largebanner shadow3">
<div class="adin">
{!! $siteSetting->above_footer_ad !!}
</div>
<div class="clearfix"></div>
</div>

 -->




<div class="footerWrap"> 
    <div class="container">
        <div class="row"> 

            <!--Quick Links-->
            <div class="col-md-3 col-sm-6">
                <h5>{{__('Về chúng tôi')}}</h5>
                <p>Việc làm tài xế là chuyên trang tuyển dụng tài xế hàng đầu Việt Nam.</p>
                <!--Quick Links menu Start-->
                <!-- <ul class="quicklinks">
                    <li><a href="{{ route('index') }}">{{__('Home')}}</a></li>
                    <li><a href="{{ route('contact.us') }}">{{__('Contact Us')}}</a></li>
                    <li class="postad"><a href="{{ route('post.job') }}">{{__('Post a Job')}}</a></li>
                    <li><a href="{{ route('faq') }}">{{__('FAQs')}}</a></li>
                    @foreach($show_in_footer_menu as $footer_menu)
                    @php
                    $cmsContent = App\CmsContent::getContentBySlug($footer_menu->page_slug);
                    @endphp

                    <li class="{{ Request::url() == route('cms', $footer_menu->page_slug) ? 'active' : '' }}"><a href="{{ route('cms', $footer_menu->page_slug) }}">{{ $cmsContent->page_title }}</a></li>
                    @endforeach
                </ul> -->
            </div>
            <!--Quick Links menu end-->

            <div class="col-md-3 col-sm-6">
                <h5>{{__('Việc làm theo ngôn ngữ')}}</h5>
                <!--Quick Links menu Start-->
                <ul class="quicklinks">
                    <li><a href="{{route('getListJobBySlug', ['slug' => 'viec-lam-tieng-anh'])}}">
                        Việc làm Tiếng Anh
                    </a></li>
                    <li><a href="{{route('getListJobBySlug', ['slug' => 'viec-lam-tieng-trung'])}}">
                        Việc làm Tiếng Trung
                    </a></li>
                    <li><a href="{{route('getListJobBySlug', ['slug' => 'viec-lam-tieng-han'])}}">
                        Việc làm Tiếng Hàn
                    </a></li>
                    <li><a href="{{route('getListJobBySlug', ['slug' => 'viec-lam-tieng-nhat'])}}">
                        Việc làm Tiếng Nhật
                    </a></li>
                    <li><a href="{{route('getListJobBySlug', ['slug' => 'viec-lam-tieng-phap'])}}">
                        Việc làm Tiếng Pháp
                    </a></li>
                    <li><a href="{{route('getListJobBySlug', ['slug' => 'viec-lam-tieng-duc'])}}">
                        Việc làm Tiếng Đức
                    </a></li>
                    <li><a href="{{route('getListJobBySlug', ['slug' => 'viec-lam-tieng-nga'])}}">
                        Việc làm Tiếng Nga
                    </a></li>
                    <li><a href="{{route('getListJobBySlug', ['slug' => 'viec-lam-tieng-thai'])}}">
                        Việc làm Tiếng Thái
                    </a></li>
                    <li><a href="{{route('getListJobBySlug', ['slug' => 'viec-lam-tieng-a-rap'])}}">
                        Việc làm Tiếng Ả Rập
                    </a></li>
                    
                    <!-- @php
                    $functionalAreas = App\FunctionalArea::getUsingFunctionalAreas(10);
                    @endphp
                    @foreach($functionalAreas as $functionalArea)
                    <li><a href="{{ route('job.list', ['functional_area_id[]'=>$functionalArea->functional_area_id]) }}">{{$functionalArea->functional_area}}</a></li>
                    @endforeach -->
                </ul>
            </div>

            <!--Jobs By Industry-->
            <div class="col-md-3 col-sm-6">
                <h5>{{__('Việc làm theo tỉnh thành')}}</h5>
                <!--Industry menu Start-->
                <ul class="quicklinks">

                    <li><a href="{{route('getListJobBySlug', ['slug' => 'viec-lam-ngon-ngu-tai-tp-ho-chi-minh'])}}">
                        Tp. Hồ Chí Minh
                    </a></li>

                    <li><a href="{{route('getListJobBySlug', ['slug' => 'viec-lam-ngon-ngu-tai-ha-noi'])}}">
                        Hà Nội
                    </a></li>
                    
                    <li><a href="{{route('getListJobBySlug', ['slug' => 'viec-lam-ngon-ngu-tai-da-nang'])}}">
                        Đà Nẵng
                    </a></li>

                    <li><a href="{{route('getListJobBySlug', ['slug' => 'viec-lam-ngon-ngu-tai-can-tho'])}}">
                        Cần Thơ
                    </a></li>
                    <li><a href="{{route('getListJobBySlug', ['slug' => 'viec-lam-ngon-ngu-tai-hai-phong'])}}">
                        Hải Phòng
                    </a></li>

                    <!-- @php
                    $industries = App\Industry::getUsingIndustries(10);
                    @endphp
                    @foreach($industries as $industry)
                    <li><a href="{{ route('job.list', ['industry_id[]'=>$industry->industry_id]) }}">{{$industry->industry}}</a></li>
                    @endforeach -->
                </ul>
                <!--Industry menu End-->
                <div class="clear"></div>
            </div>

            <!--About Us-->
            <div class="col-md-3 col-sm-12">
                <h5>{{__('Liên hệ')}}</h5>
                <!-- <div class="address">{{ $siteSetting->site_street_address }}</div>
                <div class="email"> <a href="mailto:{{ $siteSetting->mail_to_address }}">{{ $siteSetting->mail_to_address }}</a> </div>
                <div class="phone"> <a href="tel:{{ $siteSetting->site_phone_primary }}">{{ $siteSetting->site_phone_primary }}</a></div> -->
                <!-- Social Icons -->
                <div class="social">@include('includes.footer_social')</div>
                <!-- Social Icons end --> 

            </div>
            <!--About us End--> 


        </div>
    </div>
</div>
<!--Footer end--> 
<!--Copyright-->
