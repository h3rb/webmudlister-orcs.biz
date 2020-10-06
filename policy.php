<?php
 require( 'config.php' );
 require( 'html.php' );

 echo html( "html/pagestart.html" );
 echo html( "html/policy.html", array( "#listname#", "#listnick#", "#graveyard#", "#gravenick#", "#downtime#", "#revival#" ), 
                                array( MUDLIST_TITLE, MUDLIST_NICK, GRAVEYARD_TITLE, GRAVEYARD_NICK, DAYS_TIL_DOWN, DAYS_TIL_DECOMPOSED ) );
 echo html( "html/pageend.html" );

?>
