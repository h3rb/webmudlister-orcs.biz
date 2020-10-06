<?php

 $hostname="nimud.divineright.org";
 $port=5333;

 $output=system( "curl telnet://$hostname:$port" );
 echo $output;
?>
