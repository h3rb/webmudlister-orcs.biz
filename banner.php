<?php

require_once('config.php');

ini_set( "max_execution_time", "3" );
set_time_limit(3);

if ( !function_exists('mud_validate') ) {
function mud_validate( $domain, $port, $cron=false ) {

//$ip = gethostbyname($host);
//if(ip2long($ip) == -1 || ($ip == @gethostbyaddr($ip) && preg_match("/.*\.[a-zA-Z]{2,3}$/",$host) == 0) ) 
//     return "BADHOST";

  if ( strlen(path) < 1 ) $path=getcwd().'/experiments/';
  $res=exec(path.'hostcheck '.$domain.' '.$port );
  if ( $res == "BADHOST" ) return $res;

if ( !function_exists('negotiate') ) { 
function negotiate ($socket) {
        socket_recv($socket, $buffer, 8192, 0);

        for ($chr = 0; $chr < strlen($buffer); $chr++) {
                if ($buffer[$chr] == chr(255)) {

                        $send = (isset($send) ? $send . $buffer[$chr] : $buffer[$chr]);

                        $chr++;
                        if (in_array($buffer[$chr], array(chr(251), chr(252)))) $send .= chr(254);
                        if (in_array($buffer[$chr], array(chr(253), chr(254)))) $send .= chr(252);

                        $chr++;
                        $send .= $buffer[$chr];
                } else {
                        break;
                }
        }

        if (isset($send)) socket_send($socket, $send, strlen($send), 0);
        if ($chr - 1 < strlen($buffer)) return substr($buffer, $chr);

}
}

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
$res=@socket_connect($socket, $domain, $port );
if ( !$res ) return "NONE";
if ( $cron ) { socket_close($socket); return true; }
$alreadydid=false;
$b="";
$i=0;
while ($i<6) {
        $r = array($socket);
        $c = socket_select($r, $w = NULL, $e = NULL, 1,2);
        foreach ($r as $read_socket) {
                if ( REPORT_NETWORK_ERRORS ? ($b .= negotiate($read_socket)) : ($b .= @negotiate($read_socket)) ) {
                 if ( !$alreadydid ) {
                  sleep(1);
                  if ( !STRIP_ANSI ) {
                   $alreadydid=true;
                   if ( strpos($b,"ansi, '?' help):") ) socket_write($socket,"\n\r",2); //support for TorilMUD
                   else if ( stripos($b,"charset") ) socket_write($socket,"\n1\n",3); // support for ADAMANT amud.orc.ru
                   else if ( stripos($b,"[] Color Preferences") ) socket_write($socket,"ansi\n\r",6); // support for darkover.isilm.com
                   else if ( stripos($b,"ansi") || stripos($b,"color") ) socket_write($socket,"y\n\r",6); // puts a "y\n" to tell them you want color (most)
                   else if ( stripos($b,"vtt1 login:") ) socket_write($socket,"mudguest\n\r\n\r",10); // mud 2 support
                  }
                  else {
                   $alreadydid=true;
                   if ( strpos($b,"ansi, '?' help):") ) socket_write($socket,"1\n\r",3); //support for TorilMUD
                   else if ( strpos($b,"charset") ) socket_write($socket,"\n1\n",3); // support for ADAMANT amud.orc.ru
                   else if ( strpos($b,"ansi") || strpos($b,"color") ) socket_write($socket,"n\n\r",3); // puts a "n\n" to tell them you don't want color (most)
                   else if ( stripos($b,"vtt1 login:") ) socket_write($socket,"mudguest\n\r\n\r",10); // mud 2 support
                  }
                 }
                }
        }
 $i++;
}

if ( REPORT_NETWORK_ERRORS ) socket_close($socket);
else @socket_close($socket);

return $b;

}
}

?>
