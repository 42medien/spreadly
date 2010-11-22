<div id="chart_pie_gender_activities" class="pie-chart-medium"></div>
<script type="text/javascript">

var ChartPieGenderActivities = {

  init: function() {
    var lData = <?php echo getGenderChartData($pData); ?>;
		var lOptions = {
		    chart: {
		      renderTo: 'chart_pie_gender_activities',
		      defaultSeriesType: 'pie',
	        margin: [30, 0, 10, 0],
	        height: 230,
		      width: 450,
          backgroundColor: '#FAFAFA',
          plotBackgroundColor: '#FAFAFA',
          zoomType: 'xy'
		    },
		    credits: {
		      enabled: false
        },
		    title: {
		      text: '<?php echo __('Gender distribution');?>'
		    },
		    tooltip: {
		      formatter: function() {
		        return '<b>' + '<?php echo __('this.point.name');?>' + '</b>: ' + this.y + ' %';
		      }
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
           series: {
             allowPointSelect: true,
             size: "65%"
          }
		  },
		  legend: {
        enabled: false,
        style: {
            left: 'auto',
            bottom: '0px',
            right: 'auto',
            top: 'auto'
        },
        symbolPadding: 2
		  },
		  series: [{
		      name: 'Gender',
		      data: [
		             {
		               name: '<?php echo __("Female"); ?>',
		               color: '#3300cc',
		               y: lData.gender.f
		             },{
		               name: '<?php echo __("Unknown"); ?>',
		               color: '#ff0000',
		               y: lData.gender.u
		             },{
		               name: '<?php echo __("Male"); ?>',
		               color: '#ffcc00',
		               y: lData.gender.m
		             }
		         ]
          }]
		};
    new Highcharts.Chart(lOptions);
  }//end init
};//end object
ChartPieGenderActivities.init();
</script>