<?php
 include ( 'config.php' );
 include ( 'banner.php' );
 include ( 'html.php'   );
 include ( 'atomic.php' );
 $showing=intval($_GET['id']);
 $i=0;
 $mudlist=explode( "\n", file_get_contents( GRAVEYARD ));
 foreach ( $mudlist as $mud ) if ( $i++ == $showing ) {
  $mud=explode("|",$mud); $mud[0]="The tomb of " . $mud[0] . ' ... Died: ' . date("r",$mud[4]); $mud[4]='';
  echo html( "html/pagestart.html", array("###"), array("css/mud.css") );
  echo html( "html/mud.html", array ( "#name#", "#host#", "#port#", "#site#", "#flash#" ), $mud );
  $res="";
  if ( PRE_CACHE && file_exists("cache/" . $mud[1] . '.' . $mud[2]) ) $res = file_get_contents( "cache/" . $mud[1] . '.' . $mud[2], $res );
  echo ansiout($mud);
  echo html( "html/pageend.html" );
  die();
 }
?>
