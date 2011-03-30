AnalyticsFilter.init();
AnalyticsFilterNav.init();
AnalyticsTables.init();
debug.log('init');
AnalyticsTables.initTablesorter("dash-website-table");
AnalyticsTables.initTablesorter("dash-deal-table");
jQuery('#dash-deal-table').tableScroll({height: 200, flush: true});
jQuery('#dash-website-table').tableScroll({height: 200, flush: true});

