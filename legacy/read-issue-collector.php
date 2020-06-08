<?php
require_once 'common-functions.php';

set_time_limit(300);
ini_set('memory_limit', '1G'); // or you could use 1024M


$db = getOrDefault('db', 'metadata-qa');
$errorId = getOrDefault('errorId', '');
$type = getOrDefault('type', '');
$path = getOrDefault('path', '');
$message = getOrDefault('message', '');

// error_log()

$configuration = parse_ini_file("configuration.cnf");

$elementsFile = sprintf('%s/%s/issue-collector.csv', $configuration['dir'], $db);
$recordIds = [];
$types = [];
$max = 0;
if (file_exists($elementsFile)) {
  // $keys = ['errorId', 'recordIds']
  $lineNumber = 0;
  $header = [];
  $in = fopen($elementsFile, "r");
  while (($line = fgets($in)) != false) {
    if (count($recordIds) < 10) {
      $lineNumber++;
      if ($lineNumber == 1) {
        $header = str_getcsv($line);
      } else {
        if (preg_match('/^' . $errorId . ',/', $line)) {
          $values = str_getcsv($line);
          $record = (object)array_combine($header, $values);
          $recordIds = explode(';', $record->recordIds);
          $recordIds = array_slice($recordIds, 0, 10);
          break;
        }
      }
    }
  }
  fclose($in);
} else {
  $msg = sprintf("file %s is not existing", $elementsFile);
  error_log($msg);
}

header("Content-type: application/json");
echo json_encode([
  'recordIds' => $recordIds
]);

