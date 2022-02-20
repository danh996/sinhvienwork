<?php

namespace App\Http\Controllers\Job;

use Auth;
use DB;
use Input;
use Redirect;
use Carbon\Carbon;
use App\Job;
use App\JobApply;
use App\FavouriteJob;
use App\Company;
use App\JobSkillManager;
use App\Country;
use App\CountryDetail;
use App\State;
use App\City;
use App\CareerLevel;
use App\FunctionalArea;
use App\JobType;
use App\JobShift;
use App\Gender;
use App\Seo;
use App\JobExperience;
use App\DegreeLevel;
use App\ProfileCv;
use App\Helpers\MiscHelper;
use App\Helpers\DataArrayHelper;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DataTables;
use App\Http\Requests\JobFormRequest;
use App\Http\Requests\Front\ApplyJobFormRequest;
use App\Http\Controllers\Controller;
use App\Traits\FetchJobs;
use App\Events\JobApplied;
use Cookie;

class JobController extends Controller
{

    //use Skills;
    use FetchJobs;

    private $functionalAreas = '';
    private $countries = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['jobsBySearch', 'jobDetail']]);

        $this->functionalAreas = DataArrayHelper::langFunctionalAreasArray();
        $this->countries = DataArrayHelper::langCountriesArray();
    }

    public function jobsBySearch(Request $request)
    {
        $search = $request->query('search', '');
        $job_titles = $request->query('job_title', array());
        $company_ids = $request->query('company_id', array());
        $industry_ids = $request->query('industry_id', array());
        $job_skill_ids = $request->query('job_skill_id', array());
        $functional_area_ids = $request->query('functional_area_id', array());
        $is_freelance = $request->query('is_freelance', array());
        $career_level_ids = $request->query('career_level_id', array());
        $job_type_ids = $request->query('job_type_id', array());
        $job_shift_ids = $request->query('job_shift_id', array());
        $gender_ids = $request->query('gender_id', array());
        $degree_level_ids = $request->query('degree_level_id', array());
        $job_experience_ids = $request->query('job_experience_id', array());
        $salary_from = $request->query('salary_from', '');
        $salary_to = $request->query('salary_to', '');
        $salary_currency = $request->query('salary_currency', '');
        $is_featured = $request->query('is_featured', 2);
        $order_by = $request->query('order_by', 'id');
        $limit = 15;
        $provinceName      = null;

        if($request->country_id != null){
            $cookieProvinceId   =   $request->country_id;

            $country_ids[]      =   $request->country_id;

            $totalJob = Job::where('country_id', $cookieProvinceId)->active()->count();

            $this->saveCookieProvinceId($request->country_id);
        } else{
            $cookieProvinceId  = Cookie::get('provinceIdView');
            $totalJob = Job::where('country_id', $cookieProvinceId)->active()->count();
            if($cookieProvinceId){
                $country_ids = array($cookieProvinceId);
                
            }
        }

        
        if($request->job_type_id != null){
            $cookieJobTypeId     =   $request->job_type_id;
            $jobTypeIds[]      =   $request->job_type_id;

            $totalJob = Job::where('job_type_id', $cookieJobTypeId)->active()->count();

            $this->saveCookieJobTypeId($request->country_id);
        } else{
            $cookieJobTypeId  = Cookie::get('jobTypeIdView');
            $totalJob = Job::where('job_type_id', $cookieJobTypeId)->active()->count();
            if($cookieJobTypeId){
                $jobTypeIds = array($cookieJobTypeId);
                
            }
        }

        $province = Country::where('country_id', $cookieProvinceId)->active()->first();
        if($province){
            $provinceName   =   $province->country;
        }

        if($request->country_id[0] == 0){
            $country_ids = [];
        }

        if($request->job_type_id[0] == 0){
            $job_type_ids = [];
        }
       
        $jobs = $this->fetchJobs($search, $job_titles, $company_ids, $industry_ids, $job_skill_ids, $functional_area_ids, $country_ids, $is_freelance, $career_level_ids, $job_type_ids, $job_shift_ids, $gender_ids, $degree_level_ids, $job_experience_ids, $salary_from, $salary_to, $salary_currency, $is_featured, $order_by, $limit);

        /*         * ************************************************** */

        $totalActiveJob = Job::active()->count();

        $provinces  =   Country::all();
        
        $seo            =   $this->getSeo($cookieProvinceId, $cookieJobTypeId);
        $currentPage    =   $jobs->currentPage();
        $pagiPageList   =   $this->getPagiPageList($jobs);
        $jobTypes       =   JobType::all();

        return view('job.list')
            ->with('countries', $this->countries)
            ->with('jobs', $jobs)
            ->with('totalJob', $totalJob)
            ->with('totalActiveJob', $totalActiveJob)
            ->with('provinces', $provinces)
            ->with('cookieProvinceId', $cookieProvinceId)
            ->with('cookieJobTypeId', $cookieJobTypeId)
            ->with('jobTypes', $jobTypes)
            ->with('provinceName', $provinceName)
            ->with('pagiPageList', $pagiPageList)
            ->with('currentPage', $currentPage)
            ->with('seo', $seo);
    }

    public function jobDetail(Request $request, $job_slug)
    {

        $job = Job::where('slug', 'like', $job_slug)->firstOrFail();
        
        $country_ids = (array) $job->getCountry('country_id');

        $job_type_ids = (array) $job->getJobType('job_type_id');
        
        $this->saveJobView($job);

        // $relatedJobs = $this->fetchJobs($search, $job_titles, $company_ids, $industry_ids, $job_skill_ids, $functional_area_ids, $country_ids, $state_ids, $city_ids, $is_freelance, $career_level_ids, $job_type_ids, $job_shift_ids, $gender_ids, $degree_level_ids, $job_experience_ids, $salary_from, $salary_to, $salary_currency, $is_featured, $order_by, $limit);
        $relatedJobs = Job::where('is_active', 1)
            ->where('country_id', $country_ids[0])
            ->inRandomOrder()->take(12)->get();
        /*         * ***************************************** */
        
        /*         * ************************************************** */
        $seo = (object) array(
                    'seo_title' => $job->title . ' - ' . $job->id . ' | Tuyển dụng lái xe',
                    'seo_description' => $job->description,
                    'seo_keywords' => $job->description,
                    'seo_other' => ''
        );


        return view('job.detail')
                        ->with('job', $job)
                        ->with('relatedJobs', $relatedJobs)
                        ->with('seo', $seo);
    }

    /*     * ************************************************** */

    public function addToFavouriteJob(Request $request, $job_slug)
    {
        $data['job_slug'] = $job_slug;
        $data['user_id'] = Auth::user()->id;
        $data_save = FavouriteJob::create($data);
        flash(__('Job has been added in favorites list'))->success();
        return \Redirect::route('job.detail', $job_slug);
    }

    public function removeFromFavouriteJob(Request $request, $job_slug)
    {
        $user_id = Auth::user()->id;
        FavouriteJob::where('job_slug', 'like', $job_slug)->where('user_id', $user_id)->delete();

        flash(__('Job has been removed from favorites list'))->success();
        return \Redirect::route('job.detail', $job_slug);
    }

    public function applyJob(Request $request, $job_slug)
    {
        $user = Auth::user();
        $job = Job::where('slug', 'like', $job_slug)->first();
        
        if ((bool)$user->is_active === false) {
            flash(__('Your account is inactive contact site admin to activate it'))->error();
            return \Redirect::route('job.detail', $job_slug);
            exit;
        }
        
        if ((bool) config('jobseeker.is_jobseeker_package_active')) {
            if (
                    ($user->jobs_quota <= $user->availed_jobs_quota) ||
                    ($user->package_end_date->lt(Carbon::now()))
            ) {
                flash(__('Please subscribe to package first'))->error();
                return \Redirect::route('home');
                exit;
            }
        }
        if ($user->isAppliedOnJob($job->id)) {
            flash(__('You have already applied for this job'))->success();
            return \Redirect::route('job.detail', $job_slug);
            exit;
        }
        
        

        $myCvs = ProfileCv::where('user_id', '=', $user->id)->pluck('title', 'id')->toArray();

        return view('job.apply_job_form')
                        ->with('job_slug', $job_slug)
                        ->with('job', $job)
                        ->with('myCvs', $myCvs);
    }

    public function postApplyJob(ApplyJobFormRequest $request, $job_slug)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $job = Job::where('slug', 'like', $job_slug)->first();

        $jobApply = new JobApply();
        $jobApply->user_id = $user_id;
        $jobApply->job_id = $job->id;
        $jobApply->cv_id = $request->post('cv_id');
        $jobApply->current_salary = $request->post('current_salary');
        $jobApply->expected_salary = $request->post('expected_salary');
        $jobApply->salary_currency = $request->post('salary_currency');
        $jobApply->save();

        /*         * ******************************* */
        if ((bool) config('jobseeker.is_jobseeker_package_active')) {
            $user->availed_jobs_quota = $user->availed_jobs_quota + 1;
            $user->update();
        }
        /*         * ******************************* */
        event(new JobApplied($job, $jobApply));

        flash(__('You have successfully applied for this job'))->success();
        return \Redirect::route('job.detail', $job_slug);
    }

    public function myJobApplications(Request $request)
    {
        $myAppliedJobIds = Auth::user()->getAppliedJobIdsArray();
        $jobs = Job::whereIn('id', $myAppliedJobIds)->paginate(10);
        return view('job.my_applied_jobs')
                        ->with('jobs', $jobs);
    }

    public function myFavouriteJobs(Request $request)
    {
        $myFavouriteJobSlugs = Auth::user()->getFavouriteJobSlugsArray();
        $jobs = Job::whereIn('slug', $myFavouriteJobSlugs)->paginate(10);
        return view('job.my_favourite_jobs')
                        ->with('jobs', $jobs);
    }

    private function saveCookieProvinceId($provinceIds){
        if(is_array($provinceIds)){
            $provinceId   = $provinceIds[0];    
        } else {
            $provinceId   = $provinceIds;    
        }
        Cookie::forget('provinceIdView');
        
        Cookie::queue('provinceIdView', $provinceId, 60 * 24 * 30);
    }

    private function saveCookieJobTypeId($jobTypeIds){
        if(is_array($jobTypeIds)){
            $jobTypeId   = $jobTypeIds[0];    
        } else {
            $jobTypeId   = $jobTypeIds;    
        }
        Cookie::forget('jobTypeIdView');
        
        Cookie::queue('jobTypeIdView', $jobTypeId, 60 * 24 * 30);
    }

    private function saveJobView($job)
    {
        $jobId   = $job->id;
        $jobIds  = Cookie::get('userViewJobIds');
        $jobIds  = json_decode($jobIds);

        if (!$jobIds) {
            $jobIds = [];
            $job->view_number += 1;
            $job->save();
        } else {
            if (!in_array($jobId, $jobIds)) {
                $job->view_number += 1;
                $job->save();
            }
        }
        array_push($jobIds, $jobId);
        Cookie::queue('userViewJobIds', json_encode($jobIds), 60 * 24 * 30);
    }

    private function getPagiPageList($jobs){
        $curentPage     =   $jobs->currentPage();
        $lastPage       =   $jobs->lastPage();
        $listPage       =   [];

        for ($i = $curentPage - 3; $i < $curentPage + 3; $i++) { 
            if($i > $lastPage) break;
            if($i <= 0) continue;
            $listPage[] = $i;
        }
        return $listPage;
    }

    private function getSeo($provinceId, $jobTypeId){
        $jobType = JobType::find($jobTypeId);
        $province = Country::find($provinceId);
        if($jobType && $province){
            $seoTitle = 'Việc làm tiếng '. $jobType->name . ' tại '.$province->country;
        } else if($jobType){
            $seoTitle = 'Việc làm tiếng '. $jobType->name;
        } else if($province){
            $seoTitle = 'Việc làm ngôn ngữ tại '.$province->country;
        } else{
            $seoTitle = 'Việc làm ngôn ngữ - Chuyên trang tìm việc giành cho các ứng viên ngành ngôn ngữ trên toàn quốc';
        }


        $seo = (object) array(
            'seo_title' => $seoTitle,
            'seo_description' => $seoTitle,
            'seo_keywords' => $seoTitle,
            'seo_other' => ''
        );

        return $seo;
    }

}
