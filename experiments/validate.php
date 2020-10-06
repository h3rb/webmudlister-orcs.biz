<?php

function mud_validate($host, $port, $report=false) {

require_once "php-telnet/PHPTelnet.php";

$telnet = new PHPTelnet();
$telnet->show_connect_error=0;

// if the first argument to Connect is blank,
// PHPTelnet will connect to the local host via 127.0.0.1
$result = $telnet->Connect($host,$port,'','');//'login name','password');

if (  $report ) 
switch ($result) {
case 0:
$telnet->DoCommand('enter command here', $result);
// NOTE: $result may contain newlines
echo $result;
$telnet->DoCommand('another command', $result);
echo $result;
// say Disconnect(0); to break the connection without explicitly logging out
$telnet->Disconnect();
break;
case 1:
echo '[PHP Telnet] Connect failed: Unable to open network connection';
break;
case 2:
echo '[PHP Telnet] Connect failed: Unknown host';
break;
case 3:
echo '[PHP Telnet] Connect failed: Login failed';
break;
case 4:
echo '[PHP Telnet] Connect failed: Your PHP version does not support PHP 
Telnet';
break;
}

return $result;
}


echo mud_validate("rayne.divineright.org",5333);
?>

