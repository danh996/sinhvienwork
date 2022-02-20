@extends('layouts.app')
@section('content')
<!-- Header start -->
@include('includes.header')
<!-- Header end --> 
<!-- Inner Page Title start -->
@include('includes.inner_page_title', ['page_title'=>__('Việc làm đã đăng')])
<!-- Inner Page Title end -->
<div class="listpgWraper">
    <div class="container">
        <div class="row">

            <div class="col-md-9 col-sm-8"> 
                @include('flash::message')
                <div class="myads">
                    <h3>{{__('Việc làm đã đăng')}}</h3>
                    <ul class="searchList">
                        <!-- job start --> 
                        @if(isset($jobs) && count($jobs))
                        @foreach($jobs as $job)
                        @php $company = $job->getCompany(); @endphp
                        @if(null !== $company)
                        <li id="job_li_{{$job->id}}">
                            <div class="row p-2">
                                    
                                    <div class="jobinfo">
                                        <h4 style="color: #2980b9; line-height: 1.3"><a href="{{route('job.detail', [$job->slug])}}" title="{{$job->title}}">{{$job->title}}</a></h4>
                                        
                                        <p class="font-weight-bold text-danger">
                                            <i class="fa fa-money" aria-hidden="true"></i>
                                           {{$job->showSalary()}}
                                        </p>
                                        
                                        <div class="location">
                                        
                                        <div class="location my-2">
                                            <i style="color: #9b9b9b;" class="fa fa-map-marker" aria-hidden="true"></i>
                                            {{$job->getCountry('country')}}
                                            &nbsp;&nbsp;| &nbsp;&nbsp;
                                            <i style="color: #9b9b9b;" class="fa fa-clock-o" aria-hidden="true"></i>
                                            {{$job->getTimeCreated()}}
                                            &nbsp;&nbsp;| &nbsp;&nbsp;
                                            <i style="color: #9b9b9b;" class="fa fa-eye" aria-hidden="true"></i>
                                            {{$job->view_number}}

                                        </div>

                                                                         </div>
                                    <div class="clearfix"></div>
                                </div>
                                
                            <!-- <p>{{\Illuminate\Support\Str::limit(strip_tags($job->description), 150, '...')}}</p> -->

                            <div class="d-flex justify-content-center mt-3 w-100">                
                                    
                                    <a style="font-size: 0.9rem;" class="btn btn-secondary" href="{{route('edit.front.job', [$job->id])}}">{{__('Sửa')}}</a>
                                    <a style="font-size: 0.9rem;" class="btn btn-success ml-3" href="{{route('up.front.job', [$job->id])}}">
                                        <i class="fa fa-angle-double-up" aria-hidden="true"></i>
                                    {{__('Đẩy tin')}}</a>

                                    <a style="font-size: 0.9rem;" class="btn btn-danger ml-3" href="javascript:;" onclick="deleteJob({{$job->id}});">{{__('Ẩn tin')}}</a>
                                    
                                </div>
                                
                        </li>
                        <!-- job end --> 
                        @endif
                        @endforeach
                        @endif
                    </ul>
					
					
					 <!-- Pagination Start -->

                    <div class="pagiWrap">

                        <div class="row">

                            <div class="col-md-5">

                                <div class="showreslt">

                                    {{__('Showing Pages')}} : {{ $jobs->firstItem() }} - {{ $jobs->lastItem() }} {{__('Total')}} {{ $jobs->total() }}

                                </div>

                            </div>

                            <div class="col-md-7 text-right">

                                @if(isset($jobs) && count($jobs))

                                {{ $jobs->appends(request()->query())->links() }}

                                @endif

                            </div>

                        </div>

                    </div>

                    <!-- Pagination end --> 
					
                </div>
            </div>
        </div>
    </div>
</div>
@include('includes.footer')
@endsection
@push('scripts')
<script type="text/javascript">
    function deleteJob(id) {
    var msg = 'Bạn chắc chắn ẩn tin này chứ?';
    if (confirm(msg)) {
    $.post("{{ route('delete.front.job') }}", {id: id, _method: 'DELETE', _token: '{{ csrf_token() }}'})
            .done(function (response) {
            if (response == 'ok')
            {
            $('#job_li_' + id).remove();
            } else
            {
            alert('Request Failed!');
            }
            });
    }
    }
</script>
@endpush