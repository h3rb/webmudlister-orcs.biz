<?php

  include "banner.php";

  $res= mud_validate( "nimud.divineright.org", 5333 );

  if ( $res=="NONE" ) echo '<p>Couldn\'t connect to the MUD.</p>';
  else if ( $res=="BADHOST" ) echo '<p>The host name was invalid.</p>';
  else {
  $output=str_replace( "\r", "", str_replace( "\n", "<br>", $res ) );

  if ( STRIP_ANSI ) {
  }
  else if ( USE_CHEAP_ANSITOHTML ) {
  }
  else if ( USE_HTMLFROMANSI ) {
  }
  else if ( USE_ANSILOVE ) {
  }
  else echo "<pre>$output</pre>";


?>
