<?php

spl_autoload_register(function ($class) {
            include '' . str_replace('\\', '/', $class) . '.php';
        });

use GeoIp2\Database\Reader;

// This creates the Reader object, which should be reused across
// lookups.
try {
    $filename = __DIR__ . '/MMDB/GeoLite2-City.mmdb.gz';
     if(!file_exists($filename))
     {
         $reader = new Reader('gs://mmdb/GeoLite2-City.mmdb');
         //file_put_contents($filename, file_get_contents('gs://mmdb/GeoLite2-City.mmdb'));
     }
     else 
     {
         $reader = new Reader($filename);// Replace "city" with the appropriate method for your database, e.g.,
     }

// "country".
    if(isset($_GET["ip"]))$ip = $_GET["ip"];
    if (strlen($ip) == 0) $ip = $_SERVER["REMOTE_ADDR"];
    $ip = filter_var($ip, FILTER_VALIDATE_IP);
    if ($ip) {
        $record = $reader->city($ip);

//print($record->country->isoCode . "\n"); // 'US'
//print($record->country->name . "\n"); // 'United States'
//print($record->country->names['zh-CN'] . "\n"); // '美国'
//print($record->mostSpecificSubdivision->name . "\n"); // 'Minnesota'
//print($record->mostSpecificSubdivision->isoCode . "\n"); // 'MN'

        print($record->city->name . "\n"); // 'Minneapolis'
//print($record->postal->code . "\n"); // '55455'
//print($record->location->latitude . "\n"); // 44.9733
//print($record->location->longitude . "\n"); // -93.2323
    } else {
        throw new Exception;
    }
} catch (Exception $e) {
    print('In deiner Nähe '.$_SERVER["REMOTE_ADDR"]);
    print $e->getMessage();
}

