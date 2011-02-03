<!-- "previous page" action -->
<!-- root element for scrollable -->

<div class="scrollable-content clearfix">
	<div class="scrollable" id="myscroll">
	   <!-- root element for the items -->
	   <div class="items">
	   		<div>
	         <img id="img-1" src="http://farm4.static.flickr.com/3629/3323896446_3b87a8bf75_t.jpg" />
	   		</div>
	   		<div>
	        <img id="img-2" src="http://farm4.static.flickr.com/3629/3323896446_3b87a8bf75_t.jpg" />
	   		</div>
	   		<div>
	         <img id="img-3" src="http://farm4.static.flickr.com/3023/3323897466_e61624f6de_t.jpg" />
	   		</div>
	   		<div>
	         <img id="img-1" src="http://farm4.static.flickr.com/3650/3323058611_d35c894fab_t.jpg" />
	   		</div>
	   		<div>
	         <img id="img-1" src="http://farm4.static.flickr.com/3635/3323893254_3183671257_t.jpg" />
	   		</div>
	   		<div>
	         <img id="img-1" src="http://farm4.static.flickr.com/3624/3323893148_8318838fbd_t.jpg" />
	   		</div>
	   </div>
	</div>
	<!-- "next page" action -->
	<a class="prev browse left slide-back-link" id="slide-back-link"></a>
	<a class="next browse left slide-next-link" id="slide-next-link"></a>
	<span class="img-counter">1</span><span>/5</span>
</div>



<script type="text/javascript">
	jQuery("#myscroll").scrollable({
	  circular: true
	});

	jQuery('#slide-next-link').bind('click', function() {
		var lChildren = jQuery('.scrollables .items > div').size();
		debug.log(lChildren);
	});
</script>