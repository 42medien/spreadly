<script type="text/javascript">
var chart = new Highcharts.Chart({
    chart: {
        renderTo: 'line-chart-content',
        backgroundColor: "#1e2021",
        height: 130,
        width: 260
    },
    xAxis: {
      categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
  	},
    yAxis: {
    },
    legend: {
			enable: false
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
    }]
});
Highcharts.theme = { colors: [] };// prevent errors in default theme
</script>