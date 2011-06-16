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
     },
     min: 0,
     allowDecimals:false

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
        data: <?php echo json_encode($data["current_likes_range"]); ?>,
    		//pointStart: 0
    }]
});
Highcharts.theme = { colors: [] };// prevent errors in default theme
</script>