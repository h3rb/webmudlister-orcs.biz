<?php
 require('config.php');
 require('banner.php');
 require('html.php');
 require('atomic.php');
 error_reporting(E_ALL);
 $graveyard=array();
 $mudlist=array();
 function mud_in_list( $name, $host, $resolved, $port, $site, $item ) {
  $ip1=$resolved;
  $ip2=@gethostbyname($item[1]);
  if ( (!strcmp($ip1,$ip2)||strtolower(trim($host))==strtolower(trim($item[1]))) && intval($port) == intval($item[2]) ) return true;
  return false;
 }
 if ( count($_POST) > 1 ) {
  $list     =explode("\n",file_get_contents( MUDLIST ));
  $ids=count($list);
  $i=-1; foreach ( $list   as $item ) if ( strlen($item) > 0 ) { $i++; $mudlist[$i]=explode("|",$item); }
  $graves   =explode("\n",file_get_contents( GRAVEYARD ));
  $i=-1; foreach ( $graves as $item ) if ( strlen($item) > 0 ) { $i++; $graveyard[$i]=explode("|",$item); }
  $name=str_replace( "\'", "'", str_replace("|",":",trim($_POST['name'])));
  $host=str_replace( "telnet: ","",str_replace("telnet ","",str_replace("|",".",str_replace("telnet://","",trim($_POST['host'])))));
  $resolved=@gethostbyname($host);
  $port=explode(" ",$host);
  if ( count($port) == 2 && is_numeric($port[1]) ) { $host=$port[0]; $port=intval($port[1]); }
  else if ( count($port) == 3 && strtolower($port[1])=="port" && is_numeric($port[2]) ) { $host=$port[0]; $port=intval($port[2]); }
  else if ( substr_count($host,":") ==1 ) {   $inline=explode(":",$host);   $host=$inline[0];   $port=intval($inline[1]);  }
  else $port=intval(trim($_POST['port']));
  if ( ($port < 1000 && !($port === 23) && $port!=443 && $port!=347) || $port==8081 ) $port=0;
  $site=str_replace(" ","",str_replace("|","/",trim($_POST['site'])));
  if ( strlen($site) > 0 && !stristr($site,"http://") ) $site="http://".$site;
  if ( strlen($name) == 0 || strlen($host) == 0 || $port == 0 ) {
   if ( !headers_sent() ) echo html( "html/pagestart.html" );
   echo html( "html/duh.html",  array( "###" ), array( "To be listed, the MUD needs a valid name, port and host." ) );
   echo html( "html/pageend.html" );
   die();
  }
  if ( is_array($mudlist) && count($mudlist) > 0 )
  foreach ( $mudlist as $item ) {
   if ( mud_in_list( $name, $host, $resolved, $port, $site, $item ) === true ) {
    if ( !headers_sent() ) echo html( "html/pagestart.html" );
    echo html( "html/already.html",  array ( "#1#", "#2#" ), array( $host . ' ' . $port, $item[0] ) );
    echo html( "html/pageend.html" );
    die();
   }
  }
  $res=mud_validate( $host, $port );
  if ( strstr($res,"NOLIST") ) {
   echo html( "html/pagestart.html" );
   echo html( "html/nolist.html",  array( "###" ),  array ( "I'm sorry but that MUD's administrators don't want it listed." ) );
  }
  else if ( strstr($res,"BADHOST") ) {
   if ( !headers_sent() ) echo html( "html/pagestart.html" );
   echo html( "html/badhost.html",  array( "###" ),  array( $host ) );
  }
  else if ( strstr($res,"NONE") ) {
   if ( !headers_sent() ) echo html( "html/pagestart.html" );
   echo html( "html/none.html",     array( "###" ),  array( $host ) );
  } else {
   if ( is_array($graveyard) && count($graveyard) > 0 ) 
   foreach ( $graveyard as $item ) {
    if ( mud_in_list( $name, $host, $resolved, $port, $site, $item ) === false ) {
     if ( !headers_sent() ) echo html( "html/pagestart.html" );
     echo html( "html/revived.html",  array( "###" ),  array( $name )  );
     $output="";
     foreach ( $graveyard as $item ) if ( strlen($item[0]) > 0 )
      if ( !( !strcasecmp($host,$item[0]) && !strcasecmp($port,$item[1]) ) ) $output.=$item[0].'|'.$item[1].'|'.$item[2].'|'.$item[3].'|'."0"."\n";
     file_put_contents_atomic( GRAVEYARD, $output );
     $output="";
     foreach ( $mudlist as $item ) if ( strlen($item[0]) > 0 ) $output.=$item[0].'|'.$item[1].'|'.$item[2].'|'.$item[3].'|'."0"."\n";
     $output.=$name.'|'.$host.'|'.$port.'|'.$site.'|'."0"."\n";
     file_put_contents_atomic( MUDLIST, $output );
     echo html( "html/pageend.html" );
     die();
    }
   }
   $output="";
   foreach ( $mudlist as $item ) if ( strlen($item[0]) > 0 ) $output.=$item[0].'|'.$item[1].'|'.$item[2].'|'.$item[3].'|'."0"."\n";
   $output.=$name.'|'.$host.'|'.$port.'|'.$site.'|'."0"."\n";
   file_put_contents_atomic( MUDLIST, $output );
   if ( !headers_sent() ) echo html( "html/pagestart.html" );
   echo html( "html/added.html",  array( "###", "#id#" ), array( $name, $ids-1 ) );
   echo '<script type="text/javascript"> setTimeout( function() { alert("Added to list."); window.location="list.php"; }, 2000 );</script>';
   echo html( "html/pageend.html" );
   die();
  }
 }
 if ( !headers_sent() ) echo html( "html/pagestart.html" );
 if ( file_exists( "cache/lock.file" ) ) echo html( "<br><b>Site is currently undergoing maintenance, so you can't add any new ones - check back in an hour.</b><br>" );
 else echo html( "html/form.html" );
 echo html( "html/pageend.html" );
?>
