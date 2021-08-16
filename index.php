<?php
set_time_limit(0);

require_once 'common-functions.php';
$marcBaseUrl = 'https://www.loc.gov/marc/bibliographic/';
$smarty = createSmarty('templates');


require_once 'classes/Config.php';
$config = new Config();

$db = $config->db;

$tab = getOrDefault('tab', 'completeness');
$ajax = getOrDefault('ajax', 0, [0, 1]);
$smarty->assign('tab', $tab);

include_once('classes/Tab.php');
include_once('classes/BaseTab.php');

$map = [
  'data'                     => 'Data',
  'completeness'             => 'Completeness',
  'issues'                   => 'Issues',
  'functions'                => 'Functions',
  'classifications'          => 'Classifications',
  'authorities'              => 'Authorities',
  'serials'                  => 'Serials',
  'tt-completeness'          => 'TtCompleteness',
  'shelf-ready-completeness' => 'ShelfReadyCompleteness',
  'network'                  => 'Network',
  'terms'                    => 'Terms',
  'pareto'                   => 'Pareto',
  'history'                  => 'History',
  'timeline'                 => 'Timeline',
  'settings'                 => 'Settings',
  'about'                    => 'About',
  'record-issues'            => 'RecordIssues',
  'histogram'                => 'Histogram',
  'functional-analysis-histogram' => 'FunctionalAnalysisHistogram',
];

$class = isset($map[$tab]) ? $map[$tab] : 'Completeness';
$tab = createTab($class);
$tab->prepareData($smarty);

if ($ajax == 1)
  $smarty->display($tab->getAjaxTemplate());
elseif ($tab->getOutputType() == 'html')
  $smarty->display($tab->getTemplate());

function createTab($name) {
  global $config;

  if ($name == 'Classifications' || $name == 'Authorities')
    include_once('classes/AddedEntry.php');

  include_once('classes/' . $name . '.php');
  return new $name($config);
}

function showMarcUrl($content) {
  global $marcBaseUrl;

  if (!preg_match('/^http/', $content))
    $content = $marcBaseUrl . $content;

  return $content;
}

$facetLabels = [];
function getFacetLabel($facet) {
  global $facetLabels;
  if (isset($facetLabels[$facet]))
    return $facetLabels[$facet];
  return str_replace('_', ' ', preg_replace('/_ss$/', '', $facet));
}
