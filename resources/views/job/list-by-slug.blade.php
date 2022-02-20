@extends('layouts.app')

@section('content') 

<!-- Header start --> 

@include('includes.header') 

<!-- Header end --> 

<!-- Inner Page Title start --> 



@include('includes.home_sliders') 

<div class="desktop-hide">
    @include('includes.home_counter') 
</div>
<!-- Inner Page Title end -->

<div class="listpgWraper">


    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="searchform mobile-hide">
                        <form>
                        <div class="form-row">
    <div class="form-group col-md-6">
      <select id="searchProvince" name="job_type_id" class="form-control">
                                <option value="0">Chọn Ngôn Ngữ</option>
                                    @foreach($jobTypes as $jobType)
                                        <option
                                            @if($jobType->job_type_id == $jobTypeId)
                                                selected
                                            @endif
                                            value="{{$jobType->id}}">{{$jobType->job_type}} ({{App\Job::countNumJobs('job_type_id', $jobType->job_type_id)}})
                                        </option>
                                    @endforeach
                            </select>
    </div>
    <div class="form-group col-md-4">
      <select id="searchProvince" name="country_id" class="form-control">
                                <option value="0">Toàn quốc ({{$totalActiveJob}})</option>
                                @foreach($provinces as $province)
                                    <option 
                                        @if($province->country_id == $provinceId)
                                            selected
                                        @endif
                                        value="{{$province->id}}">{{$province->country}} ({{App\Job::countNumJobs('country_id', $province->country_id)}})
                                    </option>
                                @endforeach
                            </select>
    </div>
    <div class="form-group col-md-2">
      <button class="w-100 btn btn-danger">
                <i class="fa fa-search" aria-hidden="true"></i>
                Tìm kiếm
            </button>
    </div>
  </div>
  
</form>


                       
                    
                </div>

            </div>
        </div>
    </div>


    <div class="searchform desktop-hide text-center mb-3">

        <div class="form-group">
            <select id="searchProvince" name="country_id[]" class="form-control">
                <option value="0">Chọn Ngôn Ngữ</option>
                    @foreach($jobTypes as $jobType)
                        <option
                            @if($jobType->job_type_id == $jobTypeId)
                                selected
                            @endif value="{{$jobType->id}}">{{$jobType->job_type}} ({{App\Job::countNumJobs('job_type_id', $jobType->job_type_id)}})
                        </option>
                    @endforeach
            </select>
        </div>

            <div class="form-group">
                <select id="searchProvinceMobile" name="country_id[]" class="form-control">
                    <option value="0">Toàn quốc ({{$totalActiveJob}})</option>
                        @foreach($provinces as $province)
                    <option 
                        @if($province->country_id == $provinceId)
                            selected
                        @endif value="{{$province->id}}">{{$province->country}} ({{App\Job::countNumJobs('country_id', $province->country_id)}})
                    </option>
                        @endforeach
                </select>
            </div>
            <button class="btn btn-danger">
                <i class="fa fa-search" aria-hidden="true"></i>
                Tìm kiếm
            </button>
    </div>

    <div class="container">

        

        <form action="{{route('job.list')}}" method="get">

            <!-- Search Result and sidebar start -->




            <div class="row"> 
                

                <ul class="searchList desktop-hide">

                        <!-- job start --> 

                        @if(isset($jobs) && count($jobs)) <?php $count_1 = 1; ?> @foreach($jobs as $job) @php $company =

                            $job->getCompany();  @endphp

                             <?php if(isset($company))
                            {
                            ?>

                            <?php if($count_1 == 7) {?>

                                <!-- <li class="inpostad">{!! $siteSetting->listing_page_horizontal_ad !!}</li> -->

                            <?php }else{ ?>

                        <li class="li-mobile">

                            <a style="text-decoration: none; color: #333" href="{{route('job.detail', [$job->slug])}}" title="{{$job->title}}">

                                <div class="d-flex">
                                    <!-- <div class="relatedjob-image pt-3">
                                        <img width="50px" src="{{$company->logo}}" class="rounded-circle">
                                    </div> -->
                                    <div class="">
                                        <p class="font-weight-bold mb-3" style="color: #2980b9">{{$job->title}}</p>
                                        <p class="font-weight-bold text-danger">
                                            <i class="fa fa-money" aria-hidden="true"></i>
                                           {{$job->showSalary()}}
                                        </p>
                                    

                                    <div class="jobinfo">

                                        <div class="companyName">
                                            <i class="fa fa-user-o" aria-hidden="true"></i>
                                            {{$company->name}}
                                        </div>
                                        <div class="time-view my-2">
                                            <i style="color: #9b9b9b;" class="fa fa-clock-o" aria-hidden="true"></i>
                                            {{$job->getTimeCreated()}}
                                            &nbsp; | &nbsp;
                                            <i style="color: #9b9b9b;" class="fa fa-eye" aria-hidden="true"></i>
                                            {{$job->view_number}}
                                        </div>
                                        <div class="location my-2">
                                            <i style="color: #9b9b9b;" class="fa fa-map-marker" aria-hidden="true"></i>
                                            {{$job->getCountry('country')}}
                                        </div>

                                        

                                    </div>
                                    </div>

                                    <div class="clearfix"></div>

                                </div>

                                

                            </a>

<!--                             <p>{{\Illuminate\Support\Str::limit(strip_tags($job->description), 150, '...')}}</p>
 -->
                        </li>

                        

                         <?php } ?>

                            <?php $count_1++; ?>

                        

                         <?php } ?>

                        <!-- job end --> 

                        @endforeach @endif

                            <!-- job end -->

                            

                        

                        

                        

                    </ul>

        <!-- Search List -->
                    
                <div class="col-lg-8 col-sm-12"> 

                    @include('flash::message')
                    
                    @if($provinceName && $jobTypeRequest)
                        <h4>{{$totalJob}} việc làm Tiếng {{$jobTypeRequest->name}} tại {{$provinceName}}</h4>
                    @elseif($jobTypeRequest)
                        <h4>Có {{$totalJob}} việc làm Tiếng {{$jobTypeRequest->name}} đang đợi bạn</h4>
                    @elseif($provinceName)
                        <h4>Có {{$totalJob}} việc làm ngôn ngữ tại {{$provinceName}} đang đợi bạn</h4>
                    @endif
                    <ul class="searchList mobile-hide">

                        <!-- job start --> 

                        @if(isset($jobs) && count($jobs)) <?php $count_1 = 1; ?> @foreach($jobs as $job) @php $company =

                            $job->getCompany();  @endphp

                             <?php if(isset($company))
                            {
                            ?>

                            <?php if($count_1 == 7) {?>

                                <!-- <li class="inpostad">{!! $siteSetting->listing_page_horizontal_ad !!}</li> -->

                            <?php }else{ ?>

                        <li>

                            <a style="text-decoration: none; color: #333" href="{{route('job.detail', [$job->slug])}}" title="{{$job->title}}">
                                <div class="row">

                                <div class="col">
                                    <h4 style="color: #2980b9; line-height: 1.5;" class="mb-2">{{$job->title}}</h4>
                                    <div class="salary mb-3">
                                        <span class="font-weight-bold text-danger">
                                           Mức lương: {{$job->showSalary()}}
                                        </span>
                                    </div>
                                    <!-- <div class="jobimg">
                                        <img width="50px" src="{{$company->logo}}" class="rounded-circle">
                                    </div> -->

                                    <div class="jobinfo">

                                        <div class="companyName">
                                            <i class="fa fa-user-o" aria-hidden="true"></i>
                                            {{$company->name}}
                                        </div>
                                        <div class="time-view my-2">
                                            <i style="color: #9b9b9b;" class="fa fa-clock-o" aria-hidden="true"></i>
                                            {{$job->getTimeCreated()}}
                                            &nbsp; | &nbsp;
                                            <i style="color: #9b9b9b;" class="fa fa-eye" aria-hidden="true"></i>
                                            {{$job->view_number}}
                                        </div>

                                        <div class="location my-2">
                                            <i style="color: #9b9b9b;" class="fa fa-map-marker" aria-hidden="true"></i>
                                            {{$job->getCountry('country')}}
                                        </div>

                                        
                                    </div>

                                    <div class="clearfix"></div>

                                </div>

                                

                            </div>
                            </a>

<!--                             <p>{{\Illuminate\Support\Str::limit(strip_tags($job->description), 150, '...')}}</p>
 -->
                        </li>

						

						 <?php } ?>

                            <?php $count_1++; ?>

						

						 <?php } ?>

                        <!-- job end --> 

                        @endforeach @endif

                            <!-- job end -->

                            

						

						

						

                    </ul>
                    <!-- Pagination Start -->

                    <div class="pagiWrap">

                        <div class="row">

                            

                            <div class="col d-flex justify-content-center">

                                @if(isset($jobs) && count($jobs))
                                    <a href="{{route('getListJobBySlug', ['page' => $currentPage == 1 ? $currentPage : $currentPage - 1, 'slug' => $slug])}}" class="pagi-number">
                                        <i class="fa fa-angle-double-left" aria-hidden="true"></i>
                                    </a>
                                    @foreach($pagiPageList as $page)
                                        <a href="{{route('getListJobBySlug', ['page' => $page, 'slug' => $slug])}}" class="pagi-number @if($page == $currentPage)active @endif">{{$page}}</a>
                                    @endforeach
                                    
                                    <a href="{{route('getListJobBySlug', ['page' => $currentPage + 1, 'slug' => $slug])}}" class="pagi-number">
                                        <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                                    </a>
                                @endif

                            </div>

                        </div>

                    </div>

                    <!-- Pagination end --> 
                </div>





				<div class="col-lg-4 col-sm-6 pull-right mobile-hide">


                    @include('includes.home_counter') 


                    <!-- <a  href="{{ route('post.job') }}" class="btn btn-danger mobile-hide">
                         <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        Đăng tin ngay - miến phí
                    </a> -->

                                    

                    <!-- Side Bar start -->
                    
                    <!-- Sponsord By -->

                    <!-- <div class="sidebar">

                        <h4 class="widget-title">{{__('Sponsord By')}}</h4>

                        <div class="gad">{!! $siteSetting->listing_page_vertical_ad !!}</div>

                    </div> -->

                </div>

				

            </div>

        </form>

    </div>

</div>

<div class="modal fade" id="show_alert" role="dialog">

    <div class="modal-dialog">



        <!-- Modal content-->

        <div class="modal-content">

            <form id="submit_alert">

                @csrf

                <input type="hidden" name="search" value="{{ Request::get('search') }}">

                <input type="hidden" name="country_id" value="@if(isset(Request::get('country_id')[0])) {{ Request::get('country_id')[0] }} @endif">

                <input type="hidden" name="state_id" value="@if(isset(Request::get('state_id')[0])){{ Request::get('state_id')[0] }} @endif">

                <input type="hidden" name="city_id" value="@if(isset(Request::get('city_id')[0])){{ Request::get('city_id')[0] }} @endif">

                <input type="hidden" name="functional_area_id" value="@if(isset(Request::get('functional_area_id')[0])){{ Request::get('functional_area_id')[0] }} @endif">

                <div class="modal-header">

                    <h4 class="modal-title">Job Alert</h4>

                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>

                <div class="modal-body">

					

					<h3>Get the latest <strong>{{ ucfirst(Request::get('search')) }}</strong> jobs  @if(Request::get('location')!='') in <strong>{{ ucfirst(Request::get('location')) }}</strong>@endif sent straight to your inbox</h3>

                    <div class="form-group">

                        <input type="text" class="form-control" name="email" id="email" placeholder="Enter your Email"

                            value="@if( Auth::check() ) {{Auth::user()->email}} @endif">

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                    <button type="submit" class="btn btn-primary">Submit</button>

                </div>

            </form>

        </div>



    </div>

</div>

@include('includes.footer')
@include('includes.footer-home-mobile')

@endsection

@push('styles')

<style type="text/css">

    .searchList li .jobimg {

        min-height: 80px;

    }

    .hide_vm_ul{

        height:100px;

        overflow:hidden;

    }

    .hide_vm{

        display:none !important;

    }

    .view_more{

        cursor:pointer;

    }

</style>

@endpush

@push('scripts') 

<script type="text/javascript">

    // $('#searchProvince, #searchProvinceMobile').on('change', function(){
    //     var provinceId = $('#searchProvince').val();
    //     var url = 'http://ksd.local/jobs?country_id='+provinceId +'';
    //     console.log(url);
    //     window.location.replace(url);
    // })

$('.btn-job-alert').on('click', function() {
    @if(Auth::user())
    $('#show_alert').modal('show');
    @else
    swal({
        title: "Save Job Alerts",

        text: "To save Job Alerts you must be Registered and Logged in",

        icon: "error",

        buttons: {
        Login: "Login",
        register: "Register",
        hello: "OK",
      },
});
    @endif

})

     $(document).ready(function ($) {
        $("#search-job-list").submit(function () {
            $(this).find(":input").filter(function () {
                return !this.value;
            }).attr("disabled", "disabled");
            return true;
        });



        $("#search-job-list").find(":input").prop("disabled", false);



        $(".view_more_ul").each(function () {

            if ($(this).height() > 100)

            {

                $(this).addClass('hide_vm_ul');

                $(this).next().removeClass('hide_vm');

            }

        });

        $('.view_more').on('click', function (e) {

            e.preventDefault();

            $(this).prev().removeClass('hide_vm_ul');

            $(this).addClass('hide_vm');

        });



    });

    if ($("#submit_alert").length > 0) {

    $("#submit_alert").validate({



        rules: {

            email: {

                required: true,

                maxlength: 5000,

                email: true

            }

        },

        messages: {

            email: {

                required: "Email is required",

            }



        },

        submitHandler: function(form) {

            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                }

            });

            $.ajax({

                url: "{{route('subscribe.alert')}}",

                type: "GET",

                data: $('#submit_alert').serialize(),

                success: function(response) {

                    $("#submit_alert").trigger("reset");

                    $('#show_alert').modal('hide');

                    swal({

                        title: "Success",

                        text: response["msg"],

                        icon: "success",

                        button: "OK",

                    });

                }

            });

        }

    })

}

 $(document).on('click','.swal-button--Login',function(){
        window.location.href = "{{route('login')}}";
     })
     $(document).on('click','.swal-button--register',function(){
        window.location.href = "{{route('register')}}";
     })

</script>

@include('includes.country_state_city_js')

@endpush