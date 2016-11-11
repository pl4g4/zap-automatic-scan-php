<?php

require "vendor/autoload.php";

//Change this values
$api_key = "changemenow";
$target = "http://test.com/";
$zap = new Zap\Zapv2('172.17.0.2:8090');

//DO NOT MODIFY IF YOU DONT UNDERSTAND ZAP API

$version = $zap->core->version();
if (is_null($version)) {
  echo "PHP API error\n";
  exit();
} else {
  echo "version: ${version}\n";
}

echo "Spidering target ${target}\n";

// Response JSON looks like {"scan":"1"}
$scan_id = $zap->spider->scan($target, null, null, null, $api_key);

while (true) {
   // Response JSON looks like {"status":"50"}
  $progress = intval($zap->spider->status($scan_id));
  printf("Spider progress %d\n", $progress);
  if ($progress >= 100) break;
  sleep(5);
}

echo "Spider completed\n";
// Give the passive scanner a chance to finish
sleep(10);

echo "Scanning target ${target}\n";

// Response JSON for error looks like {"code":"url_not_found", "message":"URL is not found"}
$scan_id = $zap->ascan->scan($target, null, null, null, null, null, $api_key);

while (true) {
  $progress = intval($zap->ascan->status($scan_id));
  printf("Scan progress %d\n", $progress);
  if ($progress >= 100) break;
  sleep(5);
}

echo "Scan completed\n";

// Report the results
echo "Hosts: " . implode(",", $zap->core->hosts()) . "\n";
$scanResponse = $zap->core->htmlreport($api_key);
echo $scanResponse;
exit;

