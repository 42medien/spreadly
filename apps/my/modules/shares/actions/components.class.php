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

  function executeOrder_by(sfWebRequest $request) {
    $this->order_by_date = "ASC";
    $this->order_by_clickback = "";

    if ($od = $request->getParameter("od", null)) {
      $this->order_by_clickback = "";
      $this->order_by_date = $od;
    } elseif ($oc = $request->getParameter("oc", null)) {
      $this->order_by_clickback = $oc;
      $this->order_by_date = "";
    }
    $params = $request->getParameterHolder();

    $params = (array)$params->getAll();
    unset($params['module']);
    unset($params['action']);
    unset($params['od']);
    unset($params['oc']);

    $oc_params = $params;

    if ($this->order_by_clickback == "" || $this->order_by_clickback == "ASC") {
      $oc_params['oc'] = "DESC";
    } else {
      $oc_params['oc'] = "ASC";
    }

    $od_params = $params;

    if ($this->order_by_date == "" || $this->order_by_date == "ASC") {
      $od_params['od'] = "DESC";
    } else {
      $od_params['od'] = "ASC";
    }

    $this->oc_query = http_build_query($oc_params);
    $this->od_query = http_build_query($od_params);
  }
}