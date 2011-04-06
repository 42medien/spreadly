<script type="text/javascript">
var chart = new Highcharts.Chart({
    chart: {
        renderTo: 'line-chart-example',
        type: 'line'
    },
    xAxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
    },
    yAxis: {
    },
    legend: {
        layout: 'vertical',
        floating: true,
        backgroundColor: '#FFFFFF',
        align: 'right',
        verticalAlign: 'top',
        y: 60,
        x: -60
    },
    tooltip: {
        formatter: function() {
            return '<b>'+ this.series.name +'</b><br/>'+
                this.x +': '+ this.y;
        }
    },
    plotOptions: {
    },
    series: [{
        data: [29.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4],
    		//pointStart: 0
    },{
      	type: 'area',
				data: [129.2, 144.0, 176.0, 135.6],
				pointStart: 3,
	      color: '#000',
        fillColor: {
          linearGradient: [0, 0, 0, 300],
          stops: [
              [0, 'rgb(69, 114, 167)'],
              [1, 'rgba(2,0,0,0)']
          ]
      }
    }]
});
Highcharts.theme = { colors: [] };// prevent errors in default theme
</script>