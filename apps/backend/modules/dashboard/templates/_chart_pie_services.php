<?php //use_helper('ChartData') ?>
<?php //var_dump($data["share_distribution"][0]);exit();?>
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
          zoomType: ''
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
              enabled: false
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
							enabled: false
						}
          }
		  },
		  legend: {
        enabled: true,
        style: {
            left: 'auto',
            bottom: '5px',
            right: 'auto',
            top: 'auto'
        },
        //symbolPadding: 2,
        width: 150,
        borderWidth : 0,
        symbolWidth : 10,
        x: 0
		  },
		  series: [{
		      name: 'Gender',
		      data: [
		             {
		               name: '<?php echo $data["share_distribution_labels"][0]; ?>',
		               //color: '#3300cc',
		               y: parseInt('<?php echo $data["share_distribution"][0]; ?>')
		             },{
		               name: '<?php echo $data["share_distribution_labels"][1]; ?>',
		               //color: '#ff0000',
		               y: parseInt('<?php echo $data["share_distribution"][1]; ?>')
		             },{
		               name: '<?php echo $data["share_distribution_labels"][2]; ?>',
		               //color: '#ffcc00',
		               y: parseInt('<?php echo $data["share_distribution"][2]; ?>')
		             },{
		               name: '<?php echo $data["share_distribution_labels"][3]; ?>',
		               //color: '#ffcc66',
		               y: parseInt('<?php echo $data["share_distribution"][3]; ?>')
		             }
		         ]
          }]
		};
    new Highcharts.Chart(lOptions);
  }//end init
};//end object
ChartPieGenderActivities.init(<?php echo $pChartsettings; ?>);
</script>