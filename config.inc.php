<?php

 define( path, "/home/locke/public_html/webmudlister/" ); // path to this folder, must end in /
 define( prefix, "http://nimud.divineright.org/webmudlister/" );  // url prefix to your list

 // Who owns it
 define( ADMIN_NAME, "DivineRight" );

 // Name of the lists
 define( GRAVEYARD_TITLE, "The MUD Graveyard" );
 define( MUDLIST_TITLE, ADMIN_NAME . "'s Totally Telnet Games List" );
 define( MUDLIST_NICK, "Big List" );
 define( GRAVEYARD_NICK, "Graveyard" );

 // File settings
 define( MUDLIST, "lists/big.txt" );
 define( GRAVEYARD, "lists/graveyard.txt" );
 define( MUDLIST_BACKUP, "lists/big.bak" );
 define( GRAVEYARD_BACKUP, "lists/graveyard.bak" );
 define( LAST_SUNDAY_MUDLIST_BACKUP, "lists/last_sunday_big.txt" );
 define( LAST_SUNDAY_GRAVEYARD_BACKUP, "lists/last_sunday_graveyard.txt" );
 define( PRE_CACHE, true );   // save validated MUD front doors and don't validate on-demand
 define( SORT_AZ, true );     // sorts the listings A-Z instead of first-come-first-serve

 // Time settings
 define( DAYS_TIL_DOWN,        30 );
 define( DAYS_TIL_DECOMPOSED,  90 );

 // Network settings
 define( REPORT_NETWORK_ERRORS, false );

 // Flash Term options

 // recommended: requires you to install the flash socket services - see install.txt 
 define( USE_FLASHTERM, true );
 define( FLASH_SERVER, "rayne.divineright.org" );
 define( FLASH_PORT, 5335 );

 // ANSI Support Options

 // not recommended: attempts to strip ansi codes from mud banners
 define( STRIP_ANSI, false  ); 

 // not recommended: converts a basic set of ANSI codes without stacking common to many MUDs
 define( USE_CHEAP_ANSITOHTML, false );

 // recommended: requires you to install the stuff in perl/ as per install.txt
 define( USE_HTMLFROMANSI, false );  

 // true here changes license to GPL v2 and requires you to stick ansilove-php
 // into a folder inside the webmudlister root dir called /ansilove
 define( USE_ANSILOVE, true );    
 define( ansi_love_path, "ansilove-php/" );
?>
