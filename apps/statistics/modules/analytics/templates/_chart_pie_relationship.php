<?php use_helper('ChartData') ?>
<div id="chart_pie_relationship" class="pie-chart-medium"></div>

<?php //var_dump(getGenderChartData($pData));die();?>
<script type="text/javascript">

var ChartPieRelationship = {

  init: function() {
    var lData = <?php echo getGenderChartData($pData); ?>;
		var lOptions = {
		    chart: {
		      renderTo: 'chart_pie_relationship',
		      defaultSeriesType: 'pie',
	        margin: [-10, 0, 10, 0],
	        height: 160,
		      width: 300,
          backgroundColor: '#fff',
          plotBackgroundColor: '#fff',
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
             size: "40%"
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
		               name: '<?php echo __("open"); ?>',
		               color: '#3300cc',
		               y: 0
		             },{
		               name: '<?php echo __("engaged"); ?>',
		               color: '#ff0000',
		               y: 16
		             },{
		               name: '<?php echo __("married"); ?>',
		               color: '#e300e3',
		               y: 27
		             },{
		               name: '<?php echo __("complicated"); ?>',
		               color: '#edad17',
		               y: 11
		             },{
		               name: '<?php echo __("widowed"); ?>',
		               color: '#2ae309',
		               y: 3
		             }
		         ]
          }]
		};
    new Highcharts.Chart(lOptions);
  }//end init
};//end object
ChartPieRelationship.init();
</script>