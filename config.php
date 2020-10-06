<?php

 error_reporting(0);

 define( path, "/var/www/orcs.biz/mud/list" ); // path to this folder, must end in /
 define( prefix, "http://orcs.biz/mud/list/" );  // url prefix to your list
 define( ansi_images, path."/ansi_images/" );
 define( ansi_cache,  path."/cache/" );
 define( ansilove,    path.'/ansilove-php/ansilove' );

 // Who owns it
 define( ADMIN_NAME, "Orcs.biz" );

 // Name of the lists
 define( GRAVEYARD_TITLE, "The MUD Graveyard" );
 define( MUDLIST_TITLE, 'Telnet Games' ); // '<a href="http://orcs.biz"><img src="http://orcs.biz/i/orcsm.png" border=0></a> Mud List' );
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
 define( USE_FLASHTERM, false );
 define( FLASH_SERVER, "orcs.biz" );
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
 define( USE_ANSILOVE_CACHE, true );
 define( MIX_UP_FONTS, true );
 define( USE_ANSILOVE, true );
 define( ansi_love_path, "ansilove-php/" );
 define( ANSI_DIGEST, false ); // requires a ton of memory

 function greetfile( $m ) { return $m[1].'.'.$m[2]; }
 function greetcache( $m ) { return ansi_cache.greetfile($m); }
 function ansipng( $m ) { return ansi_images.greetfile($m)/*.'.png'*/; }
 function cache_ansi( $m ) {
  $png=ansipng($m);
  $ans=greetcache($m);
  if ( !file_exists($png.'.png') ) {
   if ( defined(MIX_UP_FONTS) )
    switch ( intval(date("N")) ) {
     case 4: case 0: $font="amiga"; break;
     case 5: case 1: $font="russian"; break;
     case 6: case 2: $font="80x50"; break;
     case 7: case 3: $font="80x25"; break;
    default: $font="russian"; break;
    }
    else $font="80x50";
   @system( ansilove.' '.$ans.' -or '.$png.' font='.$font.' > /dev/null' );
  }
  return '<img src="'.str_replace(path.'/','',$png).'.png" border="0">';
 }
 function ansiout( $m ) {
  if ( STRIP_ANSI ) {
   return '';
  } else
  if ( USE_ANSILOVE ) {
   if ( USE_ANSILOVE_CACHE ) {
    return cache_ansi($m);
   } else {
    switch ( intval(date("N")) ) {
     case 4: case 0: $font="amiga"; break;
     case 5: case 1: $font="russian"; break;
     case 6: case 2: $font="80x50"; break;
     case 7: case 3: $font="80x25"; break;
    default: $font="russian"; break;
    }
    return '<img src="'.ansi_love_path.'load_ansi.php?input='.greetcache($m).'&font='.$font.'&icecolors=1">';
   }
  } else return '';
 }

// <table style=ansi text-align=left><tr><td><pre>' . str_replace( "\r", "", str_replace( "\n", "<br>",  $res )) . '</pre></td></tr></table>

?>
