<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\JobType;
use App\Country;
use App\Models\MapSlug;

class SetupData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $jobTypes   = JobType::all();
        $provinces  = Country::all();

        MapSlug::truncate();

        foreach ($jobTypes as $key => $value) {
            $mapSlug = new MapSlug();
            $title = 'Việc làm tiếng '. $value->name;
            $mapSlug->slug = $this->createSlug($title);
            $mapSlug->job_type_id = $value->id;
            $mapSlug->save();
        }

        foreach ($provinces as $key => $value) {
            $mapSlug = new MapSlug();
            $title = 'Việc làm Ngôn ngữ tại '. $value->country;
            $mapSlug->slug = $this->createSlug($title);
            $mapSlug->province_id = $value->id;
            $mapSlug->save();
        }

        foreach ($jobTypes as $key => $jobType) {
            foreach ($provinces as $key => $province) {
                $mapSlug = new MapSlug();
                $title = 'Việc làm Ngôn ngữ ' . $jobType->name . ' tại '. $province->country;
                $mapSlug->slug = $this->createSlug($title);
                $mapSlug->province_id = $province->id;
                $mapSlug->job_type_id = $jobType->id;
                $mapSlug->save();
            }
        }

        $provinces  = Country::where('id', '>', 3)->orderBy('country', 'ASC')->get();
        foreach ($provinces as $key => $value) {
            $sortOrder = $key+4;
            settype($sortOrder, "integer");
            $value->sort_order = $sortOrder;
            $value->save();
        }
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
}
