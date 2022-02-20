<h5>{{__('Đăng tin miễn phí')}}</h5>
@if(isset($job))
{!! Form::model($job, array('method' => 'put', 'route' => array('update.front.job', $job->id), 'class' => 'form')) !!}
{!! Form::hidden('id', $job->id) !!}
@else
{!! Form::open(array('method' => 'post', 'route' => array('store.front.job'), 'class' => 'form')) !!}
@endif
<div class="row">  
    <div class="col-md-12">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'title') !!}"> {!! Form::text('title', null, array('class'=>'form-control', 'id'=>'title', 'placeholder'=>__('Tiêu đề'))) !!}
            {!! APFrmErrHelp::showErrors($errors, 'title') !!} </div>
    </div>

     <div class="col-md-12">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'job_type_id') !!}" id="job_type_id_div"> {!! Form::select('job_type_id', ['' => __('Chọn ngôn ngữ')]+$jobTypes, null, array('class'=>'form-control', 'id'=>'job_type_id')) !!}
            {!! APFrmErrHelp::showErrors($errors, 'job_type_id') !!} </div>
    </div>

    
    

    <div class="col-md-12">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'description') !!}"> {!! Form::textarea('description', null, array('class'=>'form-control', 'id'=>'description', 'placeholder'=>__('Mô tả công việc'))) !!}
            {!! APFrmErrHelp::showErrors($errors, 'description') !!} </div>
    </div>

   <div class="col-md-12">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'title') !!}"> {!! Form::text('phone', null, array('class'=>'form-control', 'id'=>'phone', 'placeholder'=>__('Điện thoại liên hệ'))) !!}
            {!! APFrmErrHelp::showErrors($errors, 'phone') !!} </div>
    </div>

    <div class="col-md-12">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'country_id') !!}" id="country_id_div"> {!! Form::select('country_id', ['' => __('Chọn tỉnh thành')]+$countries, old('country_id', (isset($job))? $job->country_id:$siteSetting->default_country_id), array('class'=>'form-control', 'id'=>'country_id')) !!}
            {!! APFrmErrHelp::showErrors($errors, 'country_id') !!} </div>
    </div>
    <!-- <div class="col-md-4">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'state_id') !!}" id="state_id_div"> <span id="default_state_dd"> {!! Form::select('state_id', ['' => __('Chọn quận huyện')], null, array('class'=>'form-control', 'id'=>'state_id')) !!} </span> {!! APFrmErrHelp::showErrors($errors, 'state_id') !!} </div>
    </div> -->
    
    <div class="col-md-6">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'salary_from') !!}" id="salary_from_div"> {!! Form::text('salary_from', null, array('class'=>'form-control', 'id'=>'salary_from', 'placeholder'=>__('Mức lương tối thiểu'))) !!}
            {!! APFrmErrHelp::showErrors($errors, 'salary_from') !!} </div>
    </div>
    <div class="col-md-6">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'salary_to') !!}" id="salary_to_div">
            {!! Form::text('salary_to', null, array('class'=>'form-control', 'id'=>'salary_to', 'placeholder'=>__('Mức lương tối đa'))) !!}
            {!! APFrmErrHelp::showErrors($errors, 'salary_to') !!} </div>
    </div>
    <div class="col-md-12">
        <div class="formrow text-center">
            <button type="submit" class="btn btn-danger">{{__('Đăng tin')}} <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button>
        </div>
    </div>
    {!! Form::hidden('salary_to', null, array('class'=>'', 'id'=>'salary_to_real', 'placeholder'=>__(''))) !!}
    {!! Form::hidden('salary_from', null, array('class'=>'', 'id'=>'salary_from_real', 'placeholder'=>__(''))) !!}
</div>
<input type="file" name="image" id="image" style="display:none;" accept="image/*"/>
{!! Form::close() !!}
<hr>
@push('styles')
<style type="text/css">
    .datepicker>div {
        display: block;
    }
</style>
@endpush
@push('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        $('.select2-multiple').select2({
            placeholder: "{{__('Select Required Skills')}}",
            allowClear: true
        });
        $(".datepicker").datepicker({
            autoclose: true,
            format: 'yyyy-m-d'
        });
        $('#country_id').on('change', function (e) {
            e.preventDefault();
            filterLangStates(0);
        });
        $(document).on('change', '#state_id', function (e) {
            e.preventDefault();
            filterLangCities(0);
        });
        filterLangStates(<?php echo old('state_id', (isset($job)) ? $job->state_id : 0); ?>);

        $('#salary_to').on('change click keyup input paste',(function (event) {
            $(this).val(function (index, value) {
                    if (value != "") {
                        //return '$' + value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        $('#salary_to_real').val(value.replace(/\./g,''));

                        var components = value.toString().split(",");
                        if (components.length === 1)
                            components[0] = value;
                        components[0] = components[0].replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                        if (components.length === 2) {
                            components[1] = components[1].replace(/\D/g, '').replace(/^\d{3}$/, '.');
                        }

                        if (components.join('.') != '')
                            return components.join('.');
                        else
                            return '';
                    }
                });
        }));

        $('#salary_from').on('change click keyup input paste',(function (event) {
            $(this).val(function (index, value) {



                    if (value != "") {
                        $('#salary_from_real').val(value.replace(/\./g,''));

                        //return '$' + value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        
                        var components = value.toString().split(",");

                        if (components.length === 1)
                            components[0] = value;
                        components[0] = components[0].replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                        if (components.length === 2) {
                            components[1] = components[1].replace(/\D/g, '').replace(/^\d{3}$/, '.');
                        }

                        if (components.join('.') != '')
                            return components.join('.');
                        else
                            return '';
                    }
                });
        }));
    });
    function filterLangStates(state_id)
    {
        var country_id = $('#country_id').val();
        if (country_id != '') {
            $.post("{{ route('filter.lang.states.dropdown') }}", {country_id: country_id, state_id: state_id, _method: 'POST', _token: '{{ csrf_token() }}'})
                    .done(function (response) {
                        $('#default_state_dd').html(response);
                        filterLangCities(<?php echo old('city_id', (isset($job)) ? $job->city_id : 0); ?>);
                    });
        }
    }
    function filterLangCities(city_id)
    {
        var state_id = $('#state_id').val();
        if (state_id != '') {
            $.post("{{ route('filter.lang.cities.dropdown') }}", {state_id: state_id, city_id: city_id, _method: 'POST', _token: '{{ csrf_token() }}'})
                    .done(function (response) {
                        $('#default_city_dd').html(response);
                    });
        }
    }

    
</script> 
@endpush