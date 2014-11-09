<?php

if (strpos($_SERVER["SERVER_NAME"], "www.geoip.local") !== false) define('SERVER', 0); 
else define('SERVER', 1); 

define('CFG_USER', SERVER ? 'root'	: 'root');
define('CFG_PASS', SERVER ? '': '');
define('CFG_DB', SERVER ? 'geoip': 'geoip');
define('CFG_MYSQL',SERVER ? null	: '127.0.0.1');
define('CFG_SOCKET',SERVER ? ':/cloudsql/canvas-epigram-758:geo'	: null);

try {
    
    // DB Connection
    // Using mysqli (connecting from App Engine)
    $mysqli = new mysqli(
    CFG_MYSQL, // host
    CFG_USER, // username
    CFG_PASS      ,     // password
    CFG_DB       , // database name
    null,
    CFG_SOCKET
    );
    
    if ($mysqli->connect_errno) throw new Exception($mysqli->connect_error);
    // "country".
    if(isset($_GET["ip"]))$ip = $_GET["ip"];
    else $ip = $_SERVER["REMOTE_ADDR"];
    $ip = filter_var($ip, FILTER_VALIDATE_IP);
    if ($ip) {
        
        $query = "SELECT locId FROM LocId WHERE INET_ATON('".$ip."') BETWEEN StartIpNum AND EndIpNum LIMIT 1;";
        
        $result = $mysqli->query($query);
        
        $row = $result->fetch_assoc();
    
        
        if(count($row))
        {
            if(isset($row['locId']))
            {
               $query = "SELECT city FROM City WHERE locId = ".$row['locId']." LIMIT 1;"; 
               $result = $mysqli->query($query);
        
               $row = $result->fetch_assoc();
   
                if(count($row) && isset($row['city']))
                {
                    $city = htmlentities($row['city']);
                }
                else throw new Exception("Zu der IP $ip kann ich leider keinen Ort ermtteln.");
            }
        }
        else throw new Exception ("Zur IP $ip habe ich leider keine Geo-Daten.");
        
        
    } else {
        throw new Exception;
    }
    
    
   if(isset($city)) print_r($city);
   else  print('In deiner N&auml;he');



} catch (Exception $e) {

    print $e->getMessage();
}



$mysqli->close();