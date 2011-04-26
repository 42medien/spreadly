<?php use_helper('ChartData') ?>
<div id="chart_pie_relationship" class="pie-chart-medium"></div>

<?php //var_dump(getGenderChartData($pData));die();?>
<script type="text/javascript">

var ChartPieRelationship = {

  init: function(pChartsettings) {
    var lData = <?php echo json_encode($pData); ?>;
		var lOptions = {
		    chart: {
		      renderTo: 'chart_pie_relationship',
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
		      text: "<?php echo __('Relationship'); ?>"
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
		      name: 'Relationship',
		      data: [
		             {
		               name: '<?php echo getArrayValuePercentage($pData['rel'], 'singl') . '% ' . __('Single');?>',
		               color: '#3300cc',
		               y: (lData.rel.singl == undefined)?0:lData.rel.singl
		             },{
		               name: '<?php echo getArrayValuePercentage($pData['rel'], 'u') . '% ' . __('Unknown');?>',
		               color: '#ff0000',
		               y: (lData.rel.u == undefined)?0:lData.rel.u
		             },{
		               name: '<?php echo getArrayValuePercentage($pData['rel'], 'rel') . '% ' . __('Relationship');?>',
		               color: '#6666ff',
		               y: (lData.rel.rel == undefined)?0:lData.rel.rel
		             },{
		               name: '<?php echo getArrayValuePercentage($pData['rel'], 'ior') . '% ' . __('Open relationship');?>',
		               color: '#00cc33',
		               y: (lData.rel.ior == undefined)?0:lData.rel.ior
		             },{
		               name: '<?php echo getArrayValuePercentage($pData['rel'], 'eng') . '% ' . __('Engaged');?>',
		               color: '#ffcc00',
		               y: (lData.rel.eng == undefined)?0:lData.rel.eng
		             },{
		               name: '<?php echo getArrayValuePercentage($pData['rel'], 'mar') . '% ' . __('Married');?>',
		               color: '#ffcc66',
		               y: (lData.rel.mar == undefined)?0:lData.rel.mar
		             },{
		               name: '<?php echo getArrayValuePercentage($pData['rel'], 'compl') . '% ' . __('Complicated');?>',
		               color: '#66ff66',
		               y: (lData.rel.compl == undefined)?0:lData.rel.compl
		             },{
		               name: '<?php echo getArrayValuePercentage($pData['rel'], 'wid') . '% ' . __('Widowed');?>',
		               color: '#ff6666',
		               y: (lData.rel.wid == undefined)?0:lData.rel.wid
		             }
		         ]
          }]
		};
    new Highcharts.Chart(lOptions);
  }//end init
};//end object
ChartPieRelationship.init(<?php echo $pChartsettings; ?>);
</script>