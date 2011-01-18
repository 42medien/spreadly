<div id="chart_line_urls" class="area-chart"></div>
<script type="text/javascript">
var ActivityChart = {
	init: function() {
	  Highcharts.theme = { colors: [] };// prevent errors in default theme
		var lOptions = {
		    chart: {
		      renderTo: 'chart_line_urls',
		      zoomType: 'xy',
		      spacingRight: 20
		   },
		    title: {
		      text: false
		   },
		    subtitle: {
		      text: document.ontouchstart === undefined ?
		         'Click and drag in the plot area to zoom in' :
		         'Drag your finger over the plot to zoom in'
		   },
		   xAxis: {
		      type: 'datetime',
		      maxZoom: 7 * 24 * 3600000, // fourteen days
		      title: {
		         text: null
		      }
		   },
		   yAxis: {
		      title: {
		         text: false
		      },
		      min: 0,
		      maxZoom: 10, // fourteen days
		      startOnTick: false,
		      showFirstLabel: false
		   },
		   tooltip: {
		      shared: true
		   },
		   legend: {
		      enabled: false
		   },
		   plotOptions: {
		      area: {
		         fillColor: {
		            linearGradient: [0, 0, 0, 300],
		            stops: [
		               [0, Highcharts.theme.colors[0]],
		               [1, 'rgba(2,0,0,0)']
		            ]
		         },
		         lineWidth: 1,
		         marker: {
		            enabled: false,
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
		      name: 'URLs with Likes',
		      pointInterval: 7 * 3600 * 1000,
		      pointStart: Date.UTC(2006, 5, 01),
		      data: [20,500,12,4545,477,775,1565,505,32,230,25,487,1111,141,700,128,455,47,8775,565,555,632,23,255,8487,5555,41]
		   },{
		      type: 'area',
		      name: 'URLs with Dislikes',
		      pointInterval: 7 * 3600 * 1000,
		      pointStart: Date.UTC(2006, 5, 01),
		      data: [2,0,51,4,44,0,505,55,62,37,25,87,55,0,50,1,445,4,75,55,155,602,333,25,887,55,10]
		   }
		   ]
		};

		var highchartsOptions = Highcharts.getOptions();
		new Highcharts.Chart(lOptions);
	}//end init
};//end object
ActivityChart.init();
</script>