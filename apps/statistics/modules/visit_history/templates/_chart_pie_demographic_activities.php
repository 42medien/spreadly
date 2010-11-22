<div id="chart_pie_demographic_activities" class="pie-chart-medium"></div>
<script type="text/javascript">

var ChartPieDemographicActivities = {

  init: function() {
  var lData = <?php echo getRelationshipChartData($pData); ?>;
  var lOptions = {
      chart: {
        renderTo: 'chart_pie_demographic_activities',
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
        text: '<?php echo __('Relationship status distribution');?>'
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
          size: "55%"
       }
    },
    legend: {
        //layout: 'vertical',
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
        type: 'pie',
        name: '<?php echo __('Demograhics');?>',
        data: [
            {
              name: '<?php echo __('Single');?>',
              color: '#3300cc',
              y: lData.rel.singl
            },{
              name: '<?php echo __('Unknown');?>',
              color: '#ff0000',
              y: lData.rel.u
            },{
              name: '<?php echo __('Relationship');?>',
              color: '#6666ff',
              y: lData.rel.rel
            },{
              name: '<?php echo __('Open relationship');?>',
              color: '#00cc33',
              y: lData.rel.ior
            },{
              name: '<?php echo __('Engaged');?>',
              color: '#ffcc00',
              y: lData.rel.eng
            },{
              name: '<?php echo __('Married');?>',
              color: '#ffcc66',
              y: lData.rel.mar
            },{
              name: '<?php echo __('Complicated');?>',
              color: '#66ff66',
              y: lData.rel.compl
            },{
              name: '<?php echo __('Widowed');?>',
              color: '#ff6666',
              y: lData.rel.wid
            }
        ]
     }]
  };
  new Highcharts.Chart(lOptions);
  }//end init
};//end object
ChartPieDemographicActivities.init();
</script>