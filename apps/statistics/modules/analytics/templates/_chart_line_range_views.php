<div id="chart_line_range_view" class="area-chart"></div>
<script type="text/javascript">
var ViewRangeChart = {
	init: function() {
		//var Highcharts = new Highcharts;
	  Highcharts.theme = { colors: [] };// prevent errors in default theme
	  var lData = <?php echo getChartLineRangeViewsData($pData, $pCommunity); ?>;
		var lOptions = {
		    chart: {
		      renderTo: 'chart_line_range_view',
		      zoomType: 'xy',
		      spacingRight: 20,
	        margin: [50, 50, 50, 50],
	        height: 350,
          backgroundColor: '#fff',
          plotBackgroundColor: '#fff'
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
		      maxZoom: 14 * 24 * 3600000, // fourteen days
		      title: {
		         text: null
		      }
		   },
		   yAxis: {
		      title: {
		         text: false
		      },
		      min: 0,
		      maxZoom: 10,
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
		      name: 'Views',
		      pointInterval: 7 * 3600 * 1000,
		      pointStart: Date.UTC(2006, 5, 01),
		      data: [20,500,12,4545,47,8775,565,555,632,23,255,8487,5555,41,500,12,4545,47,8775,565,555,632,23,255,8487,5555,41]
		   }]
		};

		var highchartsOptions = Highcharts.getOptions();
		new Highcharts.Chart(lOptions);
	}//end init
};//end object
ViewRangeChart.init();
</script>