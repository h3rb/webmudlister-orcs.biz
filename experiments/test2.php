<?php

 $path="/home/locke/public_html/webmudlister/experiments/";

 $domain="somedomain1234567890.not";

 $res=exec( $path . "hostcheck $domain 23" ) . '<br>';
 echo $res;

 $domain="www.yahoo.com";

 echo exec( $path . "hostcheck $domain 23" );


?>
