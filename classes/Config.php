<?php

require_once 'common-functions.php';

/**
 * Reads configuration from environment variables or a configuration.cnf file.
 */
class Config {
  protected $configFileData;

  /**
   * Name of the catalogue to use.  Data will be read from [dataDir]/[catalogue] by default.
   * A corresponding class `classes/catalogue/[Catalogue].php` must exist, see README.md for more info.
   */
  public $catalogue;

  /**
   * Base data directory. Expects to find the [catalogue] under this directory by default.
   */
  public $dataDir;

  /**
   * Historical data directory. Defaults to [dataDir]/_historical/[catalogue]
   */
  public $historicalDataDir;

  /**
   * Whether to display the network tab.
   */
  public $dislayNetwork;

  /**
   * URL to the SOLR host, defaults to http://localhost:8983
   */
  public $solrHost;

  /**
   * Solr core to use, defaults to [catalogue]
   */
  public $solrCore;

  public function __construct()
  {
    $this->configFileData = $this->parseConfigFile();
    $this->catalogue = $this->getConfigValue('CATALOGUE', 'catalogue', getPath());
    $this->displayNetwork = ((int) $this->getConfigValue('DISPlAY_NETWORK', 'display-network', 0) == 1);
    $this->solrHost = $this->getConfigValue('SOLR_HOST', 'solrHost', 'http://localhost:8983');
    $this->solrCore = $this->getConfigValue('SOLR_INDEX', ['indexName', $this->catalogue], $this->catalogue);

    $catalogueDirName = rtrim($this->getConfigValue(NULL, ['dirName', $this->catalogue], $this->catalogue), '/');

    $this->dataDir = rtrim($this->getConfigValue(
      'DATA_DIR',
      'dir',
      '/var/www/html'
    ), '/');

    $this->catalogueDir = "{$this->dataDir}/{$catalogueDirName}";
    $this->historicalDataDir = "{$this->dataDir}/_historical/{$catalogueDirName}";
  }

  protected function parseConfigFile()
  {
    if (file_exists('configuration.cnf')) {
      return parse_ini_file("configuration.cnf");
    }
    return [];
  }

  protected function getConfigValue($envKey, $iniKey, $default) {
    if (!is_null($envKey) && getenv($envKey) !== false) {
      return getenv($envKey);
    }
    if (is_array($iniKey) && isset($this->configFileData[$iniKey[0]]) && isset($this->configFileData[$iniKey[1]])) {
      return $this->configFileData[$iniKey[0]][$iniKey[1]];
    }
    if (is_string($iniKey) && isset($this->configFileData[$iniKey])) {
      return $this->configFileData[$iniKey];
    }
    return $default;
  }
}
