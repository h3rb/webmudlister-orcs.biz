#!/usr/local/bin/php
<?php
 chdir('/var/www/orcs.biz/mud/list/');
 require('config.php');
 require('banner.php');
 require('atomic.php');
 $graveyard=array();
 $recently_deceased=array(); $bodies=0;
 $mudlist=array();
 file_put_contents_atomic( MUDLIST_BACKUP, file_get_contents( MUDLIST ) );
 file_put_contents_atomic( GRAVEYARD_BACKUP, file_get_contents( GRAVEYARD_BACKUP ) );
 if ( intval(date("N")) == 7 ) { 
  file_put_contents_atomic( LAST_SUNDAY_MUDLIST_BACKUP, file_get_contents( MUDLIST ) );
  file_put_contents_atomic( LAST_SUNDAY_GRAVEYARD_BACKUP, file_get_contents( GRAVEYARD_BACKUP ) );
 }
 while ( file_exists( "cache/lock.file" ) );
 file_put_contents( "cache/lock.file", "Locked by cron.php" );
 exec( "chmod 777 cache/lock.file" );
 $list     =explode("\n",file_get_contents( MUDLIST ));
 $i=-1; foreach ( $list   as $item ) if ( strlen($item) > 0 ) { $i++; $mudlist[$i]=explode("|",$item); }
 $graves   =explode("\n",file_get_contents( GRAVEYARD ));
 $i=-1; foreach ( $graves as $item ) if ( strlen($item) > 0 ) { $i++; $graveyard[$i]=explode("|",$item); }
 $output="";
 foreach ( $mudlist as $item ) if ( strlen($item[0]) > 1 ) {
  $res=mud_validate( $item[1], $item[2], true );
  $last=intval($item[4]);
  if ( $last == 0 ) {
   if ( !strcmp($res,"NOLIST") || !strcmp($res,"BADHOST") || !strcmp($res,"NONE") || !($res===true) ) {
    $item[4]=strtotime('now');
    $output.=$item[0].'|'.$item[1].'|'.$item[2].'|'.$item[3].'|'.$item[4]."\n";
    echo 'Failed to connect ' . $res . ' on ' . $item[0] . ' : ' . $item[1] . ' ' . $item[2] . "\n";
   }
   else // connected
   $output.=$item[0].'|'.$item[1].'|'.$item[2].'|'.$item[3].'|'."0"."\n";
  }
  else {
   echo 'Checking possibly dead ' . $item[0] . ' - ' . $item[1] . ' ' . $item[2] . "\n";
   if ( !strcmp($res,"NOLIST") || !strcmp($res,"BADHOST") || !strcmp($res,"NONE") || !($res===true) ) {
//         &&( mktime()-$last > intval(DAYS_TIL_DOWN*24*60*60) ) ) {
    $recently_deceased[$bodies++]=$item;
    echo 'Died: Failed to connect for ' . DAYS_TIL_DOWN . ' days ' . $res . ' on ' . $item[0] . ' : ' . $item[1] . ' ' . $item[2] . "\n";
   }
   else // connected
   $output.=$item[0].'|'.$item[1].'|'.$item[2].'|'.$item[3].'|'."0"."\n";
  }
 }
 $living=$output;
 $revived=$rotting="";
 foreach ( $graveyard as $item ) if ( strlen($item[0]) > 1 ) { // if ( mktime()-intval($item[4]) > intval(DAYS_TIL_DECOMPOSED*24*60*60) ) {
  echo 'Checking grave ' . $item[0] . ' - ' . $item[1] . ' ' . $item[2] . "\n";
  $res=mud_validate( $item[1], $item[2], true );
  if ( !strcmp($res,"NOLIST") || !strcmp($res,"BADHOST") || !strcmp($res,"NONE") || !($res===true) )
  {
   echo 'Still DOA' . "\n";
   $rotting.=$item[0].'|'.$item[1].'|'.$item[2].'|'.$item[3].'|'.$item[4]."\n";
  }
  else {
   echo 'Reborn!' . "\n";
   $revived.=$item[0].'|'.$item[1].'|'.$item[2].'|'.$item[3].'|'."0"."\n";
  }
 }
 file_put_contents_atomic( MUDLIST, $living . $revived );
 foreach ( $recently_deceased as $corpse ) $rotting.=$corpse[0].'|'.$corpse[1].'|'.$corpse[2].'|'.$corpse[3].'|'.strtotime('now')."\n";
 $graves=$rotting;
 file_put_contents_atomic( GRAVEYARD, $graves );
 unlink( "cache/lock.file" );

 echo 'DONE!'.PHP_EOL;
?>
