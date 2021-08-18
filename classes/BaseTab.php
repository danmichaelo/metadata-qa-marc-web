<?php

include_once 'catalogue/Catalogue.php';

abstract class BaseTab implements Tab {

  protected $config;
  protected $db;
  protected $count = 0;
  protected static $marcBaseUrl = 'https://www.loc.gov/marc/bibliographic/';
  protected $solrFields;
  protected $fieldDefinitions;
  protected $catalogueName;
  protected $catalogue;
  protected $lastUpdate;
  protected $output = 'html';
  protected $displayNetwork = false;
  protected $historicalDataDir = null;

  /**
   * BaseTab constructor.
   * @param $configuration
   * @param $db
   */
  public function __construct(Config $config) {
    $this->config = $config;
    $this->catalogueName = $config->catalogue;
    $this->db = $config->catalogue; /* @deprecated */
    $this->displayNetwork = $config->displayNetwork;
    $this->solrCore = $config->solrCore;
    $this->solrUrl = $config->solrHost . '/solr/' . $config->solrCore;
    $this->catalogue = $this->createCatalogue();
    $this->count = $this->readCount();
    $this->readLastUpdate();
    $this->handleHistoricalData();
  }

  public function prepareData(Smarty &$smarty) {
    $smarty->assign('db', $this->db);
    $smarty->assign('catalogueName', $this->catalogueName);
    $smarty->assign('catalogue', $this->catalogue);
    $smarty->assign('count', $this->count);
    $smarty->assign('lastUpdate', $this->lastUpdate);
    $smarty->assign('displayNetwork', $this->displayNetwork);
    $smarty->assign('historicalDataDir', $this->historicalDataDir);
  }

  private function createCatalogue() {
    $className = ucfirst(preg_replace('/[^a-zA-Z0-9]/', '', $this->catalogueName));
    require_once 'catalogue/' . $className . '.php';
    return new $className();
  }

  public function getTemplate() {
    // TODO: Implement getTemplate() method.
  }

  protected function getFilePath($name) {
    return "{$this->config->catalogueDir}/{$name}";
  }

  protected function readCount($countFile = null) {
    if (is_null($countFile))
      $countFile = $this->getFilePath('count.csv');
    $counts = readCsv($countFile);
    if (empty($counts)) {
      $count = trim(file_get_contents($countFile));
    } else {
      $counts = $counts[0];
      $count = isset($counts->processed) ? $counts->processed : $counts->total;
    }
    return $count;
  }

  protected function readLastUpdate() {
    $file = $this->getFilePath('last-update.csv');
    $this->lastUpdate = trim(file_get_contents($file));
  }

  protected function getSolrFieldMap() {
    $solrFieldMap = [];
    $fields = $this->getSolrFields();
    foreach ($fields as $field) {
      $parts = explode('_', $field);
      $solrFieldMap[$parts[0]] = $field;
    }

    return $solrFieldMap;
  }

  /**
   * @param array $db
   * @return array
   */
  protected function getSolrFields() {
    if (!isset($this->solrFields)) {
      $all_fields = file_get_contents($this->solrUrl  . '/select/?q=*:*&wt=csv&rows=0');
      $this->solrFields = explode(',', $all_fields);
    }
    return $this->solrFields;
  }

  protected function getSolrResponse($params) {
    //
    $url = $this->solrUrl . '/select?' . join('&', $this->encodeSolrParams($params));
    error_log($url);
    $solrResponse = json_decode(file_get_contents($url));
    $response = (object)[
      'numFound' => $solrResponse->response->numFound,
      'docs' => $solrResponse->response->docs,
      'facets' => (isset($solrResponse->facet_counts) ? $solrResponse->facet_counts->facet_fields : []),
      'params' => $solrResponse->responseHeader->params,
    ];

    return $response;
  }

  protected function getFacets($facet, $query, $limit, $offset = 0) {
    $parameters = [
      'q=' . $query,
      'facet=on',
      'facet.limit=' . $limit,
      'facet.offset=' . $offset,
      'facet.field=' . $facet,
      'facet.mincount=1',
      'core=' . $this->solrCore,
      'rows=0',
      'wt=json',
      'json.nl=map',
    ];
    $response = $this->getSolrResponse($parameters);
    return $response->facets;
  }

  private function encodeSolrParams($parameters) {
    $encodedParams = [];
    foreach ($parameters as $parameter) {
      if ($parameter == '')
        continue;

      list($k, $v) = explode('=', $parameter);
      if ($k == 'core' || $k == '_'  || $k == 'json.wrf' || $v == '') { //
        continue;
      }
      if ($k == 'q') {
        error_log($v);
      }
      if (!preg_match('/%/', $v))
        $v = urlencode($v);

      $encodedParams[] = $k . '=' . $v;
    }
    $encodedParams[] = 'indent=false';
    return $encodedParams;
  }

  protected function readHistogram($histogramFile) {
    $records = [];
    if (file_exists($histogramFile)) {
      $records = readCsv($histogramFile);
      $records = array_filter($records, function($record) {
        return ($record->name != 'id' && $record->name != 'total');
      });
    }
    return $records;
  }

  protected function getSelectedFacets() {
    $selectedFacets = [];
    $file = 'cache/selected-facets-' . $this->catalogueName . '.js';
    $facets = null;
    if (file_exists($file)) {
      $facets = file_get_contents($file);
    } elseif (file_exists('cache/selected-facets.js')) {
      $facets = file_get_contents('cache/selected-facets.js');
    }
    if (!is_null($facets)) {
      $facets = preg_replace(['/var selectedFacets = /', '/;$/', '/\'/'], ['', '', '"'], $facets);
      $selectedFacets = json_decode($facets);
    }
    return $selectedFacets;
  }

  protected function getSolrField($tag, $subfield = '') {
    if (!isset($this->fieldDefinitions))
      $this->fieldDefinitions = json_decode(file_get_contents('fieldmap.json'));

    if ($subfield == '' && strstr($tag, '$') !== false)
      list($tag, $subfield) = explode('$', $tag);

    if (isset($this->fieldDefinitions->fields->{$tag}->subfields->{$subfield}->solr)) {
      $solrField = $this->fieldDefinitions->fields->{$tag}->subfields->{$subfield}->solr . '_ss';
    } elseif (isset($this->fieldDefinitions->fields->{$tag}->solr)) {
      $solrField = $tag . $subfield
                 . '_' . $this->fieldDefinitions->fields->{$tag}->solr
                 . '_' . $subfield . '_ss';
    }

    if (!isset($solrField) || !in_array($solrField, $this->getSolrFields())) {
      $solrField = $tag . $subfield;
      $candidates = [];
      $found = FALSE;
      foreach ($this->getSolrFields() as $existingSolrField) {
        if (preg_match('/^' . $solrField . '_/', $existingSolrField)) {
          $parts = explode('_', $existingSolrField);
          if (count($parts) == 4) {
            $found = TRUE;
            $solrField = $existingSolrField;
            break;
          } else {
            $candidates[] = $existingSolrField;
          }
        }
      }

      if (count($candidates) == 1) {
        $solrField = $candidates[0];
        $found = TRUE;
      }

      if (!$found) {
        error_log('not found: ' . $solrField . ' - ' . join(', ', $candidates));
        $solrField = FALSE;
      }
    }
    return $solrField;
  }

  public function resolveSolrField($solrField) {
    if (!isset($this->fieldDefinitions))
      $this->fieldDefinitions = json_decode(file_get_contents('fieldmap.json'));

    $solrField = preg_replace('/_ss$/', '', $solrField);
    if ($solrField == 'type' || substr($solrField, 0, 2) == '00'
       || substr($solrField, 0, 6) == 'Leader' || substr($solrField, 0, 6) == 'leader') {
      $found = false;
      if (substr($solrField, 0, 2) == '00') {
        $parts = explode('_', $solrField);
        foreach ($this->fieldDefinitions->fields->{$parts[0]}->types as $name => $type)
          foreach ($type->positions as $position => $definition)
            if ($position == $parts[1]) {
              $label = sprintf('%s/%s %s', $parts[0], $parts[1], $definition->label);
              $found = true;
              break;
            }
      }
      if (!$found) {
        $solrField = preg_replace('/^(00.|leader|Leader_)/', "$1/", $solrField);
        $solrField = preg_replace('/_/', ' ', $solrField);
        $label = $solrField;
      }
    } else {
      $label = sprintf('%s$%s', substr($solrField, 0, 3), substr($solrField, 3, 1));
      foreach ($this->fieldDefinitions->fields as $field)
        if (isset($field->subfields))
          foreach ($field->subfields as $code => $subfield)
            if ($subfield->solr == $solrField) {
              $label = sprintf('%s$%s %s', $field->tag, $code, $field->label);
              if ($field->label != $subfield->label)
                $label .= ' / ' . $subfield->label;
              break;
            }
    }
    return $label;
  }

  protected function solrToMarcCode($solrField) {
    $solrField = preg_replace('/_ss$/', '', $solrField);
    if ($solrField == 'type' || substr($solrField, 0, 2) == '00' || substr($solrField, 0, 6) == 'Leader') {
      if (substr($solrField, 0, 2) == '00' || substr($solrField, 0, 6) == 'Leader') {
        $parts = explode('_', $solrField);
        $label = sprintf('%s/%s', $parts[0], $parts[1]);
      } else {
        $label = $solrField;
      }
    } else {
      $label = sprintf('%s$%s', substr($solrField, 0, 3), substr($solrField, 3, 1));
    }
    return $label;
  }

  public function getOutputType() {
    return $this->output;
  }

  private function handleHistoricalData() {
    if (is_dir($this->config->historicalDataDir))
      $this->historicalDataDir = $this->config->historicalDataDir;
  }

  protected function getVersions() {
    return array_diff(scandir($this->historicalDataDir,  SCANDIR_SORT_ASCENDING), ['..', '.']);
  }

  protected function getHistoricalFilePaths($name) {
    $files = [];
    if (!is_null($this->historicalDataDir)) {
      foreach ($this->getVersions() as $version) {
        $files[$version] = sprintf('%s/%s/%s', $this->historicalDataDir, $version, $name);
      }
    }
    return $files;
  }
}
