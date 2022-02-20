            <div class="sidebar">
        <input type="hidden" name="search" value="{{Request::get('search', '')}}"/>
       
        <!-- Jobs By Job Type -->
        <div class="widget">
            <h4 class="widget-title">{{__('Loại tin đăng')}}</h4>
            <ul class="optionlist view_more_ul">
                @if(isset($jobTypeIdsArray) && count($jobTypeIdsArray))
                @foreach($jobTypeIdsArray as $key=>$job_type_id)
                @php
                $jobType = App\JobType::where('job_type_id','=',$job_type_id)->lang()->active()->first();
                @endphp
                @if(null !== $jobType)
                @php
                $checked = (in_array($jobType->job_type_id, Request::get('job_type_id', array())))? 'checked="checked"':'';
                @endphp
                <li>
                    <input type="checkbox" name="job_type_id[]" id="job_type_{{$jobType->job_type_id}}" value="{{$jobType->job_type_id}}" {{$checked}}>
                    <label for="job_type_{{$jobType->job_type_id}}"></label>
                    {{$jobType->job_type}} <span>{{App\Job::countNumJobs('job_type_id', $jobType->job_type_id)}}</span> </li>
                @endif
                @endforeach
                @endif
            </ul>
            <span class="text text-primary view_more hide_vm">{{__('View More')}}</span> 
            <div class="searchnt">
                <button type="submit" class="btn"><i class="fa fa-search" aria-hidden="true"></i> {{__('Tìm kiếm')}}</button>
            </div>
        </div>
        <!-- Jobs By Job Type end --> 



        <!-- Side Bar end --> 
    </div>
