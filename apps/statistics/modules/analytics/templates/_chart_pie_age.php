<?php use_helper('ChartData') ?>
<div id="chart_pie_age_activities" class="pie-chart-medium"></div>

<?php //var_dump($pChartsettings);die();?>
<script type="text/javascript">

var ChartPieGenderActivities = {

  init: function(pChartsettings) {
    var lData = <?php echo json_encode($pData); ?>;
		var lOptions = {
		    chart: {
		      renderTo: 'chart_pie_age_activities',
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
		      text: "<?php echo __('Age'); ?>"
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
		               name: '<?php echo getArrayValuePercentage($pData['age'], 'u_18') . '% ' . __("under 18 years"); ?>',
		               color: '#3300cc',
		               y: (lData.age.u_18 == undefined)?0:lData.age.u_18
		             },{
		               name: '<?php echo getArrayValuePercentage($pData['age'], 'b_18_24') . '% ' . __("18 to 24 years"); ?>',
		               color: '#ff0000',
		               y: (lData.age.b_18_24 == undefined)?0:lData.age.b_18_24
		             },{
		               name: '<?php echo getArrayValuePercentage($pData['age'], 'b_25_34') . '% ' . __("25 to 34 years"); ?>',
		               color: '#ffcc00',
		               y: (lData.age.b_25_34 == undefined)?0:lData.age.b_25_34
		             },{
		               name: '<?php echo getArrayValuePercentage($pData['age'], 'b_35_54') . '% ' . __("35 to 54 years"); ?>',
		               color: '#ffcc66',
		               y: (lData.age.b_35_54 == undefined)?0:lData.age.b_35_54
		             },{
		               name: '<?php echo getArrayValuePercentage($pData['age'], 'o_55') . '% ' . __("over 55 years"); ?>',
		               color: '#66ff66',
		               y: (lData.age.o_55 == undefined)?0:lData.age.o_55
		             }
		         ]
          }]
		};
    new Highcharts.Chart(lOptions);
  }//end init
};//end object
ChartPieGenderActivities.init(<?php echo $pChartsettings; ?>);
</script>