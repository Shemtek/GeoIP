<?php

if (strpos($_SERVER["SERVER_NAME"], "www.geoip.local") !== false) define('SERVER', 0); 
else define('SERVER', 1); 

define('CFG_USER', SERVER ? 'root'	: 'root');
define('CFG_PASS', SERVER ? '': '');
define('CFG_DB', SERVER ? 'geoip': 'geoip');
define('CFG_MYSQL',SERVER ? ':/cloudsql/canvas-epigram-758:geo'	: '127.0.0.1:3306');

try {
    
    if(!SERVER)
    {
    $ipnum = 33996344;
 
    $o1 = ($ipnum / 16777216 ) % 256;
    $o2 = ($ipnum / 65536    ) % 256;
    $o3 = ($ipnum / 256      ) % 256;
    $o4 = ($ipnum            ) % 256;
 
    print( $o1.'.'. $o2.'.'. $o3.'.'. $o4 );
    }
    // DB Connection
    // Using MySQL API (connecting from APp Engine)
    $conn = mysql_connect(CFG_MYSQL,
    CFG_USER, // username
    CFG_PASS // password
    );
    
    
    mysql_select_db(CFG_DB, $conn);
    
    // "country".
    if(isset($_GET["ip"]))$ip = $_GET["ip"];
    else $ip = $_SERVER["REMOTE_ADDR"];
    $ip = filter_var($ip, FILTER_VALIDATE_IP);
    if ($ip) {
        
        $query = "SELECT locId FROM LocId WHERE INET_ATON('".$ip."') BETWEEN StartIpNum AND EndIpNum LIMIT 1;";
        
        $result = mysql_query($query, $conn);
        if(mysql_error()) throw new Exception;
        if(isset($result))
        {
            $locid = mysql_fetch_array($result, MYSQL_ASSOC);
            if(isset($locid['locId']))
            {
               $query = "SELECT city FROM City WHERE locId = ".$locid['locId']." LIMIT 1;"; 
               $result = mysql_query($query, $conn);
               if(mysql_error()) throw new Exception;
                if(isset($result))
                {
                    $city = mysql_fetch_array($result, MYSQL_ASSOC);
                }
            }
        }
        
        
    } else {
        throw new Exception;
    }
    
    
   



} catch (Exception $e) {
    print('In deiner N&auml;he');
    print $e->getMessage();
    print mysql_error();
}

if(isset($city)) print_r($city);

mysql_close($conn);