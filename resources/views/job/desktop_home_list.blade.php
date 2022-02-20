<ul class="searchList mobile-hide">
    @foreach($jobs as $job) @php $company =
        $job->getCompany();  @endphp
            <?php if(isset($company))
                {?>                        
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

                                        <!-- <div class="companyName">
                                            <i class="fa fa-user-o" aria-hidden="true"></i>
                                            {{$company->name}}
                                        </div> -->
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
                                            &nbsp; | &nbsp;
                                            <i style="color: #9b9b9b;" class="fa fa-bookmark-o" aria-hidden="true"></i>
                                            <span class="text-success font-weight-bold">Ngôn ngữ {{$job->jobType->name}}</span>
                                        </div>

                                        
                                    </div>

                                    <div class="clearfix"></div>

                                </div>

                                

                            </div>
                            </a>

                        </li>

						 <?php } ?>

                        <!-- job end --> 

                        @endforeach
     

                    </ul>