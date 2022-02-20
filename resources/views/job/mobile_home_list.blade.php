<ul class="searchList desktop-hide">

                        <!-- job start --> 

                        @foreach($jobs as $job) @php $company =

                            $job->getCompany();  @endphp

                             <?php if(isset($company))
                            {
                            ?>

                           

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
                                    </div>

                                    <div class="clearfix"></div>

                                </div>

                                

                            </a>

<!--                             <p>{{\Illuminate\Support\Str::limit(strip_tags($job->description), 150, '...')}}</p>
 -->
                        </li>

                       

                         <?php } ?>

                        <!-- job end --> 

                        @endforeach

                            <!-- job end -->

                            

                        

                        

                        

                    </ul>
