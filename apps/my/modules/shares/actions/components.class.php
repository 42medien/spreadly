<?php
class sharesComponents extends sfComponents {

  function executePager(sfWebRequest $request) {
    $params = $request->getParameterHolder();

    $params = (array)$params->getAll();

    unset($params['module']);
    unset($params['action']);
    unset($params['p']);

    $this->query = http_build_query($params);
  }

  function executeBreadcrumbs(sfWebRequest $request) {

  }
}