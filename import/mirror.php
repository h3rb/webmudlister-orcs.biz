#!/usr/local/bin/php
<?php
 chdir('/var/www/orcs.biz/mud/list/import');
 include '../atomic.php';
 $merge=true;
 $sources=array();
// $sources=array( "http://local.adventure-inn.com/webmudlister/lists/big.txt" => "../lists/local.adventure-inn.com" );
// $sources=array( "http://nimud.divineright.org/webmudlister/lists/big.txt" => "../lists/nimud.divineright.org" );
 foreach ( $sources as $source=>$target ) {
  $log=file_get_contents( "mirror.log" );
  // Grabs a copy of the default list from us, you could call this instead of/before cron.php nightly, set above to be true to auto-merge
  unlink($target);
  exec( " wget -q $source --output-document=$target --output-file=mirror.log " );
  $log.=file_get_contents( "mirror.log" );
  file_put_contents_atomic( "mirror.log", $log );
  if ( $merge===true ) {
   function mud_in_list_mirror( $name, $host, $resolved, $port, $site, $item ) {
    $ip1=$resolved;
    $ip2=$item['host'];
    if ( (!strcmp($ip1,$ip2)||strtolower(trim($host))==strtolower(trim($item[1]))) && intval($port) == intval($item[2]) ) return true;
    return false;
   }
   $mud=array(); $i=0;
   $muds=explode("\n",$list=file_get_contents( "../lists/big.txt" ));
   foreach ( $muds as $m ) { $mud[$i]=explode("|",$m); $mud[$i]['host']=gethostbyname($mud[$i][1]); $i++; }
   file_put_contents_atomic( "../lists/big.premirror", file_get_contents( "../lists/big.txt" ) );
   while ( file_exists( "../cache/lock.file" ) ) echo 'Locked by another process.';
   file_put_contents( "../cache/lock.file", "Locked by import/mirror.php" );
   exec( "chmod 777 ../cache/lock.file" );
   $got=explode("\n",file_get_contents( $target ));
   $notes="";
   $append=""; $added=0;
   foreach ( $got as $g ) {
    if ( strlen(trim($g)) < 1 ) continue;
    $og=$g; $g=explode("|",$og);
    $resolved=gethostbyname($g[1]);
    $found=false;
    foreach ( $mud as $m ) if ( mud_in_list_mirror( $g[0], $g[1], $resolved, $g[2], $g[3], $m ) ) $found=true;
    if ( !$found ) {
     $append.=$og."\n"; $added++; $notes.=$og;
    }
   }
   file_put_contents_atomic( "../lists/big.txt", $list . $append ); date_default_timezone_set('UTC');
   file_put_contents_atomic( "mirror.log", file_get_contents( "mirror.log" ) . "\n" . $notes . date("r") . "\n--> $added added \n" );
   exec( "rm ../cache/lock.file" );
  }
 }
?>
