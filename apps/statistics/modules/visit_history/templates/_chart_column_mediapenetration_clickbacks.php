<?php use_helper('ChartData') ?>
<div id="chart_column_mediapenetration_clickbacks"></div>
<script type="text/javascript">
var ChartColumnMediapenetration = {

  init: function() {
    var lData = <?php echo getMediaPenetrationChartData($pData); ?>;
		var lOptions = {
		    chart: {
				  renderTo: 'chart_column_mediapenetration_clickbacks',
				  margin: [60, 120, 60, 120],
          defaultSeriesType: 'column',
          backgroundColor: '#FAFAFA',
          plotBackgroundColor: '#FAFAFA',
          zoomType: 'xy'
				},
				title: {
				  text: '',
				  style: {
				      margin: '10px 0 0 0' // center it
				  }
				},
				subtitle: {
				  text: '',
				  style: {
				      margin: '0 0 0 0' // center it
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
				  series: {
				      stacking: 'normal'
				  }
				},
				xAxis: [{
				  categories: lData.metadata.categories
				}],
				yAxis: [{ // Primary yAxis
				  labels: {
				      formatter: function() {
				          return this.value + ' CB';
				      },
				      style: {
				          color: '#F24398'
				      }
				  },
				  title: {
				      text: '<?php echo __('ClickBacks');?>',
				      style: {
				          color: '#F24398'
				      },
				      margin: 20
				  }},
				{ // Secondary yAxis
				  title: {
				      text: '<?php echo __('Media Penetration'); ?>',
				      margin: 10,
				      style: {
				          color: '#4572A7'
				      }
				  },
				  labels: {
				      formatter: function() {
				          return this.value + ' <?php echo __('Contacts'); ?>';
				      },
				      style: {
				          color: '#4572A7'
				      }
				  },
				  opposite: true}],
				tooltip: {
				  formatter: function() {
				      return '' + this.x + ': ' + this.y + (this.series.name == 'ClickBacks' ? ' '+'<?php echo __('ClickBacks'); ?>' : ' '+'<?php echo __('Contacts'); ?>');
				  }
				},
				legend: {
				  //layout: 'vertical',
				  style: {
	          left: 'auto',
	          bottom: '5px',
	          right: 'auto',
	          top: 'auto'
				  },
				  backgroundColor: '#FFFFFF'
				},
				series: [{
				  name: '<?php echo __('Facebook Friends'); ?>',
				  color: '#3300cc',
				  yAxis: 1,
				  data: lData.facebook_contacts,
				  stack: 0

				  },
				{
				  name: '<?php echo __('Twitter Followers'); ?>',
				  color: '#00cc33',
				  yAxis: 1,
				  data: lData.twitter_contacts,
				  stack: 0

				  },
				{
				  name: '<?php echo __('LinkedIn Contacts'); ?>',
				  color: '#ff0000',
				  yAxis: 1,
				  data: lData.linkedin_contacts,
				  stack: 0

				  },
				{
				  name: '<?php echo __('Buzz Contacts'); ?>',
				  color: '#ffcc00',
				  yAxis: 1,
				  data: lData.google_contacts,
				  stack: 0

				  },
				{
				  name: '<?php echo __('ClickBacks'); ?>',
				  color: '#F24398',
				  type: 'spline',
				  data: lData.pis.cb}]
				};
		  new Highcharts.Chart(lOptions);
  }//end init
};//end object
ChartColumnMediapenetration.init();
</script>