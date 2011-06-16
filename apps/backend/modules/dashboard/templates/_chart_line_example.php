<script type="text/javascript">
var chart = new Highcharts.Chart({
    chart: {
        renderTo: 'line-chart-content',
        backgroundColor: "#1e2021",
        height: 140,
        width: 310
    },

    title: {
      text: false
   },
    exporting: {
      enabled: false
  	},
   	xAxis: {
      //type: 'datetime',
      title: {
         text: false
      },
      //tickInterval: 24 * 3600 * 1000,
      labels: {
        enabled: false
      }
   	},

    yAxis: {
      title: {
        text: false
     }

    },
	  legend: {
	      enabled: false
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