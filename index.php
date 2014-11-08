<?php

//use GeoIp2\Database\Reader;

echo
'<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="de">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>Die IP ist in ...</title>
  </head>
  <body>
  Hallo Welt!  ';


// This creates the Reader object, which should be reused across
// lookups.
/*$reader = new Reader(__DIR__.'/GeoLite2-City.mmdb');

// Replace "city" with the appropriate method for your database, e.g.,
// "country".
$record = $reader->city($_GET["ip"]);

print($record->country->isoCode . "\n"); // 'US'
print($record->country->name . "\n"); // 'United States'
print($record->country->names['zh-CN'] . "\n"); // '美国'

print($record->mostSpecificSubdivision->name . "\n"); // 'Minnesota'
print($record->mostSpecificSubdivision->isoCode . "\n"); // 'MN'

print($record->city->name . "\n"); // 'Minneapolis'

print($record->postal->code . "\n"); // '55455'

print($record->location->latitude . "\n"); // 44.9733
print($record->location->longitude . "\n"); // -93.2323
*/
echo 
'</body>
</html>';