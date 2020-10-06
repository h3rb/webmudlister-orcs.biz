<?php
 include ( 'config.php' );
 include ( 'banner.php' );
 include ( 'html.php'   );
 include ( 'atomic.php' );
 if ( isset($_GET['host']) ) {
  $host=urldecode($_GET['host']);
  $i=0;
  $mudlist=explode( "\n", file_get_contents( MUDLIST ));
  if (SORT_AZ && !isset($_GET['submitted']) ) sort($mudlist);
  $shown=0;
  foreach ( $mudlist as $mud ) {
   $i++;
   $showing=$i;
   $mud=explode("|",$mud);
   if ( stripos($mud[1],$host) !== FALSE ) {
    if ( USE_FLASHTERM ) $mud[4]=' <a href="flashterm/connect.php?id='.$showing.'">Connect!</a>';
    else $mud[4]='';
    if ( $shown == 0 ) {
     echo html( "html/pagestart.html", array("###"), array("css/mud.css") );
     echo html( "html/mud.html", array ( "#name#", "#host#", "#port#", "#site#", "#flash#" ), $mud );
     $shown++;
    }
    $res="";
    if ( PRE_CACHE && file_exists("cache/" . $mud[1] . '.' . $mud[2]) ) $res = file_get_contents( "cache/" . $mud[1] . '.' . $mud[2], $res );
    else if ( PRE_CACHE || !strlen($res) ) { $res = mud_validate( $mud[1], $mud[2] ); file_put_contents_atomic( "cache/" . $mud[1] . '.' . $mud[2], $res ); }
    echo ansiout($mud);
   }
   if ( $shown > 0 ) { echo html( "html/pageend.html" ); die; }
  }
 } else
 if ( isset($_GET['name']) ) {
  $name=urldecode($_GET['name']);
  $i=0;
  $mudlist=explode( "\n", file_get_contents( MUDLIST ));
  if (SORT_AZ && !isset($_GET['submitted']) ) sort($mudlist);
  foreach ( $mudlist as $mud ) if ( strlen($mud) > 0 ) {
   $i++;
   $showing=$i;
   $mud=explode("|",$mud);
   if ( stripos($mud[0],$name) !== FALSE ) {
    if ( USE_FLASHTERM ) $mud[4]=' <a href="flashterm/connect.php?id='.$showing.'">Connect!</a>';
    else $mud[4]='';
    if ( $shown == 0 ) {
     echo html( "html/pagestart.html", array("###"), array("css/mud.css") );
     echo html( "html/mud.html", array ( "#name#", "#host#", "#port#", "#site#", "#flash#" ), $mud );
     $shown++;
    }
    $res="";
    if ( PRE_CACHE && file_exists("cache/" . $mud[1] . '.' . $mud[2]) ) $res = file_get_contents( "cache/" . $mud[1] . '.' . $mud[2], $res );
    else if ( PRE_CACHE || !strlen($res) ) { $res = mud_validate( $mud[1], $mud[2] ); file_put_contents_atomic( "cache/" . $mud[1] . '.' . $mud[2], $res ); }
    echo ansiout($mud);
   }
  }
  if ( $shown > 0 ) { echo html( "html/pageend.html" ); die; }
 } else {
  $showing=intval($_GET['id']);
  $i=0;
  $mudlist=explode( "\n", file_get_contents( MUDLIST ));
  if (SORT_AZ && !isset($_GET['submitted']) ) sort($mudlist);
  foreach ( $mudlist as $mud ) if ( $i++ == $showing ) {
   $mud=explode("|",$mud);
   if ( USE_FLASHTERM ) $mud[4]=' <a href="flashterm/connect.php?id='.$showing.'">Connect!</a>';
   else $mud[4]='';
   echo html( "html/pagestart.html", array("###"), array("css/mud.css") );
   echo html( "html/mud.html", array ( "#name#", "#host#", "#port#", "#site#", "#flash#" ), $mud );
   $res="";
   if ( PRE_CACHE && file_exists("cache/" . $mud[1] . '.' . $mud[2]) ) $res = file_get_contents( "cache/" . $mud[1] . '.' . $mud[2], $res );
   else if ( PRE_CACHE || !strlen($res) ) { $res = mud_validate( $mud[1], $mud[2] ); file_put_contents_atomic( "cache/" . $mud[1] . '.' . $mud[2], $res ); }
   echo ansiout($mud);
   echo html( "html/pageend.html" );
   die();
  }
 }
 echo html( "html/pagestart.html" );
 echo 'Not found.';
 echo html( "html/pageend.html" );
?>
