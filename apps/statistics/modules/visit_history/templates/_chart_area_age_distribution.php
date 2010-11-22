<div id="chart_area_age_distribution" class="area-chart"></div>
<script type="text/javascript">

var ChartAreaAgeDistribution = {
  init: function() {
    var lData = <?php echo getAgeChartData($pData); ?>;
		var lOptions = {
		    chart: {
		      renderTo: 'chart_area_age_distribution',
		      defaultSeriesType: 'area',
		      height: 200,
		      backgroundColor: '#FAFAFA',
		      plotBackgroundColor: '#FAFAFA',
		      zoomType: 'xy'

		    },
		    title: {
		        text: "<?php echo __('Age distribution');?>"
		    },
		    subtitle: {
		        //text: 'yiid.com</a>'
		    },
				xAxis: [{
				  categories: ["under 18", "18-24", "25-34", "35-54", "over 55"]
				}],
		    yAxis: {
		        title: {
		            text: 'Number of Users'
		        },
		        labels: {
		            formatter: function() {
		                return this.value / 1000 + 'k';
		            }
		        }
		    },
		    tooltip: {
		        formatter: function() {
		            return this.series.name + ' <?php echo __("produced"); ?>' + '<b>' + Highcharts.numberFormat(this.y, 0, null, ' ') + '</b><br/>'+'<?php echo __("activities in"); ?>' + this.x;
		        }
		    },
        credits: {
          text: "yiid.com",
          href: "http://www.yiid.com"
        },
        exporting: {
          buttons: {
            exportButton: {
              enabled: false
            },
            printButton: {
              enabled: true,
              x: -15
            }

          }
        },
		    plotOptions: {
		        area: {
		            //pointStart: 10,
		            marker: {
		                enabled: false,
		                symbol: 'circle',
		                radius: 2,
		                states: {
		                    hover: {
		                        enabled: true
		                    }
		                }
		            }
		        }
		    },
		    series: [{
		        name: "<?php echo __('Men') .' & '. __('Women'); ?>",
		        data: lData.age}]
		  };
		  new Highcharts.Chart(lOptions);
  }//end init
};//end object
ChartAreaAgeDistribution.init();
</script>