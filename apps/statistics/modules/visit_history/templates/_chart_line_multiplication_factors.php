<div id="chart_line_multiplication_factors"></div>
<script type="text/javascript">
var lOptions = {
    chart: {
		  renderTo: 'chart_line_multiplication_factors',
		  defaultSeriesType: 'line'
		},
		xAxis: {
		  categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
		},

		plotOptions: {
		  series: {
		      lineColor: '#303030'
		  }
		},

		series: [{
		  data: [29.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]
		},
		{
      data: [54.4, 71.5, 106.4, 176.0, 144.0, 176.0, 135.6, 148.5, 106.4, 194.1, 95.6, 29.9, 71.5]
    }
		]
  };
  new Highcharts.Chart(lOptions);
</script>
