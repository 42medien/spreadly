<!-- Bei Klick auf Whats Hot wird dem div mit ID main_nav_outer die Klasse .whats_hot_active zugewiesen -->
<div id="main_nav_outer" class="whats_hot_active">
  <div id="main_nav_inner1" class="left"></div>
  <div id="main_nav_inner2" class="left main_filter" data-obj='{"action":"stream/hot", "callback":"Stream.show", "css":"{\"class\":\"whats_hot_active\", \"id\":\"main_nav_outer\"}"}'>
    <p>What's Hot</p>
  </div>
  <div id="main_nav_inner3" class="left"></div>
  <div id="main_nav_inner4" class="left main_filter" data-obj='{"action":"stream/not", "callback":"Stream.show", "css":"{\"class\":\"whats_not_active\", \"id\":\"main_nav_outer\"}"}'>
    <p>What's Not</p>
  </div>
  <div id="main_nav_inner5" class="left"></div>
  <div class="right" id="new-nav">
    <div id="main_nav_inner6" class="left"></div>
    <div id="main_nav_inner7" class="left main_filter" data-obj='{"action":"stream/new", "callback":"Stream.show", "css":"{\"class\":\"whats_new_active\", \"id\":\"main_nav_outer\"}"}'>
      <p>New</p>
    </div>
    <div id="main_nav_inner8" class="left"></div>
  </div>
</div>