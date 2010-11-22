<?php use_helper('ChartData'); ?>
<div id="chart_column_activities_clickbacks"></div>

<script type="text/javascript">
var ChartColumnActivitiesClickbacks = {
  init: function(){
	  var lData = <?php echo getActivityChartData($pData); ?>;
		var lOptions = {
		    chart: {
				  renderTo: 'chart_column_activities_clickbacks',
				  margin: [60, 120, 80, 120],
				  defaultSeriesType: 'column',
				  backgroundColor: '#FAFAFA',
				  plotBackgroundColor: '#FAFAFA',
				  zoomType: 'xy',
					height: 500
				},
				title: {
				  text: '<?php //echo __('Networks Activities and Clickbacks');?>',
				  style: {
				     margin: '10px 0 0 0' // center it
				  }
				},
				subtitle: {
				  //text: '<?php echo __('Period');?>: ' + lData.metadata.range,
				  style: {
				     margin: '0 0 0 0' // center it
				  }
				},
				plotOptions: {
				 series: {
				     stacking: 'normal'
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
				xAxis: [{
				  categories: lData.metadata.categories
				}],
				yAxis: [{ // Primary yAxis
				  labels: {
				     formatter: function() {
				        return this.value +' CB';
				     },
				     style: {
				        color: '#F24398'
				     }
				  },
				  title: {
				     text: 'ClickBacks',
				     style: {
				        color: '#F24398'
				     },
				     margin: 20
				  }
				}, { // Secondary yAxis
				  title: {
				     text: '<?php echo __('Likes & Dislikes'); ?>',
				     margin: 20,
				     style: {
				        color: '#4572A7'
				     }
				  },
				  labels: {
				     formatter: function() {
				        return this.value +' L&D';
				     },
				     style: {
				        color: '#4572A7'
				     }
				  },
				  opposite: true
				}],
				tooltip: {
				  formatter: function() {
				     return ''+
				        this.x +': '+ this.y +
				        (this.series.name == 'ClickBacks' ? ' '+'<?php echo __('ClickBacks'); ?>' : ' '+'<?php echo __('Activities'); ?>');
				  }
				},
				legend: {
				  //layout: 'vertical',
				  style: {
				     left: 'auto',
				     bottom: 'auto',
				     right: 'auto',
				     top: 'auto'
				  },
				  backgroundColor: '#FFFFFF'
				},
				series: [{
				  name: '<?php echo __('Facebook Likes'); ?>',
				  color: '#3300cc',
				  yAxis: 1,
				  data: lData.facebook_likes,
				  stack: 0

				}, {
				  name: '<?php echo __('Twitter Likes'); ?>',
				  color: '#00cc33',
				  yAxis: 1,
				  data: lData.twitter_likes,
				   stack: 0

				}, {
          name: '<?php echo __('LinkedIn Likes'); ?>',
          color: '#ff0000',
          yAxis: 1,
          data: lData.linkedin_likes,
           stack: 0

        }, {
          name: '<?php echo __('Buzz Likes'); ?>',
          color: '#ffcc00',
          yAxis: 1,
          data: lData.google_likes,
           stack: 0

        }, {
				  name: '<?php echo __('Facebook Dislikes'); ?>',
				  color: '#6666ff',
				  yAxis: 1,
				  data: lData.facebook_dislikes,
				   stack: 1

				}, {
				  name: '<?php echo __('Twitter Dislikes'); ?>',
				  color: '#66ff66',
				  yAxis: 1,
				  data: lData.twitter_dislikes,
				   stack: 1

				}, {
          name: '<?php echo __('LinkedIn Dislikes'); ?>',
          color: '#ff6666',
          yAxis: 1,
          data: lData.linkedin_dislikes,
           stack: 1

        }, {
          name: '<?php echo __('Buzz Dislikes'); ?>',
          color: '#ffcc66',
          yAxis: 1,
          data: lData.google_dislikes,
           stack: 1

        }, {
				  name: '<?php echo __('ClickBacks'); ?>',
				  color: '#F24398',
				  type: 'spline',
				  data: lData.pis.cb
				}]
				};
		  new Highcharts.Chart(lOptions);
  }//end method: init
};//end object

ChartColumnActivitiesClickbacks.init();
</script>