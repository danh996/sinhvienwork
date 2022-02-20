<form action="{{route('job.list')}}" method="get">
	<!-- Page Title start -->
	<div class="pageSearch">
<div class="container">
				<div class="searchform">
					<div class="row">
						<div class="col-lg-9">
							<div class="form-group">
							    <select name="country_id[]" class="form-control">
							    	<option value="0">Toàn quốc ({{$totalJob}})</option>
								    @foreach($provinces as $province)
								      <option 
								      @if($province->country_id == $cookieProvinceId)
								      	selected
								      @endif
								       value="{{$province->id}}">{{$province->country}} ({{App\Job::countNumJobs('country_id', $province->country_id)}})</option>
								    @endforeach
							    </select>
  							</div>
						</div>

						<div class="col-lg-3">
							<button type="submit" class="btn"><i class="fa fa-search" aria-hidden="true"></i> {{__('Tìm kiếm')}}</button>
						</div>

					</div>
				</div>
</div>
	</div>
	<!-- Page Title end -->
</form>
