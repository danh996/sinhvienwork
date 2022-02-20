<?php

namespace App\Http\Controllers;

use App;
use App\Seo;
use App\Job;
use App\Company;
use App\FunctionalArea;
use App\Country;
use App\JobType;
use App\Testimonial;
use App\SiteSetting;
use App\Slider;
use App\Blog;
use Illuminate\Http\Request;
use Redirect;
use App\Traits\CompanyTrait;
use App\Traits\FunctionalAreaTrait;
use App\Traits\CityTrait;
use App\Traits\JobTrait;
use App\Traits\Active;
use App\Helpers\DataArrayHelper;
use App\Traits\FetchJobs;
use Cookie;
use App\Models\MapSlug;

class IndexController extends Controller
{

    use CompanyTrait;
    use FunctionalAreaTrait;
    use CityTrait;
    use JobTrait;
    use Active;
    use FetchJobs;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
        $this->countries = DataArrayHelper::langCountriesArray();

        //$this->setupData();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $search = $request->query('search', '');
        $job_titles = $request->query('job_title', array());
        $company_ids = $request->query('company_id', array());
        $industry_ids = $request->query('industry_id', array());
        $job_skill_ids = $request->query('job_skill_id', array());
        $functional_area_ids = $request->query('functional_area_id', array());
        $country_ids = $request->query('country_id', array());
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
        $limit = 20;

        $provinceName      = null;
        
        $requestProvinceId = $request->country_id;
        $jobTypeId = $request->job_type_id;

        if($requestProvinceId){
            $this->saveCookieProvinceId($requestProvinceId);
        } else {
            $requestProvinceId  =   Cookie::get('provinceIdView');
        }

        if($jobTypeId){
            $this->saveCookieJobTypeId($request->job_type_id);
        } else {
            $jobTypeId  =   Cookie::get('jobTypeIdView');
        }
        
        //return redirect()->route('getListJobBySlug', ['slug' => ]);


        $jobs = $this->fetchJobs($search, $job_titles, $company_ids, $industry_ids, $job_skill_ids, $functional_area_ids, $country_ids, $is_freelance, $career_level_ids, $job_type_ids, $job_shift_ids, $gender_ids, $degree_level_ids, $job_experience_ids, $salary_from, $salary_to, $salary_currency, $is_featured, $order_by, $limit);


        
        /*         * ************************************************** */

        $seo            =   $this->getSeo($requestProvinceId, $jobTypeId);
        $provinces      =   Country::all();
        $pagiPageList   =   $this->getPagiPageList($jobs);
        $currentPage    =   $jobs->currentPage();
        $totalActiveJob =   Job::active()->count();
        $jobTypes       =   JobType::all();        
        $jobTypeRequest =   JobType::where('id', $jobTypeId)->first();
        $province       =   Country::where('country_id', $requestProvinceId)->first();
        if($province){
            $provinceName   =   $province->country;
        }
        $totalJob       =   $jobs->total();

        return view('job.list')
                        ->with('countries', $this->countries)
                        ->with('jobs', $jobs)
                        ->with('totalJob', $totalJob)
                        ->with('totalActiveJob', $totalActiveJob)
                        ->with('provinces', $provinces)
                        ->with('jobTypes', $jobTypes)
                        ->with('cookieProvinceId', $requestProvinceId)
                        ->with('provinceName', $provinceName)
                        ->with('province', $province)
                        ->with('pagiPageList', $pagiPageList)
                        ->with('currentPage', $currentPage)
                        ->with('jobTypeId', $jobTypeId)
                        ->with('jobTypeRequest', $jobTypeRequest)
                        ->with('seo', $seo);

        $topCompanyIds = $this->getCompanyIdsAndNumJobs(16);
        $topFunctionalAreaIds = $this->getFunctionalAreaIdsAndNumJobs(32);
        $topIndustryIds = $this->getIndustryIdsFromCompanies(32);
        $topCityIds = $this->getCityIdsAndNumJobs(32);
        $featuredJobs = Job::active()->featured()->notExpire()->limit(12)->orderBy('id', 'desc')->get();
        $latestJobs = Job::active()->notExpire()->orderBy('id', 'desc')->limit(18)->get();
        $blogs = Blog::orderBy('id', 'desc')->where('lang', 'like', \App::getLocale())->limit(3)->get();
        $video = Video::getVideo();
        $testimonials = Testimonial::langTestimonials();

        $functionalAreas = DataArrayHelper::langFunctionalAreasArray();
        $countries = DataArrayHelper::langCountriesArray();
		$sliders = Slider::langSliders();

        $seo = SEO::where('seo.page_title', 'like', 'front_index_page')->first();
        return view('welcome')
                        ->with('topCompanyIds', $topCompanyIds)
                        ->with('topFunctionalAreaIds', $topFunctionalAreaIds)
                        ->with('topCityIds', $topCityIds)
                        ->with('topIndustryIds', $topIndustryIds)
                        ->with('featuredJobs', $featuredJobs)
                        ->with('latestJobs', $latestJobs)
                        ->with('blogs', $blogs)
                        ->with('functionalAreas', $functionalAreas)
                        ->with('countries', $countries)
						->with('sliders', $sliders)
                        ->with('video', $video)
                        ->with('testimonials', $testimonials)
                        ->with('seo', $seo);
    }

    public function setLocale(Request $request)
    {
        $locale = $request->input('locale');
        $return_url = $request->input('return_url');
        $is_rtl = $request->input('is_rtl');
        $localeDir = ((bool) $is_rtl) ? 'rtl' : 'ltr';

        session(['locale' => $locale]);
        session(['localeDir' => $localeDir]);

        return Redirect::to($return_url);
    }
	
	public function checkTime()

    {
        $siteSetting = SiteSetting::findOrFail(1272);
        $t1 = strtotime( date('Y-m-d h:i:s'));
        $t2 = strtotime( $siteSetting->check_time );
        $diff = $t1 - $t2;
        $hours = $diff / ( 60 * 60 );
        if($hours>=1){
            $siteSetting->check_time = date('Y-m-d h:i:s');
            $siteSetting->update();
            Artisan::call('schedule:run');
            echo 'done';
        }else{
            echo 'not done';
        }

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

    private function saveCookieJobTypeId($jobTypeIds){
        if(is_array($jobTypeIds)){
            $jobTypeId   = $jobTypeIds[0];    
        } else {
            $jobTypeId   = $jobTypeIds;    
        }
        Cookie::forget('jobTypeIdView');
        
        Cookie::queue('jobTypeIdView', $jobTypeId, 60 * 24 * 30);
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

    public function createSlug($title)
    {
        $title = trim(mb_strtolower($title));
        $title = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $title);
        $title = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $title);
        $title = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $title);
        $title = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $title);
        $title = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $title);
        $title = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $title);
        $title = preg_replace('/(đ)/', 'd', $title);
        $title = preg_replace('/[^a-z0-9\s]/', '', $title);
        $title = preg_replace('/([\s]+)/', '-', $title);
        
        return $title;
    }

    

    public function getListJobBySlug(Request $request)
    {

        $slug       =   $request->slug;
        $mapSlug    =   MapSlug::where('slug', $slug)->first();

        if(!$mapSlug) abort(404);

        $provinceId =   $mapSlug->province_id;
        $jobTypeId  =   $mapSlug->job_type_id;

        $jobs = $this->fetchJobsNew($provinceId, $jobTypeId);
        
        $seo            =   $this->getSeo($provinceId, $jobTypeId);
        $provinces      =   Country::all();
        $pagiPageList   =   $this->getPagiPageList($jobs);
        $currentPage    =   $jobs->currentPage();
        $totalActiveJob =   Job::active()->count();
        $jobTypes       =   JobType::all();
        $totalJob       =   $jobs->total();
        $province       =   Country::where('country_id', $provinceId)->first();
        $jobTypeRequest =   JobType::where('id', $jobTypeId)->first();

        $provinceName   =   null;
        if($province){
            $provinceName   =   $province->country;
        }

        return view('job.list-by-slug')
                        ->with('countries', $this->countries)
                        ->with('slug', $slug)
                        ->with('jobs', $jobs)
                        ->with('totalJob', $totalJob)
                        ->with('totalActiveJob', $totalActiveJob)
                        ->with('provinces', $provinces)
                        ->with('jobTypes', $jobTypes)
                        ->with('pagiPageList', $pagiPageList)
                        ->with('currentPage', $currentPage)
                        ->with('jobTypeId', $jobTypeId)
                        ->with('provinceId', $provinceId)
                        ->with('provinceName', $provinceName)
                        ->with('jobTypeRequest', $jobTypeRequest)
                        ->with('seo', $seo);

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
}
