<?php use_helper('ChartData') ?>
<div id="chart_pie_relationship" class="pie-chart-medium"></div>

<?php //var_dump(getGenderChartData($pData));die();?>
<script type="text/javascript">

var ChartPieRelationship = {

  init: function(pChartsettings) {
    var lData = <?php echo getRelationshipChartData($pData); ?>;
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
		               name: '<?php echo __('Single');?>',
		               color: '#3300cc',
		               y: lData.relationship.singl
		             },{
		               name: '<?php echo __('Unknown');?>',
		               color: '#ff0000',
		               y: lData.relationship.u
		             },{
		               name: '<?php echo __('Relationship');?>',
		               color: '#6666ff',
		               y: lData.relationship.rel
		             },{
		               name: '<?php echo __('Open relationship');?>',
		               color: '#00cc33',
		               y: lData.relationship.ior
		             },{
		               name: '<?php echo __('Engaged');?>',
		               color: '#ffcc00',
		               y: lData.relationship.eng
		             },{
		               name: '<?php echo __('Married');?>',
		               color: '#ffcc66',
		               y: lData.relationship.mar
		             },{
		               name: '<?php echo __('Complicated');?>',
		               color: '#66ff66',
		               y: lData.relationship.compl
		             },{
		               name: '<?php echo __('Widowed');?>',
		               color: '#ff6666',
		               y: lData.relationship.wid
		             }
		         ]
          }]
		};
    new Highcharts.Chart(lOptions);
  }//end init
};//end object
ChartPieRelationship.init(<?php echo $pChartsettings; ?>);
</script>