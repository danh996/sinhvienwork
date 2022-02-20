@extends('layouts.app')
@section('content') 
<!-- Header start --> 
@include('includes.header') 
<!-- Header end --> 
<!-- Inner Page Title start --> 
@include('includes.inner_page_title', ['page_title'=>__('Chi tiết công việc')]) 
<!-- Inner Page Title end -->
@include('flash::message')


@php
$company = $job->getCompany();
@endphp

<div class="listpgWraper">
    <div class="container"> 
        @include('flash::message')
       

        <!-- Job Detail start -->
        <div class="row">
            <div class="col-md-8"> 
				
				 <!-- Job Header start -->
        <div class="job-header">
            <div class="jobinfo">
               
                <h4 style="color: #2980b9; line-height: 1.3">{{$job->title}}</h4>
                <p style="color: #222;">
                    <i class="fa fa-clock-o" aria-hidden="true"></i>
                    {{$job->getTimeCreated()}}
                    &nbsp;&nbsp;|&nbsp;&nbsp;
                    <i class="fa fa-eye" aria-hidden="true"></i>
                    {{$job->view_number}}
                </p>		
                <p style="color: #222;">
                    <i class="fa fa-map-marker" aria-hidden="true"></i> <span>{{$job->getLocation()}}</span>
                </p>
                <p class="salary font-weight-bold text-danger">
                    Mức lương: {{$job->showSalary()}}
                </p>
                    
            </div>
			
			<!-- Job Detail start -->
                
			
        </div>
				
				
				
                <!-- Job Description start -->
                <div class="job-header">
                    <div class="contentbox">
                        <h4>{{__('Mô tả công việc')}}</h4>
                        <p>{!! $job->description !!}</p>                       
                    </div>
                </div>
				
                <hr>
            <!-- <div class="jobButtons">
                

                @if(Auth::check() && Auth::user()->isFavouriteJob($job->slug)) <a href="{{route('remove.from.favourite', $job->slug)}}" class="btn"><i class="fa fa-floppy-o" aria-hidden="true"></i> {{__('Lưu tin')}} </a> @else <a href="{{route('add.to.favourite', $job->slug)}}" class="btn"><i class="fa fa-floppy-o" aria-hidden="true"></i> {{__('Lưu tin')}}</a> @endif

                <a href="{{route('report.abuse', $job->slug)}}" class="btn report"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{__('Báo cáo tin đăng')}}</a>
            </div> -->
			
                
            </div>
            <!-- related jobs end -->

            <div class="col-md-4"> 
				<!-- related jobs start -->
                <div class="jobmainreq">
                       
                        <div class="companyinfo">
                            <div class="companylogo"><a href="{{route('company.detail',$company->slug)}}">
                                <img width="40px" src="{{$company->logo}}" class="rounded-circle">
                            </a></div>
                            <div class="title">
                                <span style="line-height: 1.5">Tin được đăng bởi: </span>
                                <br>
                                <a href="{{route('company.detail',$company->slug)}}">{{$company->name}}</a></div>
                            <div class="clearfix"></div>
               
                        </div>
                        <hr>
                </div>

                <div class="jobmainreq mobile-hide">
                                <button class="d-flex justify-content-between w-100 btn btn-success" id="showPhone">
                                    <div><i class="fa fa-phone fa-2x" aria-hidden="true"></i>
                                    &nbsp
                                    <span class="h5 font-weight-bold">{{$job->hidePhone()}}</span>
                                </div>
                                    <span class="h5 font-weight-bold">Bấm để hiện số</span>
                                </button>
                            
               
                        </div>
                       
                </div>
            
                
                
            </div>
        </div>
    </div>
</div>

<div class="listpgWraper pt-0">
    <div class="container"> 
        

        <!-- Job Detail start -->
                            <h4 style="padding-top: 10px">{{__('Việc làm tương tự')}}</h4>
 
        <div class="row relatedJobs">
                        @if(isset($relatedJobs) && count($relatedJobs))
                        @foreach($relatedJobs as $relatedJob)
                        <?php $relatedJobCompany = $relatedJob->getCompany(); ?>
                        @if(null !== $relatedJobCompany)
                        <!--Job start-->
                        <div class="col-md-4">
                                    <div class="jobinfo bg-white d-flex">
                                        
                                        <div class="relatedjob-info">
                                            <a href="{{route('job.detail', [$relatedJob->slug])}}" title="{{$relatedJob->title}}">
                                                <h5 style="line-height: 1.5">{{$relatedJob->title}}</h5>
                                            </a>
                                            
                                            <p>
                                                <i class="fa fa-clock-o" aria-hidden="true"></i>
                                                {{$relatedJob->getTimeCreated()}}
                                                &nbsp;&nbsp;|&nbsp;&nbsp;
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                                {{$relatedJob->view_number}}
                                            </p>      
                                            
                                            <p>
                                                <i class="fa fa-map-marker" aria-hidden="true"></i> 
                                                <span>{{$relatedJob->getLocation()}}</span>
                                            </p>
                                            <p class="salary font-weight-bold text-danger">
                                                <i class="fa fa-money" aria-hidden="true"></i>
                                                {{$relatedJob->showSalary()}}
                                            </p>
                                        </div>

                                    </div>
                                    <div class="clearfix"></div>
                                                           
                        </div>
                        <!--Job end--> 
                        @endif
                        @endforeach
                        @endif

                        <!-- Job end -->
        </div>
           
                
                
    </div>
</div>

@include('includes.footer')
@include('includes.footer-job-mobile')

@endsection
@push('styles')
<style type="text/css">
    .view_more{display:none !important;}
</style>
@endpush
@push('scripts') 
<script>
    $(document).ready(function ($) {
        $("form").submit(function () {
            $(this).find(":input").filter(function () {
                return !this.value;
            }).attr("disabled", "disabled");
            return true;
        });
        $("form").find(":input").prop("disabled", false);

        $(".view_more_ul").each(function () {
            if ($(this).height() > 100)
            {
                $(this).css('height', 100);
                $(this).css('overflow', 'hidden');
                //alert($( this ).next());
                $(this).next().removeClass('view_more');
            }
        });



    });

    $('#showPhone').on('click', function(){
        var p = "{{$job->phone}}"
        $('#showPhone').empty();
        $('#showPhone').removeClass('d-flex');
        $('#showPhone').html('<div><i class="fa fa-phone fa-2x" aria-hidden="true"></i>&nbsp&nbsp&nbsp<span class="h5 font-weight-bold">'+ p +'</span></div>')});
</script> 
@endpush