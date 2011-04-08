<?php use_helper('ChartData') ?>
<div id="chart_pie_gender_activities" class="pie-chart-medium"></div>

<?php //var_dump($pChartsettings);die();?>
<script type="text/javascript">

var ChartPieGenderActivities = {

  init: function(pChartsettings) {
    var lData = <?php echo json_encode($pData); ?>;
		var lOptions = {
		    chart: {
		      renderTo: 'chart_pie_gender_activities',
		      defaultSeriesType: 'pie',
	        margin: pChartsettings.margin,
	        height: parseInt(pChartsettings.height),
		      width: parseInt(pChartsettings.width),
          backgroundColor: pChartsettings.bgcolor,
          zoomType: 'xy'
		    },
		    credits: {
		      enabled: false
        },
		    title: {
		      text: "<?php echo __('Gender'); ?>"
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
              enabled: false,
              x: -15
            }

          }
        },
		    plotOptions: {
           series: {
             allowPointSelect: true,
             size: pChartsettings.plotsize
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
		               y: (lData.sex.f == undefined)?0:lData.sex.f
		             },{
		               name: '<?php echo __("Unknown"); ?>',
		               color: '#ff0000',
		               y: (lData.sex.u == undefined)?0:lData.sex.u
		             },{
		               name: '<?php echo __("Male"); ?>',
		               color: '#ffcc00',
		               y: (lData.sex.m == undefined)?0:lData.sex.m
		             }
		         ]
          }]
		};
    new Highcharts.Chart(lOptions);
  }//end init
};//end object
ChartPieGenderActivities.init(<?php echo $pChartsettings; ?>);
</script>