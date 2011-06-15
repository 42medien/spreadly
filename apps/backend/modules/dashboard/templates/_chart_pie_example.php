<?php //use_helper('ChartData') ?>
<?php //var_dump($pChartsettings);die();?>
<script type="text/javascript">

var ChartPieGenderActivities = {

  init: function(pChartsettings) {
		var lOptions = {
		    chart: {
		      renderTo: pChartsettings.renderto,
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
		      text: false
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
          },
          pie:{
						dataLabels:{
							distance: 4,
							color: "#ffffff",
							rotation: 0
						}
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
		               name: '<?php echo __("FB"); ?>',
		               color: '#3300cc',
		               y: 15
		             },{
		               name: '<?php echo __("Tw"); ?>',
		               color: '#ff0000',
		               y: 17
		             },{
		               name: '<?php echo __("Ln"); ?>',
		               color: '#ffcc00',
		               y: 22
		             },{
		               name: '<?php echo __("Go"); ?>',
		               color: '#ffcc66',
		               y: 13
		             }
		         ]
          }]
		};
    new Highcharts.Chart(lOptions);
  }//end init
};//end object
ChartPieGenderActivities.init(<?php echo $pChartsettings; ?>);
</script>