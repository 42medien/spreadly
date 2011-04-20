<?php use_helper('ChartData') ?>
<?php //var_dump($pData->getPrefilledLikesByHour()); ?>
<div id="chart_line_activities_by_hour" class="area-chart"></div>
<script type="text/javascript">
var ActivityChart = {
	init: function() {
	  Highcharts.theme = { colors: [] };// prevent errors in default theme
	  var lData = <?php echo json_encode($pData->getPrefilledLikesByHour()); ?>;
		var lOptions = {
		    chart: {
		      renderTo: 'chart_line_activities_by_hour',
		      zoomType: '',
		      spacingRight: 20,
		      backgroundColor: "#f6f6f6"
		   },
		    title: {
		      text: ''
		   },

		    exporting: {
	        enabled: false
	    	},

		    subtitle: false,
		   xAxis: {
		      type: 'datetime',
		      showLastLabel: false,
		      title: {
		         text: null
		      }
		   },
		   yAxis: {
		      title: {
		         text: false
		      },
	      	allowDecimals:false
		   },
		   tooltip: {
         formatter: function() {
                   return ''+
               Highcharts.dateFormat('%b %e, %Y %H:00', this.x) +' / Likes: '+ this.y;
         }
      },
		   legend: {
		      enabled: false
		   },
		   plotOptions: {
		      area: {
		         lineWidth: 1,
		         marker: {
		            enabled: true,
		            states: {
		               hover: {
		                  enabled: true,
		                  radius: 5
		               }
		            }
		         },
		         shadow: false,
		         states: {
		            hover: {
		               lineWidth: 1
		            }
		         }
		      }
		   },

		   series: [{
		      type: 'area',
		      name: 'Likes',
		      pointInterval: 3600000,
		      pointStart: 1300579200000,
		      data: lData,
		      color: '#1231e3',
	        fillOpacity: 0.1,
	        fillColor: {
            linearGradient: [0, 0, 0, 300],
            stops: [
               [0, Highcharts.theme.colors[0]],
               [1, 'rgba(61,160,242,0)']
            ]
         }
		   }]
		};
		var lChart = new Highcharts.Chart(lOptions);
	}//end init
};//end object
ActivityChart.init();
</script>