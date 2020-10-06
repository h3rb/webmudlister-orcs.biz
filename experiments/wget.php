<?php
 function wget_mud_validate($domain,$port) {
 echo exec( "chmod 0777 mud.html*" );
 echo exec( "rm -rf mud.html*" );
 // this works!
 $line= 
"nohup wget -q http://$domain:$port --timeout=1 --tries=1 --output-document=mud.html --output-file=result.log &";
 echo $line;
 echo exec($line);
 sleep(2);
 if ( !file_exists("mud.html" ) ) return "FAIL";
 $output=str_replace( "\r", "", str_replace( "\n", "<br>", file_get_contents("mud.html") ) );
 $output=str_replace("GET / HTTP/1.0","",$output);
 $output=substr($output, 0, $where=strpos($output,"get/") );
 return $output;
 }
// $output=substr( $output, $ga=strrchr( chr(249), $output ), strlen($output)-$ga );
 echo '<pre>'. wget_mud_validate("nimud.divineright.org",5333)  . '</pre>';

?>
