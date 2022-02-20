
<div class="container p-3 text-center bg-white">
	<h3 class="counter" data-count="{{$totalActiveJob}}">0 </h3> việc làm ngôn ngữ đang đợi bạn
</div>


@push('scripts') 

<script type="text/javascript">
	$('.counter').each(function() {
	  var $this = $(this),
	      countTo = $this.attr('data-count');
	  
	  $({ countNum: $this.text()}).animate({
	    countNum: countTo
	  },

	  {

	    duration: 8000,
	    easing:'linear',
	    step: function() {
	      $this.text(Math.floor(this.countNum));
	    },
	    complete: function() {
	      $this.text(this.countNum);
	      //alert('finished');
	    }

	  });  
	});
</script>

@endpush