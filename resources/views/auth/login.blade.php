@extends('layouts.app')
@section('content')
<!-- Header start -->
@include('includes.header')
<!-- Header end --> 
<!-- Inner Page Title start -->
@include('includes.inner_page_title', ['page_title'=>__('Đăng nhập')])
<!-- Inner Page Title end -->
<div class="listpgWraper">
    <div class="container">
        @include('flash::message')
       
            <div class="useraccountwrap">
                <div class="userccount">
                    <div class="userbtns">
                        <ul class="nav nav-tabs">
                            <?php
                            $c_or_e = old('candidate_or_employer', 'candidate');
                            ?>
                            
                        </ul>
                    </div>
					
					
                    <div class="tab-content">
                        
                        <div id="employer" class="formpanel tab-pane active {{($c_or_e == 'employer')? 'active':''}}">
                            <div class="socialLogin">
                                        <h5 class="m-5">{{__('Đăng nhập ')}}</h5>



                                        <a href="{{ url('login/employer/facebook')}}" class="btn btn-primary fb"><i class="fa fa-facebook fa-lg mr-3" aria-hidden="true"></i>
                                            <span>Đăng nhập với Facebook</span>
                                            </a> 

                                        <div class="w-25 m-auto separator d-flex align-items-center py-3">
<div class="line flex-grow-1"></div>
<div class="px-2 fw-medium">
OR
</div>
<div class="line flex-grow-1"></div>
</div>

                                        <a href="{{ url('login/employer/google')}}" class="btn btn-danger tw">    <i class="fa fa-google fa-lg mr-3" aria-hidden="true"></i>
                                            <span>Đăng nhập với Google</span>
                                        </a> </div>
                            
                            <!-- sign up form -->
                    <!-- <div class="newuser"><i class="fa fa-user" aria-hidden="true"></i> {{__('New User')}}? <a href="{{route('register')}}">{{__('Register Here')}}</a></div>
                    <div class="newuser"><i class="fa fa-user" aria-hidden="true"></i> {{__('Forgot Your Password')}}? <a href="{{ route('company.password.request') }}">{{__('Click here')}}</a></div> -->
                    <!-- sign up form end-->
                        </div>
                    </div>
                    <!-- login form -->

                     

                </div>
            </div>
        
    </div>
</div>
@include('includes.footer')
@endsection
