<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class JobFormRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        
        switch ($this->method()) {
            case 'PUT':
            case 'POST': {
                    $id = (int) $this->input('id', 0);
                    $job_unique = '';
                    if ($id > 0) {
                        $job_unique = ',id,' . $id;
                    }
                    return [
                        "id" => "",
                        "company_id" => "required",
                        "title" => "required",
                        "description" => "required",
                        "country_id" => "required",
                        "state_id" => "required",
                        
                        //"job_shift_id" => "required",
                        //"num_of_positions" => "required",
                        //"gender_id" => "required",
                        //"degree_level_id" => "required",
                    ];
                }
            default:break;
        }
    }

    public function messages()
    {
        return [
            'company_id.required' => 'Please select Company.',
            'title.required' => 'Vui lòng điền Tiêu đề công việc.',
            'description.required' => 'Vui lòng điền Mô tả công việc.',
            'benefits.required' => 'Please enter Job Benefits.',
            'skills.required' => 'Please enter Job skills.',
            'country_id.required' => 'Vui lòng chọn tỉnh, thành phố.',
            'state_id.required' => 'Vui lòng chọn phường xã',
            'city_id.required' => 'Please select City.',
            //'is_freelance.required' => 'Is this freelance Job?',
            //'career_level_id.required' => 'Please select Career level.',
            //'salary_from.required' => 'Please select salary from.',
            //'salary_to.required' => 'Please select salary to.',
            //'salary_currency.required' => 'Please select salary currency.',
            //'salary_period_id.required' => 'Please select salary period.',
            //'hide_salary.required' => 'Is salary hidden?',
            'functional_area_id.required' => 'Please select functional area.',
            'job_type_id.required' => 'Please select job type.',
            //'job_shift_id.required' => 'Please select job shift.',
            //'num_of_positions.required' => 'Please select number of positions.',
            //'gender_id.required' => 'Please select gender.',
            'expiry_date.required' => 'Please enter Job expiry date.',
            //'degree_level_id.required' => 'Please select degree level.',
            'job_experience_id.required' => 'Please select job experience.',
            'is_active.required' => 'Is this Job active?',
            'is_featured.required' => 'Is this Job featured?',
        ];
    }

}
