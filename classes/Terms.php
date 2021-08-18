<?php

include_once 'Facet.php';
include_once 'Facetable.php';

class Terms extends Facetable {

  private $facet;

  public function __construct($config) {
    parent::__construct($config);
    $this->facet = getOrDefault('facet', '');
    $this->query = getOrDefault('query', '*:*');
    $this->scheme = getOrDefault('scheme', '');
    $this->offset = getOrDefault('offset', 0);
    $this->ajaxFacet = getOrDefault('ajax', 0, [0, 1]);
    $this->facetLimit = getOrDefault('limit', 100, [10, 25, 50, 100]);
  }

  public function prepareData(Smarty &$smarty) {
    parent::prepareData($smarty);

    $smarty->assign('facet',     $this->facet);
    $smarty->assign('query',     $this->query);
    $smarty->assign('scheme',    $this->scheme);

    $smarty->assign('facetLimit',$this->facetLimit);
    $smarty->assign('offset',    $this->offset);
    $smarty->assign('ajaxFacet', $this->ajaxFacet);

    $smarty->assign('controller',$this);
    $facets = $this->createTermList();
    $smarty->assign('facets',    $facets);
    $smarty->assign('label',     $this->resolveSolrField($this->facet));
    $smarty->assign('basicFacetParams', ['tab=data', 'query=' . $this->query]);
    $smarty->assign('prevLink',  $this->createPrevLink());
    if (isset($facets->{$this->facet}))
      $smarty->assign('nextLink',  $this->createNextLink(get_object_vars($facets->{$this->facet})));
    else
      $smarty->assign('nextLink',  '');

    // if ($this->facet == '' && $this->query == '')
    $smarty->assign('solrFields', $this->getFields());
  }

  public function getTemplate() {
    return 'terms.tpl';
  }

  public function getAjaxTemplate() {
    return 'marc-facets.tpl';
  }

  private function createTermList() {
    return $this->getFacets($this->facet, $this->query, $this->facetLimit, $this->offset);
  }

  private function createPrevLink() {
    if ($this->offset - $this->facetLimit > 0)
      return $this->createNavLink($this->offset-$this->facetLimit);
    return '';
  }

  private function createNextLink($count) {
    if ($count >= $this->facetLimit)
      return $this->createNavLink($this->offset + $this->facetLimit);
    return '';
  }

  private function createNavLink($offset) {
    $params = [
      'tab=terms',
      'facet=' . $this->facet,
      'query=' . urlencode($this->query),
      'scheme=' . $this->scheme,
      // 'facetLimit=' . $this->facetLimit,
      'offset=' . $offset
    ];
    if ($this->ajaxFacet == 1)
      $params[] = 'ajax=1';
    return '?' . join('&', $params);
  }

  public function createFacet($facetName, $values) {
    return new Facet($facetName, $values, $this);
  }

  public function getBasicFacetParams() {
    return [
      'tab=data',
      'query=' . urlencode($this->query)
    ];
  }

  private function getFields() {
    $fieldNames = $this->getSolrFields();
    sort($fieldNames);
    return $fieldNames;
  }
}